<?php namespace Modules\Village\Http\Controllers;

use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Village\Entities\ProductOrder;
use Modules\Village\Services\SentryPaymentGateway;
use Modules\Village\Entities\OrderInterface;

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

                $model = '\\Modules\\Village\\Entities\\'.ucfirst($type);
                /** @var ProductOrder $order */
                $order = $model::find((int)$id);
            }

            if (!$order || $order->transaction_id !== $transactionId) {
                return false;
            }

            if (isset($answer['ErrorCode']) && $answer['ErrorCode'] > 0) {
                $order->status = OrderInterface::STATUS_REJECTED;
                $order->decline_reason = $answer['ErrorMessage'];
                $order->save();
            }
            elseif (isset($answer['OrderStatus']) && 2 == $answer['OrderStatus']) {
                // Packet order is always payed with card.
                if ($type != 'packet') {
                    $order->payment_type = OrderInterface::PAYMENT_TYPE_CARD;
                }
                $order->payment_status = OrderInterface::PAYMENT_STATUS_PAID;
                $order->save();
            }
        }
        catch(\Exception $ex) {
        }

        if ($type == 'packet') {
            if ($order->status == OrderInterface::STATUS_REJECTED) {
                $rejectMessage = trans('village::villages.packet.pay_reject').' '. $answer['ErrorMessage'];
                flash()->error($rejectMessage);
            } else {
                $successMessage = trans('village::villages.packet.pay_ok');
                flash()->success($successMessage);
            }
            $redirect = redirect()->route('dashboard.index');
        } else {
            $redirect = redirect()->away('village://profile/history');
        }
        return $redirect;
    }
}
