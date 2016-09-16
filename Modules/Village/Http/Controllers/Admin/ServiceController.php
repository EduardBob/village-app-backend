<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\User\Repositories\RoleRepository;
use Modules\Village\Entities\BaseService;
use Modules\Village\Entities\Service;
use Modules\Village\Entities\ServiceExecutor;
use Modules\Village\Entities\User;
use Modules\Village\Entities\Village;
use Modules\Village\Repositories\ServiceCategoryRepository;
use Modules\Village\Repositories\ServiceRepository;
use Modules\Village\Repositories\UserRoleRepository;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class ServiceController extends AbstractGoodsController
{
    /**
     * @var ServiceCategoryRepository
     */
    private $categoryRepository;
    /**
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * @param ServiceRepository         $serviceRepository
     * @param ServiceCategoryRepository $categoryRepository
     * @param UserRoleRepository        $roleRepository
     */
    public function __construct(ServiceRepository $serviceRepository, ServiceCategoryRepository $categoryRepository, UserRoleRepository $roleRepository)
    {
        parent::__construct($serviceRepository, Service::class);

        $this->categoryRepository = $categoryRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'services';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__services.*',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->leftJoin('village__base__services', 'village__services.base_id', '=', 'village__base__services.id')
            ->leftJoin('village__villages', 'village__services.village_id', '=', 'village__villages.id')
            ->leftJoin('village__service_categories', 'village__services.category_id', '=', 'village__service_categories.id')
            ->where('village__service_categories.deleted_at', null)
            ->where('village__villages.deleted_at', null)
            ->with(['base', 'village', 'category'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__services.village_id', $this->getCurrentUser()->village->id);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
            ->addColumn(['data' => 'id', 'name' => 'village__services.id', 'title' => $this->trans('table.id')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')])
            ;
        }
        $builder
            ->addColumn(['data' => 'category_title', 'name' => 'village__service_categories.title', 'title' => $this->trans('table.category')])
            ->addColumn(['data' => 'title', 'name' => 'village__services.title', 'title' => $this->trans('table.title')])
            ->addColumn(['data' => 'price', 'name' => 'village__services.price', 'title' => $this->trans('table.price')])
            ->addColumn(['data' => 'active', 'name' => 'village__services.active', 'title' => $this->trans('table.active')])
	        ->addColumn(['data' => 'executor', 'name' => 'village__services.id', 'title' => $this->trans('table.executor'), 'orderable' => false, 'searchable' => false])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->editColumn('village_name', function (Service $service) {
                    if ($this->getCurrentUser()->hasAccess('village.villages.edit')) {
                        return '<a href="'.route('admin.village.village.edit', ['id' => $service->village->id]).'">'.$service->village->name.'</a>';
                    }
                    else {
                        return $service->village->name;
                    }
                })
            ;
        }

        $dataTable
            ->editColumn('category_title', function (Service $service) {
                if ($this->getCurrentUser()->hasAccess('village.servicecategories.edit')) {
                    return '<a href="'.route('admin.village.servicecategory.edit', ['id' => $service->category->id]).'">'.$service->category->title.'</a>';
                }
                else {
                    return $service->category->title;
                }
            })
            ->addColumn('active', function (Service $service) {
                return boolField($service->active);
            })
	        ->editColumn('executor', function (Service $service) {
		        $executors = [];
		        foreach ($service->executors as $executor) {
			        $executors[] = $executor->user->present()->fullname();
		        }
		        return implode('<br>', $executors);
	        })
        ;
    }

    /**
     * @inheritdoc
     */
    public function preStore(Model $model, Request $request)
    {
        parent::preStore($model, $request);

        $baseModel = BaseService::find($request->get('base_id'));
        if ($baseModel) {
            $model->base()->associate($baseModel);

            $copiedFields = Service::getRewriteFields();
            foreach ($copiedFields as $copiedField) {
                if ($baseModel->$copiedField == $model->$copiedField) {
                    $model->$copiedField = null;
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function preUpdate(Model $model, Request $request)
    {
        /** @var Service $model */

        parent::preUpdate($model, $request);

        $baseModel = BaseService::find($model->base_id);
        if ($baseModel) {
            $model->base()->associate($baseModel);

            $copiedFields = Service::getRewriteFields();
            foreach ($copiedFields as $copiedField) {
                if ($baseModel->$copiedField == $model->$copiedField) {
                    $model->$copiedField = null;
                }
            }
        }

        $executorIds = $request->get('executors');
        $model->executors()->delete();
        if (is_array($executorIds) && count($executorIds)) {
            $executors = [];
            foreach ($executorIds as $executorId) {
                $executor = new ServiceExecutor();
                $executor->service()->associate($model);
                $executor->user()->associate($executorId);
                $executors[] = $executor;
            }

            $model->executors()->saveMany($executors);
        }

        $this->calculateType($model);
    }

    /**
     * @param Model   $model
     */
    public function preDestroy(Model $model)
    {
        $model->base_id = null;
        $model->save();
    }

    /**
     * @param int $baseId
     *
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function baseCopy($baseId)
    {
        $model = BaseService::find($baseId);

        if (!$this->getCurrentUser()->inRole('admin') && !$model->active) {
            return redirect()->route($this->getRoute('index'));
        }

        return view($this->getView('baseCopy'), $this->mergeViewData(compact('model')));
    }

	/**
	 * @inheritdoc
	 */
	public function successStoreMessage()
	{
		flash()->success(trans('village::admin.messages.you_can_add_image'));
	}

    /**
     * @param array   $data
     * @param Service $service
     *
     * @return Validator
     */
    public function validate(array $data, Service $service = null)
    {
        if (!$this->getCurrentUser()->inRole('admin')) {
            $data['village_id'] = $this->getCurrentUser()->village->id;
        }
        $id = $service ? $service->id : 'null';
        $baseId = isset($data['base_id']) ? $data['base_id'] : @$service->base->id;

        $rules = [
            'category_id' => 'required|exists:village__service_categories,id',
            'title' => "required|max:255",
            'village_id' => 'required|numeric|min:1|unique:village__services,village_id,'.$id.',id,base_id,'.$baseId,
            'price' => 'required|numeric|min:0', // ноль разрешён http://redmine.fruitware.ru/issues/26453
            'text' => 'required|max:765',
            'comment_label' => 'required|max:50',
            'order_button_label' => 'required|max:50',
        ];

//        if ($this->getCurrentUser()->inRole('admin')) {
//            $rules['village_id'] = 'required|exists:village__villages,id';
//        }

        return Validator::make($data, $rules);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCategories()
    {
        $attributes = [];
        if (!$this->getCurrentUser()->inRole('admin')){
            $attributes = ['active' => 1];
        }

        return $this->categoryRepository->lists($attributes, 'title', 'id', ['order' => 'desc']);
    }

    /**
     * @param Service $service
     */
    private function calculateType(Service $service)
    {
        $type = Service::TYPE_DEFAULT;
        foreach ($service->executors as $executor) {
            if ($executor->user->inRole('security')) {
                $type = Service::TYPE_SC;
            }
        }

        $service->type = $type;
    }

    public function getChoicesByVillage($villageId)
    {
        $attributes = [];
        if ($this->getCurrentUser()->inRole('admin')) {
            $attributes['village_id'] = $villageId;
        } else {
            $attributes['village_id'] = $this->getCurrentUser()->village_id;
        }
        if ($villageId == 'all' && $this->getCurrentUser()->inRole('admin')) {
            unset($attributes['village_id']);
        }
        $collection = $this->getRepository()->lists($attributes, 'title', 'id', ['title' => 'ASC']);
        if (\Request::ajax()) {
            return json_encode($collection);
        }
        return $collection;
    }
}
