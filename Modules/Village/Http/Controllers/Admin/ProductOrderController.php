<?php namespace Modules\Village\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Village\Entities\ProductOrder;
use Modules\Village\Repositories\ProductOrderRepository;
use Modules\Village\Entities\Product;
use Modules\Village\Repositories\ProductRepository;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use yajra\Datatables\Engines\EloquentEngine;
use yajra\Datatables\Html\Builder as TableBuilder;

class ProductOrderController extends AdminController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @param ProductOrderRepository $productOrderRepository
     * @param ProductRepository      $productRepository
     */
    public function __construct(ProductOrderRepository $productOrderRepository, ProductRepository $productRepository)
    {
        parent::__construct($productOrderRepository, ProductOrder::class);

        $this->productRepository = $productRepository;
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'productorders';
    }

    /**
     * @inheritdoc
     */
    public function store(Request $request)
    {
        $request['status'] = 'processing';

        return parent::store($request);
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__product_orders.id',
            'village__product_orders.village_id',
            'village__product_orders.product_id',
            'village__product_orders.user_id',
            'village__product_orders.quantity',
            'village__product_orders.unit_title',
            'village__product_orders.perform_at',
            'village__product_orders.price',
            'village__product_orders.status',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->join('village__villages', 'village__product_orders.village_id', '=', 'village__villages.id')
            ->join('village__products', 'village__product_orders.product_id', '=', 'village__products.id')
            ->join('users', 'village__product_orders.user_id', '=', 'users.id')
            ->join('village__buildings', 'users.building_id', '=', 'village__buildings.id')
            ->with(['village', 'product', 'user', 'user.building'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__product_orders.village_id', $this->getCurrentUser()->village->id);
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
            ->addColumn(['data' => 'product_title', 'name' => 'village__products.title', 'title' => $this->trans('table.product')])
            ->addColumn(['data' => 'building_address', 'name' => 'village__buildings.address', 'title' => $this->trans('table.address')])
            ->addColumn(['data' => 'quantity', 'name' => 'village__product_orders.quantity', 'title' => $this->trans('table.quantity')])
            ->addColumn(['data' => 'unit_title', 'name' => 'village__product_orders.unit_title', 'title' => $this->trans('table.unit_title')])
            ->addColumn(['data' => 'perform_at', 'name' => 'village__product_orders.perform_at', 'title' => $this->trans('table.perform_at')])
            ->addColumn(['data' => 'price', 'name' => 'village__product_orders.price', 'title' => $this->trans('table.price')])
            ->addColumn(['data' => 'user_name', 'name' => 'users.last_name', 'title' => $this->trans('table.name')])
            ->addColumn(['data' => 'user_phone', 'name' => 'users.phone', 'title' => $this->trans('table.phone')])
            ->addColumn(['data' => 'status', 'name' => 'village__product_orders.status', 'title' => $this->trans('table.status')])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->editColumn('village_name', function (ProductOrder $productOrder) {
                    if ($this->getCurrentUser()->hasAccess('village.villages.edit')) {
                        return '<a href="'.route('admin.village.village.edit', ['id' => $productOrder->village->id]).'">'.$productOrder->village->name.'</a>';
                    }
                    else {
                        return $productOrder->village->name;
                    }
                })
            ;
        }

        $dataTable
            ->editColumn('product_title', function (ProductOrder $productOrder) {
                if ($this->getCurrentUser()->hasAccess('village.products.edit')) {
                    return '<a href="'.route('admin.village.product.edit', ['id' => $productOrder->product->id]).'">'.$productOrder->product->title.'</a>';
                }
                else {
                    return $productOrder->product->title;
                }
            })
            ->editColumn('building_address', function (ProductOrder $productOrder) {
                if ($this->getCurrentUser()->hasAccess('village.buildings.edit')) {
                    return '<a href="'.route('admin.village.building.edit', ['id' => $productOrder->user->building->id]).'">'.$productOrder->user->building->address.'</a>';
                }
                else {
                    return $productOrder->user->building->address;
                }
            })
            ->addColumn('unit_title', function (ProductOrder $productOrder) {
                return $this->trans('form.unit_title.values.'.$productOrder->unit_title);
            })
            ->addColumn('perform_at', function (ProductOrder $productOrder) {
                return Carbon::parse($productOrder->perform_at)->format(config('village.date.format'));
            })
            ->editColumn('user_name', function (ProductOrder $productOrder) {
                $name = $productOrder->user->last_name. ' '.$productOrder->user->first_name;

                if ($this->getCurrentUser()->hasAccess('user.users.edit')) {
                    return '<a href="'.route('admin.user.user.edit', ['id' => $productOrder->user->id]).'">'.$name.'</a>';
                }
                else {
                    return $name;
                }
            })
            ->editColumn('user_phone', function (ProductOrder $productOrder) {
                return $productOrder->user->phone;
            })
            ->editColumn('status', function (ProductOrder $productOrder) {
                return '<span class="label label-'.config('village.order.label.'.$productOrder->status).'">'.$this->trans('form.status.values.'.$productOrder->status).'</span>';
            })
        ;
    }

    /**
     * @param array $data
     *
     * @return Validator
     */
    public function validate(array $data)
    {
        return Validator::make($data, [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:village__products,id',
            'perform_at' => 'required|date|date_format:'.config('village.date.format'),
            'status' => 'required|in:'.implode(',', config('village.order.statuses')),
//            'comment' => 'sometimes|required|string',
            'decline_reason' => 'sometimes|required_if:status,rejected|string',
            'quantity' => 'required|numeric|min:1'
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getProducts()
    {
        if (!method_exists($this->modelClass, 'village') || $this->getCurrentUser()->inRole('admin')){
            return $this->productRepository->lists([], 'title', 'id', ['title' => 'asc']);
        }

        return $this->productRepository->lists(['village_id' => $this->getCurrentUser()->village->id], 'title', 'id', ['title' => 'asc']);
    }
}
