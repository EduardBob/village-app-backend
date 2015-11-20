<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\ServiceCategory;
use Modules\Village\Repositories\ServiceCategoryRepository;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use yajra\Datatables\Engines\EloquentEngine;
use yajra\Datatables\Html\Builder as TableBuilder;

class ServiceCategoryController extends AdminController
{
    /**
     * @param ServiceCategoryRepository $serviceCategory
     */
    public function __construct(ServiceCategoryRepository $serviceCategory)
    {
        parent::__construct($serviceCategory, ServiceCategory::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'servicecategories';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__service_categories.id',
            'village__service_categories.village_id',
            'village__service_categories.title',
            'village__service_categories.active',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->join('village__villages', 'village__service_categories.village_id', '=', 'village__villages.id')
            ->where('village__villages.deleted_at', null)
            ->with(['village'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__service_categories.village_id', $this->getCurrentUser()->village->id);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
            ->addColumn(['data' => 'id', 'title' => $this->trans('table.id')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')])
            ;
        }
        $builder
            ->addColumn(['data' => 'title', 'name' => 'village__service_categories.title', 'title' => $this->trans('table.title')])
            ->addColumn(['data' => 'active', 'name' => 'village__service_categories.active', 'title' => $this->trans('table.active')])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->editColumn('village_name', function (ServiceCategory $serviceCategory) {
                    if ($this->getCurrentUser()->hasAccess('village.villages.edit')) {
                        return '<a href="'.route('admin.village.village.edit', ['id' => $serviceCategory->village->id]).'">'.$serviceCategory->village->name.'</a>';
                    }
                    else {
                        return $serviceCategory->village->name;
                    }
                })
            ;
        }

        $dataTable
            ->addColumn('active', function (ServiceCategory $serviceCategory) {
                if($serviceCategory->active) {
                    return '<span class="label label-success">'.trans('village::admin.table.active.yes').'</span>';
                }
                else {
                    return '<span class="label label-danger">'.trans('village::admin.table.active.no').'</span>';
                }
            })
        ;
    }

    /**
     * @param array           $data
     * @param ServiceCategory $serviceCategory
     *
     * @return Validator
     */
    public function validate(array $data, ServiceCategory $serviceCategory = null)
    {
        if (!$this->getCurrentUser()->inRole('admin')) {
            $data['village_id'] = $this->getCurrentUser()->village_id;
        }

        $rules = [
            'title' => "required|max:255|unique_with:village__service_categories,village_id",
            'village_id' => 'required',
            'active' => "required|boolean",
        ];

        return Validator::make($data, $rules);
    }
}
