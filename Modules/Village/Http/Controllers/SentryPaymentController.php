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
        $data = \Request::all();

        if (empty($data)) {
            throw new \Exception('empty post request');
        }

        $payment = new SentryPaymentGateway();

        $response = $payment->processResponse($data);

        list($type, $id) = explode('_', $response['OrderID']);
        if (config('village.order.payment.sentry.debug')) {
            $type = str_replace('test', '', $type);
        }

        $model = '\\Modules\\Village\\Entities\\'.$type;
        /** @var ProductOrder $order */
        $order = $model::find((int)$id);

        if (!$order) {
            throw new \Exception('Order '.$type.' -> '.$id.' not found');
        }

        $order->save([
           'payment_type' => 'card',
           'payment_status' => 'paid'
        ]);

        return redirect()->route('homepage');
    }
}
