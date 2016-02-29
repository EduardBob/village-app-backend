<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\User\Repositories\RoleRepository;
use Modules\Village\Entities\BaseService;
use Modules\Village\Repositories\ServiceCategoryRepository;
use Modules\Village\Repositories\BaseServiceRepository;
use Modules\Village\Entities\ServiceCategory;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Village\Repositories\UserRoleRepository;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class BaseServiceController extends AdminController
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
     * @param BaseServiceRepository     $baseServiceRepository
     * @param ServiceCategoryRepository $categoryRepository
     * @param UserRoleRepository        $roleRepository
     */
    public function __construct(BaseServiceRepository $baseServiceRepository, ServiceCategoryRepository $categoryRepository, UserRoleRepository $roleRepository)
    {
        parent::__construct($baseServiceRepository, BaseService::class);

        $this->categoryRepository = $categoryRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'baseservices';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__base__services.id',
            'village__base__services.category_id',
            'village__base__services.title',
            'village__base__services.price',
            'village__base__services.active'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->leftJoin('village__service_categories', 'village__base__services.category_id', '=', 'village__service_categories.id')
            ->where('village__service_categories.deleted_at', null)
            ->with(['category'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__base__services.active', 1);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
            ->addColumn(['data' => 'id', 'title' => $this->trans('table.id')])
            ->addColumn(['data' => 'category_title', 'name' => 'village__service_categories.title', 'title' => $this->trans('table.category')])
            ->addColumn(['data' => 'title', 'name' => 'village__base__services.title', 'title' => $this->trans('table.title')])
            ->addColumn(['data' => 'price', 'name' => 'village__base__services.price', 'title' => $this->trans('table.price')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'active', 'name' => 'village__base__services.active', 'title' => $this->trans('table.active')])
            ;
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        $dataTable
            ->editColumn('category_title', function (BaseService $service) {
                if ($this->getCurrentUser()->hasAccess('village.servicecategories.edit')) {
                    return '<a href="'.route('admin.village.servicecategory.edit', ['id' => $service->category->id]).'">'.$service->category->title.'</a>';
                }
                else {
                    return $service->category->title;
                }
            })
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->addColumn('active', function (BaseService $service) {
                    if($service->active) {
                        return '<span class="label label-success">'.trans('village::admin.table.active.yes').'</span>';
                    }
                    else {
                        return '<span class="label label-danger">'.trans('village::admin.table.active.no').'</span>';
                    }
                })
            ;
        }
    }

    /**
     * @param array       $data
     * @param BaseService $service
     *
     * @return Validator
     */
    public function validate(array $data, BaseService $service = null)
    {
        $rules = [
            'category_id' => 'required|exists:village__service_categories,id',
            'title' => "required|max:255",
            'price' => 'required|numeric|min:0', // ноль разрешён http://redmine.fruitware.ru/issues/26453
//            'text' => 'required|max:255',
            'comment_label' => 'required|max:50',
            'order_button_label' => 'required|max:50',
        ];

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
}
