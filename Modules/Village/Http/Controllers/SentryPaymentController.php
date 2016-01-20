<?php namespace Modules\Village\Http\Controllers;

use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Village\Entities\ProductOrder;
use Modules\Village\Services\SentryPaymentGateway;

class SentryPaymentController extends BasePublicController
{
    public function redirect()
    {
        $link = \Request::get('link');

        return redirect()->away(urldecode($link));
    }

    public function process()
    {
        $transactionId = \Request::input('orderId');

        if (!$transactionId) {
            return false;
        }

        $payment = new SentryPaymentGateway();

        try {
            $answer = $payment->getTransactionStatus($transactionId);

            $order = null;
            if (isset($answer['OrderNumber'])) {
                $orderNumber = $payment->decryptOrderNumber($answer['OrderNumber']);
                list($type, $id) = explode('_', $orderNumber);

                $model = '\\Modules\\Village\\Entities\\'.$type;
                /** @var ProductOrder $order */
                $order = $model::find((int)$id);
            }

            if (!$order || $order->transaction_id !== $transactionId) {
                return false;
            }

            if (isset($answer['ErrorCode']) && $answer['ErrorCode'] > 0) {
                die('1');
                $order->status = 'rejected';
                $order->decline_reason = $answer['ErrorMessage'];
                $order->save();
            }
            elseif (isset($answer['OrderStatus']) && 2 == $answer['OrderStatus']) {
                $order->payment_type = 'card';
                $order->payment_status = 'paid';
                $order->save();
            }
        }
        catch(\Exception $ex) {
        }

//        return redirect()->route('homepage');
    }
}
