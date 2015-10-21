<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\Product;
use Modules\Village\Entities\ProductOrder;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Entities\User;
use Modules\Village\Packback\Transformer\ProductOrderTransformer;
use Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class ProductOrderController extends ApiController
{
    /**
     * Get all productOrders
     *
     * @return Response
     */
    public function index()
    {
        $productOrders = ProductOrder::where(['user_id' => $this->user()->id])->orderBy('id', 'desc')->paginate(10);

        return $this->response->withCollection($productOrders, new ProductOrderTransformer);
    }

    /**
     * Store a productOrder
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request::only('product_id', 'quantity', 'perform_at', 'comment');
        $data = array_merge([
            'status' => 'processing',
            'user_id' => $this->user()->id,
        ], $data);
        $validator = $this->validate($data);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }

        $productOrder = ProductOrder::create($data);

        return $this->response->withItem($productOrder, new ProductOrderTransformer);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Validation\Validator
     */
    static function validate(array $data)
    {
        return Validator::make($data, [
            'perform_at' => 'required|date|date_format:'.config('village.date.format'),
            'status' => 'required|in:'.implode(',', config('village.order.statuses')),
//            'comment' => 'sometimes|required|string',
            'decline_reason' => 'sometimes|required_if:status,rejected|string',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:village__products,id',
            'quantity' => 'required|numeric|min:0'
        ]);
    }
}