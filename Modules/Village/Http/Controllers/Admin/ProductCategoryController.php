<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\ProductCategory;
use Modules\Village\Repositories\ProductCategoryRepository;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use yajra\Datatables\Engines\EloquentEngine;
use yajra\Datatables\Html\Builder as TableBuilder;

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
            'village__product_categories.village_id',
            'village__product_categories.title',
            'village__product_categories.active',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->join('village__villages', 'village__product_categories.village_id', '=', 'village__villages.id')
            ->with(['village'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village_id', $this->getCurrentUser()->village->id);
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
            ->addColumn(['data' => 'title', 'name' => 'village__product_categories.title', 'title' => $this->trans('table.title')])
            ->addColumn(['data' => 'active', 'name' => 'village__product_categories.active', 'title' => $this->trans('table.active')])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->editColumn('village_name', function (ProductCategory $productCategory) {
                    if ($this->getCurrentUser()->hasAccess('village.villages.edit')) {
                        return '<a href="'.route('admin.village.village.edit', ['id' => $productCategory->village->id]).'">'.$productCategory->village->name.'</a>';
                    }
                    else {
                        return $productCategory->village->name;
                    }
                })
            ;
        }

        $dataTable
            ->addColumn('active', function (ProductCategory $productCategory) {
                if($productCategory->active) {
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
     * @param ProductCategory $productCategory
     *
     * @return mixed
     */
    public function validate(array $data, ProductCategory $productCategory = null)
    {
        $productCategoryId = $productCategory ? $productCategory->id : '';

        $rules = [
            'title' => "required|max:255|unique:village__product_categories,title,{$productCategoryId}",
            'active' => "required|boolean",
        ];

        if ($this->getCurrentUser()->inRole('admin')) {
            $rules['village_id'] = 'required|exists:village__villages,id';
        }

        return Validator::make($data, $rules);
    }
}
