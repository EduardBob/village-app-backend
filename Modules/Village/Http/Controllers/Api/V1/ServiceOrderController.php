<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Entities\ServiceOrder;
use Modules\Village\Packback\Transformer\ServiceOrderTransformer;
use Modules\Village\Services\SentryPaymentGateway;
use Modules\Village\Support\Traits\MediaSave;
use Request;
use Validator;

class ServiceOrderController extends ApiController
{
	use MediaSave;
    /**
     * Get all serviceCategories
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $query = ServiceOrder::where(['user_id' => $this->user()->id]);

        if ($search = $request::query('search')) {
	        $fields = ['comment', 'added_from'];
	        $query->where(function($query) use ($search, $fields){
		        foreach($fields as $field) {
			        $query
				        ->orWhere($field, 'like', '%'.$search.'%')
			        ;
		        }
            });
        }

	    $limit = (int)$request::query('limit', 10);

		$serviceCategories = $query
	        ->orderBy('id', 'desc')
	        ->paginate($limit)
		;

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
        $data = $request::only('service_id', 'perform_date', 'perform_time', 'payment_type', 'comment', 'files');
        $data = array_merge([
            'status' => config('village.order.first_status'),
            'user_id' => $this->user()->id,
        ], $data);

        $validator = $this->validate($data);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }
        $serviceOrder = ServiceOrder::create($data);
		if (count($data['files'])) {
			$this->saveFiles($serviceOrder, $data['files']);
		}
        return $this->response->withItem($serviceOrder, new ServiceOrderTransformer);
    }

	/**
	 * Check card payment for a single service order
	 *
	 * @param int $orderId
	 * @return Response
	 */
	public function checkPayment($orderId)
	{
		/** @var ServiceOrder $order */
		$order = ServiceOrder::find((int)$orderId);
		if (!$order) {
			return $this->response->errorNotFound('order_id');
		}

		if ($order->user !== $this->user()) {
			return $this->response->errorForbidden('forbidden_for_user');
		}

		if (!$order->transaction_id) {
			return $this->response->errorForbidden('forbidden_not_have_transaction_id');
		}

		if (!in_array($order->status, $order->canPayInStatuses())) {
			return $this->response->errorForbidden('forbidden_by_order_status');
		}

		$paid = false;

		// Если ещё не оплачен
		if ($order::PAYMENT_STATUS_PAID !== $order->payment_status) {
			$payment = new SentryPaymentGateway();

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
				return $this->response->errorInternalError('bank_error');
			}
		}
		else {
			$paid = true;
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