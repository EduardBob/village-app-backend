<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\Product;
use Modules\Village\Entities\ProductOrder;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Entities\User;
use Modules\Village\Packback\Transformer\ProductOrderTransformer;
use Modules\Village\Services\SentryPaymentGateway;
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
        $data = $request::only('product_id', 'quantity', 'perform_date', 'perform_time', 'payment_type', 'comment');
        $data = array_merge([
            'status' => config('village.order.first_status'),
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
	 * Check card payment for a single product order
	 *
	 * @param int $orderId
	 * @return Response
	 */
	public function checkPayment($orderId)
	{
		/** @var ProductOrder $order */
		$order = ProductOrder::find((int)$orderId);
		if (!$order || !$order->transaction_id) {
			return $this->response->errorNotFound('order_id');
		}

		$payment = new SentryPaymentGateway();

		$paid = false;
		try {
			$answer = $payment->getTransactionStatus($order->transaction_id);

			if (isset($answer['ErrorCode']) && $answer['ErrorCode'] > 0) {
				$order->status = $order::STATUS_REJECTED;
				$order->decline_reason = $answer['ErrorMessage'];
				$order->save();
			}
			elseif (isset($answer['OrderStatus']) && 2 == $answer['OrderStatus']) {
				$paid = true;
				$order->payment_type = $order::PAYMENT_TYPE_CARD;
				$order->payment_status = $order::PAYMENT_STATUS_PAID;
				$order->save();
			}
		}
		catch(\Exception $ex) {
			return $this->response->errorInternalError('');
		}

		return $this->response->withArray(['data' => [
			'paid' => $paid
		]]);
	}

    /**
     * @param array $data
     *
     * @return \Illuminate\Validation\Validator
     */
    static function validate(array $data)
    {
        return Validator::make($data, [
            'payment_type'   => 'required|in:'.implode(',', config('village.order.payment.type.values')),
            'status'         => 'required|in:'.implode(',', config('village.order.statuses')),
            'perform_date'   => 'required|date|date_format:Y-m-d',
            'perform_time'   => 'sometimes|date_format:H:i',
//            'comment' => 'sometimes|required|string',
            'decline_reason' => 'sometimes|required_if:status,rejected|string',
            'user_id'        => 'required|exists:users,id',
            'product_id'     => 'required|exists:village__products,id',
            'quantity'       => 'required|numeric|min:0'
        ]);
    }
}