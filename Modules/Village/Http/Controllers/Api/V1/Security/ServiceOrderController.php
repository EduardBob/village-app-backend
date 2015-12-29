<?php

namespace Modules\Village\Http\Controllers\Api\V1\Security;

use Modules\Village\Entities\Service;
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
            ->leftJoin('village__service_executors', 'village__service_executors.service_id', '=', 'village__services.id')
            ->where('village__service_executors.user_id', $this->user()->id)
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

        $transformer = new ServiceOrderTransformer();
        $transformer->setDefaultIncludes(array_merge($transformer->getDefaultIncludes(), ['user']));

        return $this->response->withCollection($serviceOrders, $transformer);
    }

    /**
     * Get a single service order
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $order = ServiceOrder::find((int)$id);
        if(!$order){
            return $this->response->errorNotFound('order');
        }

        $service = $order->service;
        if (!in_array($this->user()->id, $service->executors->pluck('user_id')->all())) {
            return $this->response->errorForbidden('no_rights');
        }

        $transformer = new ServiceOrderTransformer();
        $transformer->setDefaultIncludes(array_merge($transformer->getDefaultIncludes(), ['user']));

        return $this->response->withItem($order, $transformer);
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

        if (!in_array($this->user()->id, $service->executors->pluck('user_id')->all())) {
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
        $data = $request::only('service_id', 'perform_date', 'perform_time', 'comment', 'added_from');
        $data = array_merge([
            'user_id' => $this->user()->id,
            'status' => config('village.order.first_status'),
            'payment_type' => config('village.order.payment.type.default'),
            'payment_status' => config('village.order.payment.status.default'),
        ], $data);

        $validator = $this->validate($data);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }

        $service = Service::find((int)$data['service_id']);

        if (!$service) {
            return $this->response->errorNotFound('service');
        }

        if (!in_array($this->user()->id, $service->executors->pluck('user_id')->all())) {
            return $this->response->errorForbidden('no_rights');
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
            'service_id'     => 'required|exists:village__services,id',
            'perform_date'   => 'required|date|date_format:Y-m-d',
            'perform_time'   => 'sometimes|date_format:H:i',
            'comment'        => 'required|string',
            'added_from'     => 'required|string',
        ]);
    }
}