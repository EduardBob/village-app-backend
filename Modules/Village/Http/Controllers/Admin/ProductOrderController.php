<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Modules\Village\Entities\ProductOrder;
use Modules\Village\Repositories\ProductOrderRepository;
use Modules\Village\Repositories\ProductRepository;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class ProductOrderController extends AbstractOrderController
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
//        $request->request->add(['status' => config('village.order.first_status')]);
        $request['status'] = config('village.order.first_status');

        return parent::store($request);
    }
//
//	/**
//	 * @param int $id
//	 *
//	 * @return \Illuminate\Http\RedirectResponse
//	 */
//	public function setStatusRunning($id)
//	{
//		/** @var ProductOrder $productOrder */
//		$productOrder = $this->repository->find((int)$id);
//		if (!$productOrder || $productOrder->status !== $productOrder::STATUS_PROCESSING) {
//			return redirect()->back(302);
//		}
//		$productOrder->status = $productOrder::STATUS_RUNNING;
//		$productOrder->save();
//
//		flash()->success($this->trans('messages.resource status-running'));
//
//		return redirect()->route($this->getRoute('index'));
//	}
//
//	/**
//	 * @param int $id
//	 *
//	 * @return \Illuminate\Http\RedirectResponse
//	 */
//	public function setStatusDone($id)
//	{
//		/** @var ProductOrder $productOrder */
//		$productOrder = $this->repository->find((int)$id);
//		if (!$productOrder || $productOrder->status !== $productOrder::STATUS_RUNNING) {
//			return redirect()->back(302);
//		}
//
//		$productOrder->status = $productOrder::STATUS_DONE;
//		$productOrder->save();
//
//		flash()->success($this->trans('messages.resource status-done'));
//
//		return redirect()->route($this->getRoute('index'));
//	}
//
//	/**
//	 * @param int $id
//	 *
//	 * @return \Illuminate\Http\RedirectResponse
//	 */
//	public function setPaymentDone($id)
//	{
//		/** @var ProductOrder $productOrder */
//		$productOrder = $this->repository->find((int)$id);
//		if (!$productOrder || $productOrder->payment_status === $productOrder::PAYMENT_STATUS_PAID) {
//			return redirect()->back(302);
//		}
//
//		$productOrder->payment_status = $productOrder::PAYMENT_STATUS_PAID;
//		$productOrder->save();
//
//		flash()->success($this->trans('messages.resource payment-done'));
//
//		return redirect()->route($this->getRoute('index'));
//	}
//
//	/**
//	 * @param int $id
//	 *
//	 * @return \Illuminate\Http\RedirectResponse
//	 */
//	public function setPaymentAndStatusDone($id)
//	{
//		/** @var ProductOrder $productOrder */
//		$productOrder = $this->repository->find((int)$id);
//		if (!$productOrder || $productOrder->status !== $productOrder::STATUS_RUNNING || $productOrder->status !== $productOrder::STATUS_RUNNING) {
//			return redirect()->back(302);
//		}
//
//		$productOrder->payment_status = $productOrder::PAYMENT_STATUS_PAID;
//		$productOrder->status = $productOrder::STATUS_DONE;
//		$productOrder->save();
//
//		flash()->success($this->trans('messages.resource payment-and-status-done'));
//
//		return redirect()->route($this->getRoute('index'));
//	}

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
            'village__product_orders.perform_date',
            'village__product_orders.perform_time',
            'village__product_orders.created_at',
            'village__product_orders.price',
            'village__product_orders.payment_type',
            'village__product_orders.payment_status',
            'village__product_orders.comment',
            'village__product_orders.status',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $currentUser = $this->getCurrentUser();
        $query
            ->leftJoin('village__villages', 'village__product_orders.village_id', '=', 'village__villages.id')
            ->leftJoin('village__products', 'village__product_orders.product_id', '=', 'village__products.id')
            ->leftJoin('users', 'village__product_orders.user_id', '=', 'users.id')
            ->leftJoin('village__buildings', 'users.building_id', '=', 'village__buildings.id')
            ->with(['village', 'product', 'user', 'user.building'])
        ;

        if (!$currentUser->inRole('admin') || !$currentUser->additionalVillages) {
            $query->where('village__product_orders.village_id', $this->getCurrentUser()->village->id);
        }

        if ($this->getCurrentUser()->inRole('executor')) {
            $executorStatuses = ProductOrder::getExecutorVisibleStatuses();
            $query->where('village__products.executor_id', $this->getCurrentUser()->id);
            $query->whereIn('village__product_orders.status', $executorStatuses);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $currentUser = $this->getCurrentUser();
        $builder
            ->addColumn(['data' => 'id', 'name' => 'village__product_orders.id', 'title' => $this->trans('table.id')])
        ;

        if ($currentUser->inRole('admin') || $currentUser->additionalVillages) {
            $builder
                ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')])
            ;
        }

        $builder
            ->addColumn(['data' => 'product_title', 'name' => 'village__products.title', 'title' => $this->trans('table.product')])
            ->addColumn(['data' => 'comment', 'name' => 'village__product_orders.comment', 'title' => $this->trans('table.comment')])
            ->addColumn(['data' => 'building_address', 'name' => 'village__buildings.address', 'title' => $this->trans('table.address')])
//            ->addColumn(['data' => 'quantity', 'name' => 'village__product_orders.quantity', 'title' => $this->trans('table.quantity')])
//            ->addColumn(['data' => 'unit_title', 'name' => 'village__product_orders.unit_title', 'title' => $this->trans('table.unit_title')])
            ->addColumn(['data' => 'perform_date', 'name' => 'village__product_orders.perform_date', 'title' => $this->trans('table.perform_date')])
            ->addColumn(['data' => 'price', 'name' => 'village__product_orders.price', 'title' => $this->trans('table.price')])
            ->addColumn(['data' => 'user_name', 'name' => 'users.last_name', 'title' => $this->trans('table.name')])
            ->addColumn(['data' => 'user_phone', 'name' => 'users.phone', 'title' => $this->trans('table.phone')])
            ->addColumn(['data' => 'payment_type', 'name' => 'village__product_orders.payment_type', 'title' => $this->trans('table.payment_type')])
            ->addColumn(['data' => 'payment_status', 'name' => 'village__product_orders.payment_status', 'title' => $this->trans('table.payment_status')])
            ->addColumn(['data' => 'status', 'name' => 'village__product_orders.status', 'title' => $this->trans('table.status')])
            ->addColumn(['data' => 'created_at', 'name' => 'village__product_orders.created_at', 'title' => $this->trans('table.created_at')])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        $currentUser = $this->getCurrentUser();
        if ($currentUser->inRole('admin') || $currentUser->additionalVillages) {
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
                if (!$productOrder->user) {
                    return '';
                }
                if ($this->getCurrentUser()->hasAccess('village.buildings.edit') && $productOrder->user->building) {
                    return '<a href="'.route('admin.village.building.edit', ['id' => $productOrder->user->building->id]).'">'.$productOrder->user->building->address.'</a>';
                }
                elseif ($productOrder->user->building) {
                    return $productOrder->user->building->address;
                }
            })
            ->addColumn('unit_title', function (ProductOrder $productOrder) {
                return $this->trans('form.unit_title.values.'.$productOrder->unit_title);
            })
            ->addColumn('perform_date', function (ProductOrder $productOrder) {
                return localizeddate($productOrder->perform_date, 'short').' '.@mb_strcut($productOrder->perform_time, 0, 5);
            })
            ->addColumn('created_at', function (ProductOrder $productOrder) {
                return localizeddate($productOrder->created_at);
            })
            ->editColumn('user_name', function (ProductOrder $productOrder) {
                if (!$productOrder->user) {
                    return '';
                }
                $name = $productOrder->user->last_name. ' '.$productOrder->user->first_name;

                if ($this->getCurrentUser()->hasAccess('user.users.edit')) {
                    return '<a href="'.route('admin.user.user.edit', ['id' => $productOrder->user->id]).'">'.$name.'</a>';
                }
                else {
                    return $name;
                }
            })
            ->editColumn('user_phone', function (ProductOrder $productOrder) {
                if (!$productOrder->user) {
                    return '';
                }
                return $productOrder->user->phone;
            })
            ->editColumn('payment_type', function (ProductOrder $productOrder) {
                return $this->trans('form.payment.type.values.'.$productOrder->payment_type);
            })
            ->editColumn('payment_status', function (ProductOrder $productOrder) {
                return '<span class="label label-'.config('village.order.payment.status.label.'.$productOrder->payment_status).'">'.$this->trans('form.payment.status.values.'.$productOrder->payment_status).'</span>';
            })
            ->editColumn('status', function (ProductOrder $productOrder) {
                return '<span class="label label-'.config('village.order.label.'.$productOrder->status).'">'.$this->trans('form.status.values.'.$productOrder->status).'</span>';
            })
        ;
    }

    /**
     * @param array        $data
     * @param ProductOrder $productOrder
     *
     * @return Validator
     */
    public function validate(array $data, ProductOrder $productOrder = null)
    {
//        $product = Product::find(@(int)$data['product_id']);
//
//        Validator::extend('step', function ($attribute, $value, $parameters) use ($product) {
//            if ($product) {
//                $step = (float)Village::getUnitStepByVillage($product->village, $product->unit_title);
//                $value = (float)$value;
//                return fmod($value, $step) === 0;
//            }
//        }, 'Неверный шаг');

        return Validator::make($data, [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:village__products,id',
            'perform_date' => 'required|date|date_format:Y-m-d',
            'perform_time' => 'date_format:H:i',
            'payment_type' => 'required|in:'.implode(',', config('village.order.payment.type.values')),
            'payment_status' => 'required|in:'.implode(',', config('village.order.payment.status.values')),
            'status' => 'required|in:'.implode(',', config('village.order.statuses')),
//            'comment' => 'sometimes|required|string',
            'decline_reason' => 'sometimes|required_if:status,rejected|string',
            'quantity' => 'required|numeric' // |step
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
