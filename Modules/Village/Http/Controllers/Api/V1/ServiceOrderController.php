<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\User;
use Modules\Village\Entities\ServiceOrder;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Packback\Transformer\ServiceOrderTransformer;
use Request;
use Validator;

class ServiceOrderController extends ApiController
{
    /**
     * Get all serviceCategories
     *
     * @return Response
     */
    public function index()
    {
        // @todo
        $serviceCategories = ServiceOrder::where(['user_id' => 1])->orderBy('id', 'desc')->get();

        return $this->response->withCollection($serviceCategories, new ServiceOrderTransformer);
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
        $data = $request::only('service_id', 'perform_at', 'comment');
        $data = array_merge([
            'status' => 'in_progress',
            'user_id' => @User::find(1)->id, // @todo
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
            'perform_at'     => 'required|date|date_format:'.config('village.date.format'),
            'status'         => 'required|in:'.implode(',', config('village.order.statuses')),
            'comment'        => 'sometimes|required|string',
            'decline_reason' => 'sometimes|required_if:status,rejected|string',
        ]);
    }
}