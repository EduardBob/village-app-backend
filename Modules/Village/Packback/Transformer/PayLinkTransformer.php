<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\TransformerAbstract;
use Modules\Village\Entities\OrderInterface;
use Modules\Village\Entities\ProductOrder;
use Modules\Village\Services\SentryPaymentGateway;

class PayLinkTransformer extends TransformerAbstract
{
    /**
     * Turn user object into generic array
     *
     * @param $order
     * @return array
     */
    public function transform(OrderInterface $order)
    {
        if ($order::PAYMENT_TYPE_CARD !== $order->payment_type || $order::PAYMENT_STATUS_PAID === $order->payment_status || !$order->transaction_id) {
            return [];
        }

        $payment = new SentryPaymentGateway();
        $link = $payment->generateTransactionUrl($order->transaction_id, 'MOBILE');

        return [
            'link' => $link
        ];
    }
}