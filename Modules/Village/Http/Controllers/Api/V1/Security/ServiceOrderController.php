<?php

namespace Modules\Village\Http\Controllers\Api\V1\Security;

use Modules\Village\Entities\ServiceOrder;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Http\Controllers\Api\V1\ApiController;
use Modules\Village\Packback\Transformer\ServiceOrderTransformer;
use Request;
use Validator;

class ServiceOrderController extends ApiController
{
    /**
     * Get all serviceCategories
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $query = ServiceOrder
            ::select('village__service_orders.*')
            ->leftJoin('village__services', 'village__service_orders.service_id', '=', 'village__services.id')
            ->where('village__services.executor_id', $this->user()->id)
//            ->orWhere('village__service_orders.user_id', $this->user()->id)
        ;

        if ($status = $request::query('status')) {
            $query->where(['village__service_orders.status' => $status]);
        }

        if ($date = $request::query('date')) {
            $query->where('village__service_orders.created_at', '>=', $date.' 00:00:00');
            $query->where('village__service_orders.created_at', '<=', $date.' 23:59:59');
        }

        $serviceOrders = $query
            ->orderBy('village__service_orders.id', 'desc')
            ->paginate(10)
        ;

        return $this->response->withCollection($serviceOrders, new ServiceOrderTransformer);
    }

    /**
     * Update a serviceOrder
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $request::only('status', 'payment_status');

        $validator = Validator::make($data, [
            'payment_status' => 'required|in:'.implode(',', config('village.order.payment.status.values')),
            'status'         => 'required|in:'.implode(',', config('village.order.statuses')),
        ]);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }

        $serviceOrder = ServiceOrder::find((int)$id);

        if (!$serviceOrder) {
            return $this->response->errorNotFound('');
        }

        $service = $serviceOrder->service;

        if (!$service->executor_id || !(int)$service->executor_id !== (int)$this->user()->id) {
            return $this->response->errorForbidden('no_rights');
        }

        if ('done' === $serviceOrder->status) {
            return $this->response->errorForbidden('order_already_done');
        }

        $serviceOrder->fill($data);
        $serviceOrder->save();

        return $this->response->withItem($serviceOrder, new ServiceOrderTransformer);
    }

    /**
     * Store a serviceOrder
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request::only('service_id', 'perform_date', 'perform_time', 'payment_type', 'comment');
        $data = array_merge([
            'status' => config('village.order.first_status'),
            'user_id' => $this->user()->id,
        ], $data);

        $validator = $this->validate($data);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }

        $serviceOrder = ServiceOrder::create($data);

        return $this->response->withItem($serviceOrder, new ServiceOrderTransformer);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Validation\Validator
     */
    static function validate(array $data)
    {
        return Validator::make($data, [
            'user_id'        => 'required|exists:users,id',
            'service_id'     => 'required|exists:village__services,id',
            'perform_date'   => 'required|date|date_format:Y-m-d',
            'perform_time'   => 'sometimes|date_format:H:i',
            'payment_type'   => 'required|in:'.implode(',', config('village.order.payment.type.values')),
            'status'         => 'required|in:'.implode(',', config('village.order.statuses')),
//            'comment'        => 'sometimes|required|string',
            'decline_reason' => 'sometimes|required_if:status,rejected|string',
        ]);
    }
}