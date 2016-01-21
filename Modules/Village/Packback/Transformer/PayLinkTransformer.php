<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\TransformerAbstract;
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
    public function transform($order)
    {
        if ('card' !== $order->payment_type || 'not_paid' !== $order->payment_status || !$order->transaction_id) {
            return [];
        }

        $payment = new SentryPaymentGateway();
        $link = $payment->generateTransactionUrl($order->transaction_id, 'MOBILE');

        return [
            'link' => $link
        ];
    }
}