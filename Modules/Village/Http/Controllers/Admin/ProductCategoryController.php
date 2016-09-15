<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\ProductCategory;
use Modules\Village\Repositories\ProductCategoryRepository;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class ProductCategoryController extends AdminController
{
    /**
     * @param ProductCategoryRepository $productCategory
     */
    public function __construct(ProductCategoryRepository $productCategory)
    {
        parent::__construct($productCategory, ProductCategory::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'productcategories';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__product_categories.id',
            'village__product_categories.title',
            'village__product_categories.order',
            'village__product_categories.active',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
            ->addColumn(['data' => 'id', 'name' => 'village__product_categories.id', 'title' => $this->trans('table.id')])
            ->addColumn(['data' => 'title', 'name' => 'village__product_categories.title', 'title' => $this->trans('table.title')])
            ->addColumn(['data' => 'order', 'name' => 'village__product_categories.order', 'title' => $this->trans('table.order')])
            ->addColumn(['data' => 'active', 'name' => 'village__product_categories.active', 'title' => $this->trans('table.active')])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        $dataTable
            ->addColumn('active', function (ProductCategory $productCategory) {
                return boolField($productCategory->active);
            })
        ;
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
     * @param ProductCategory $productCategory
     *
     * @return mixed
     */
    public function validate(array $data, ProductCategory $productCategory = null)
    {
        $rules = [
            'title' => "required|max:255",
            'active' => "boolean",
        ];

        return Validator::make($data, $rules);
    }
}
