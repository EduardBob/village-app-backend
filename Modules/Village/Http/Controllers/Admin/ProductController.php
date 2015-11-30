<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Media\Entities\File;
use Modules\User\Repositories\RoleRepository;
use Modules\Village\Entities\BaseProduct;
use Modules\Village\Entities\Product;
use Modules\Village\Entities\User;
use Modules\Village\Repositories\ProductCategoryRepository;
use Modules\Village\Repositories\ProductRepository;
use Modules\Village\Entities\ProductCategory;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Village\Repositories\UserRoleRepository;
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
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * @param ProductRepository         $productRepository
     * @param ProductCategoryRepository $categoryRepository
     * @param UserRoleRepository        $roleRepository
     */
    public function __construct(ProductRepository $productRepository, ProductCategoryRepository $categoryRepository, UserRoleRepository $roleRepository)
    {
        parent::__construct($productRepository, Product::class);

        $this->categoryRepository = $categoryRepository;
        $this->roleRepository = $roleRepository;
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
            'village__products.id',
            'village__products.village_id',
            'village__products.category_id',
            'village__products.executor_id',
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
            ->leftJoin('village__villages', 'village__products.village_id', '=', 'village__villages.id')
            ->leftJoin('village__product_categories', 'village__products.category_id', '=', 'village__product_categories.id')
            ->leftJoin('users', 'village__products.executor_id', '=', 'users.id')
            ->where('village__product_categories.deleted_at', null)
            ->where('village__villages.deleted_at', null)
            ->with(['village', 'category', 'executor'])
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
        $builder
            ->addColumn(['data' => 'id', 'title' => $this->trans('table.id')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')])
            ;
        }
        $builder
            ->addColumn(['data' => 'category_title', 'name' => 'village__product_categories.title', 'title' => $this->trans('table.category')])
            ->addColumn(['data' => 'executor_name', 'name' => 'users.last_name', 'title' => $this->trans('table.executor')])
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
            ->editColumn('executor_name', function (Product $product) {
                if (!$product->executor) {
                    return '';
                }

                $name = $product->executor->last_name. ' '.$product->executor->first_name;

                if ($this->getCurrentUser()->hasAccess('user.users.edit')) {
                    return '<a href="'.route('admin.user.user.edit', ['id' => $product->executor->id]).'">'.$name.'</a>';
                }
                else {
                    return $name;
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
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preStore(Model $model, Request $request)
    {
        parent::preStore($model, $request);

        if ($request->get('show_all')) {
            $baseModel = new BaseProduct();
            $data = $model->toArray();
            $data['active'] = 1;
            $baseModel->fill($data);
            $baseModel->save();
        }
    }

    /**
     * @param int $baseId
     *
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function baseCopy($baseId)
    {
        $model = BaseProduct::find($baseId);

        if (!$this->getCurrentUser()->inRole('admin') && !$model->active) {
            return redirect()->route($this->getRoute('index'));
        }

        return view($this->getView('baseCopy'), $this->mergeViewData(compact('model')));
    }

    /**
     * @param array   $data
     * @param Product $product
     *
     * @return Validator
     */
    public function validate(array $data, Product $product = null)
    {
        $rules = [
            'category_id' => 'required|exists:village__product_categories,id',
            'executor_id' => 'sometimes|exists:users,id',
            'title' => "required|max:255",
            'village_id' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
            'unit_title' => 'required|in:'.implode(',', config('village.product.unit.values')),
//            'text' => 'required|max:255',
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
        if (!$this->getCurrentUser()->inRole('admin')){
            if ($this->getCurrentUser()->village) {
                $attributes = ['active' => 1];
            }
        }

        return $this->categoryRepository->lists($attributes, 'title', 'id', ['order' => 'desc']);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getExecutors()
    {
        $role = $this->roleRepository->findBySlug('executor');
        $userIds = [];
        foreach($role->users as $user) {
            $userIds[] = $user->id;
        }

        $users = User
            ::select(['users.id', 'last_name', 'first_name'])
            ->whereIn('id', $userIds)
            ->get()
        ;

        $list = [];
        foreach ($users as $user) {
            $list[$user->id] = $user->present()->fullname();
        }

        return $list;
    }
}
