<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\Service;
use Modules\Village\Repositories\ServiceCategoryRepository;
use Modules\Village\Repositories\ServiceRepository;
use Modules\Village\Entities\ServiceCategory;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use yajra\Datatables\Engines\EloquentEngine;
use yajra\Datatables\Html\Builder as TableBuilder;

class ServiceController extends AdminController
{
    /**
     * @var ServiceCategoryRepository
     */
    private $categoryRepository;

    /**
     * @param ServiceRepository         $serviceRepository
     * @param ServiceCategoryRepository $categoryRepository
     */
    public function __construct(ServiceRepository $serviceRepository, ServiceCategoryRepository $categoryRepository)
    {
        parent::__construct($serviceRepository, Service::class);

        $this->categoryRepository = $categoryRepository;
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
            'village__services.id',
            'village__services.village_id',
            'village__services.category_id',
            'village__services.title',
            'village__services.price',
            'village__services.active'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->join('village__villages', 'village__services.village_id', '=', 'village__villages.id')
            ->join('village__service_categories', 'village__services.category_id', '=', 'village__service_categories.id')
            ->with(['village', 'category'])
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
                if($service->active) {
                    return '<span class="label label-success">'.trans('village::admin.table.active.yes').'</span>';
                }
                else {
                    return '<span class="label label-danger">'.trans('village::admin.table.active.no').'</span>';
                }
            })
        ;
    }

    /**
     * @param array   $data
     * @param Service $service
     *
     * @return Validator
     */
    public function validate(array $data, Service $service = null)
    {
        $serviceId = $service ? $service->id : '';

        $rules = [
            'category_id' => 'required|exists:village__service_categories,id',
            'title' => "required|max:255|unique:village__services,title,{$serviceId}",
            'price' => 'required|numeric|min:1',
            'active' => "required|boolean",
//            'text' => 'required|max:255',
            'comment_label' => 'required|max:50',
            'order_button_label' => 'required|max:50',
        ];

        if ($this->getCurrentUser()->inRole('admin')) {
            $rules['village_id'] = 'required|exists:village__villages,id';
        }

        return Validator::make($data, $rules);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCategories()
    {
        if (!method_exists($this->modelClass, 'village') || $this->getCurrentUser()->inRole('admin')){
            return $this->categoryRepository->lists([], 'title', 'id', ['order' => 'desc']);
        }

        return $this->categoryRepository->lists(['village_id' => $this->getCurrentUser()->village->id], 'title', 'id', ['order' => 'desc']);
    }
}
