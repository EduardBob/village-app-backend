<?php namespace Modules\Village\Http\Controllers\Admin;

use Carbon\Carbon;
use Jenssegers\Date\Date;
use Modules\Village\Entities\ProductOrderChange;
use Modules\Village\Repositories\ProductOrderChangeRepository;
use Modules\Village\Entities\Product;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class ProductOrderChangeController extends AdminController
{
    /**
     * @param ProductOrderChangeRepository $productOrderChangeRepository
     */
    public function __construct(ProductOrderChangeRepository $productOrderChangeRepository)
    {
        parent::__construct($productOrderChangeRepository, ProductOrderChange::class);
    }

    /**
     * @inheritdoc
     */
    public function getViewName()
    {
        return 'productorderchanges';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__product_order_changes.id',
            'village__product_order_changes.order_id',
            'village__product_order_changes.user_id',
            'village__product_order_changes.from_status',
            'village__product_order_changes.to_status',
            'village__product_order_changes.created_at',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->leftJoin('village__product_orders', 'village__product_order_changes.order_id', '=', 'village__product_orders.id')
            ->leftJoin('village__villages', 'village__product_orders.village_id', '=', 'village__villages.id')
            ->leftJoin('village__products', 'village__product_orders.product_id', '=', 'village__products.id')
            ->leftJoin('users', 'village__product_order_changes.user_id', '=', 'users.id')
            ->with(['user', 'order', 'order.village'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__product_orders.village_id', $this->getCurrentUser()->village->id);
        }
        if ($this->getCurrentUser()->inRole('executor')) {
            $query->where('village__products.executor_id', $this->getCurrentUser()->id);
            $query->whereIn('village__product_order_changes.from_status', ['processing', 'running']);
            $query->whereIn('village__product_order_changes.to_status', ['processing', 'running']);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
            ->addColumn(['data' => 'order_id', 'name' => 'village__product_order_changes.order_id', 'title' => $this->trans('table.order')])
        ;

        $builder
            ->addColumn(['data' => 'from_status', 'name' => 'village__product_order_changes.from_status', 'title' => $this->trans('table.from_status')])
            ->addColumn(['data' => 'to_status', 'name' => 'village__product_order_changes.to_status', 'title' => $this->trans('table.to_status')])
            ->addColumn(['data' => 'created_at', 'name' => 'village__product_order_changes.created_at', 'title' => $this->trans('table.created_at')])
            ->addColumn(['data' => 'user_name', 'name' => 'users.last_name', 'title' => $this->trans('table.user')])
//            ->addColumn(['data' => 'product_title', 'name' => 'village__products.title', 'title' => $this->trans('table.product')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')])
            ;
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        $dataTable->overrideGlobalSearch(function($parameters) use ($dataTable){
                $orderId = (int)\Request::get('search')['value'];
                if (!$orderId) return;

                $dataTable
                    ->getQueryBuilder()
                    ->where('village__product_order_changes.order_id', (int)\Request::get('search')['value'])
                ;
        }, []);

        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->editColumn('village_name', function (ProductOrderChange $productOrderChange) {
                    if ($this->getCurrentUser()->hasAccess('village.villages.edit')) {
                        return '<a href="'.route('admin.village.village.edit', ['id' => $productOrderChange->order->village->id]).'">'.$productOrderChange->order->village->name.'</a>';
                    }
                    else {
                        return $productOrderChange->order->village->name;
                    }
                })
            ;
        }

        $dataTable
            ->editColumn('order_id', function (ProductOrderChange $productOrderChange) {
                if ($this->getCurrentUser()->hasAccess('village.productorders.edit')) {
                    return '<a href="'.route('admin.village.productorder.edit', ['id' => $productOrderChange->order->id]).'">'.$productOrderChange->order->id.'</a>';
                }
                else {
                    return $productOrderChange->order->id;
                }
            })
            ->editColumn('product_title', function (ProductOrderChange $productOrderChange) {
                if ($this->getCurrentUser()->hasAccess('village.products.edit')) {
                    return '<a href="'.route('admin.village.product.edit', ['id' => $productOrderChange->order->product->id]).'">'.$productOrderChange->order->product->title.'</a>';
                }
                else {
                    return $productOrderChange->order->product->title;
                }
            })
//            ->addColumn('created_at', function (ProductOrderChange $productOrderChange) {
//                return Date::parse($productOrderChange->created_at)->diffForHumans();
//            })
            ->editColumn('user_name', function (ProductOrderChange $productOrderChange) {
                if (!$productOrderChange->user) {
                    return '';
                }

                $name = $productOrderChange->user->last_name. ' '.$productOrderChange->user->first_name;

                if ($this->getCurrentUser()->hasAccess('user.users.edit')) {
                    return '<a href="'.route('admin.user.user.edit', ['id' => $productOrderChange->user->id]).'">'.$name.'</a>';
                }
                else {
                    return $name;
                }
            })
            ->editColumn('from_status', function (ProductOrderChange $productOrderChange) {
                return '<span class="label label-'.config('village.order.label.'.$productOrderChange->from_status).'">'.trans('village::productorders.form.status.values.'.$productOrderChange->from_status).'</span>';
            })
            ->editColumn('to_status', function (ProductOrderChange $productOrderChange) {
                return '<span class="label label-'.config('village.order.label.'.$productOrderChange->to_status).'">'.trans('village::productorders.form.status.values.'.$productOrderChange->to_status).'</span>';
            })
        ;
    }
}
