<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\ServiceCategory;
use Modules\Village\Repositories\ServiceCategoryRepository;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

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
            'village__service_categories.title',
            'village__service_categories.order',
            'village__service_categories.active',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->where('village__service_categories.deleted_at', null)
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__service_categories.active', 1);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
            ->addColumn(['data' => 'id', 'name' => 'village__service_categories.id', 'title' => $this->trans('table.id')])
            ->addColumn(['data' => 'title', 'name' => 'village__service_categories.title', 'title' => $this->trans('table.title')])
            ->addColumn(['data' => 'order', 'name' => 'village__service_categories.order', 'title' => $this->trans('table.order')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'active', 'name' => 'village__service_categories.active', 'title' => $this->trans('table.active')])
            ;
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->addColumn('active', function (ServiceCategory $serviceCategory) {
                    return boolField($serviceCategory->active);
                })
            ;
        }
    }

	/**
	 * @inheritdoc
	 */
	public function successStoreMessage()
	{
		flash()->success(trans('village::admin.messages.you_can_add_image'));
	}

    /**
     * @param array           $data
     * @param ServiceCategory $serviceCategory
     *
     * @return Validator
     */
    public function validate(array $data, ServiceCategory $serviceCategory = null)
    {
        $rules = [
            'title' => "required|max:255",
            'active' => "required|boolean",
        ];

        return Validator::make($data, $rules);
    }
}
