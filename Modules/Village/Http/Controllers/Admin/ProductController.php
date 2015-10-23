<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\Product;
use Modules\Village\Repositories\ProductCategoryRepository;
use Modules\Village\Repositories\ProductRepository;
use Modules\Village\Entities\ProductCategory;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use yajra\Datatables\Engines\EloquentEngine;
use yajra\Datatables\Html\Builder as TableBuilder;

class ProductController extends AdminController
{
    /**
     * @var ProductCategoryRepository
     */
    protected $categoryRepository;

    /**
     * @param ProductRepository         $productRepository
     * @param ProductCategoryRepository $categoryRepository
     */
    public function __construct(ProductRepository $productRepository, ProductCategoryRepository $categoryRepository)
    {
        parent::__construct($productRepository, Product::class);

        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__products.village_id',
            'village__products.category_id',
            'village__products.title',
            'village__products.price',
            'village__products.unit_title',
            'village__products.active'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->join('village__villages', 'village__products.village_id', '=', 'village__villages.id')
            ->join('village__product_categories', 'village__products.category_id', '=', 'village__product_categories.id')
            ->with(['village', 'category'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__products.village_id', $this->getCurrentUser()->village->id);
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
            ->addColumn(['data' => 'category_title', 'name' => 'village__product_categories.title', 'title' => $this->trans('table.category')])
            ->addColumn(['data' => 'title', 'name' => 'village__products.title', 'title' => $this->trans('table.title')])
            ->addColumn(['data' => 'price', 'name' => 'village__products.price', 'title' => $this->trans('table.price')])
            ->addColumn(['data' => 'unit_title', 'name' => 'village__products.unit_title', 'title' => $this->trans('table.unit_title')])
            ->addColumn(['data' => 'active', 'name' => 'village__products.active', 'title' => $this->trans('table.active')])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->editColumn('village_name', function (Product $product) {
                    if ($this->getCurrentUser()->hasAccess('village.villages.edit')) {
                        return '<a href="'.route('admin.village.village.edit', ['id' => $product->village->id]).'">'.$product->village->name.'</a>';
                    }
                    else {
                        return $product->village->name;
                    }
                })
            ;
        }

        $dataTable
            ->editColumn('category_title', function (Product $product) {
                if ($this->getCurrentUser()->hasAccess('village.productcategories.edit')) {
                    return '<a href="'.route('admin.village.productcategory.edit', ['id' => $product->category->id]).'">'.$product->category->title.'</a>';
                }
                else {
                    return $product->category->title;
                }
            })
            ->addColumn('unit_title', function (Product $product) {
                return $this->trans('form.unit_title.values.'.$product->unit_title);
            })
            ->addColumn('active', function (Product $product) {
                if($product->active) {
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
     * @param Product $product
     *
     * @return Validator
     */
    public function validate(array $data, Product $product = null)
    {
        $productId = $product ? $product->id : '';

        $rules = [
            'category_id' => 'required|exists:village__product_categories,id',
            'title' => "required|max:255|unique:village__products,title,{$productId}",
            'price' => 'required|numeric|min:1',
            'unit_title' => 'required|in:'.implode(',', config('village.product.unit.values')),
//            'text' => 'required|max:255',
            'active' => "required|boolean",
            'comment_label' => 'required|max:50',
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
