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
        if ('card' !== $order->payment_type || 'not_paid' !== $order->payment_status) {
            return [];
        }

        $reflection = new \ReflectionClass($order);
        $payment = new SentryPaymentGateway();

        $orderId = 'test'.$reflection->getShortName().'_'.$order->id;

        $link = $payment
            ->generateRedirectUrl(
                $orderId,
                $order->price,
                secure_url(route('sentry.payment.process', [], false)),
                true
            )
        ;

        return [
            'link' => secure_url(route('sentry.payment.redirect', ['link' => urlencode($link)], false))
        ];
    }
}