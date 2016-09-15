<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\User\Repositories\RoleRepository;
use Modules\Village\Entities\BaseProduct;
use Modules\Village\Repositories\ProductCategoryRepository;
use Modules\Village\Repositories\BaseProductRepository;
use Modules\Village\Entities\ProductCategory;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Village\Repositories\UserRoleRepository;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class BaseProductController extends AdminController
{
    /**
     * @var ProductCategoryRepository
     */
    protected $categoryRepository;
    /**
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * @param BaseProductRepository     $productRepository
     * @param ProductCategoryRepository $categoryRepository
     * @param UserRoleRepository        $roleRepository
     */
    public function __construct(BaseProductRepository $productRepository, ProductCategoryRepository $categoryRepository, UserRoleRepository $roleRepository)
    {
        parent::__construct($productRepository, BaseProduct::class);

        $this->categoryRepository = $categoryRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'baseproducts';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__base__products.id',
            'village__base__products.category_id',
            'village__base__products.title',
            'village__base__products.price',
            'village__base__products.unit_title',
            'village__base__products.active'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->leftJoin('village__product_categories', 'village__base__products.category_id', '=', 'village__product_categories.id')
            ->where('village__product_categories.deleted_at', null)
            ->with(['category'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__base__products.active', 1);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
            ->addColumn(['data' => 'id', 'name' => 'village__base__products.id', 'title' => $this->trans('table.id')])
        ;

        $builder
            ->addColumn(['data' => 'category_title', 'name' => 'village__product_categories.title', 'title' => $this->trans('table.category')])
            ->addColumn(['data' => 'title', 'name' => 'village__base__products.title', 'title' => $this->trans('table.title')])
            ->addColumn(['data' => 'price', 'name' => 'village__base__products.price', 'title' => $this->trans('table.price')])
            ->addColumn(['data' => 'unit_title', 'name' => 'village__base__products.unit_title', 'title' => $this->trans('table.unit_title')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'active', 'name' => 'village__base__products.active', 'title' => $this->trans('table.active')])
            ;
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        $dataTable
            ->editColumn('category_title', function (BaseProduct $product) {
                if ($this->getCurrentUser()->hasAccess('village.productcategories.edit')) {
                    return '<a href="'.route('admin.village.productcategory.edit', ['id' => $product->category->id]).'">'.$product->category->title.'</a>';
                }
                else {
                    return $product->category->title;
                }
            })
            ->addColumn('unit_title', function (BaseProduct $product) {
                return $this->trans('form.unit_title.values.'.$product->unit_title);
            })
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable->addColumn('active', function (BaseProduct $product) {
                return boolField($product->active);
            });
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
     * @param array   $data
     * @param BaseProduct $product
     *
     * @return Validator
     */
    public function validate(array $data, BaseProduct $product = null)
    {
        $rules = [
            'category_id' => 'required|exists:village__product_categories,id',
            'title' => "required|max:255",
            'price' => 'required|numeric|min:1',
            'unit_title' => 'required|in:'.implode(',', config('village.product.unit.values')),
            'text' => 'required|max:765',
            'active' => "boolean",
            'comment_label' => 'required|max:50',
        ];

        return Validator::make($data, $rules);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCategories()
    {
        $attributes = [];

        return $this->categoryRepository->lists($attributes, 'title', 'id', ['order' => 'desc']);
    }
}
