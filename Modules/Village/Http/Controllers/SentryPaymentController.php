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
            die('empty request');
        }

        $payment = new SentryPaymentGateway();
        $response = $payment->processResponse($data);

        // Если что-то не так, то ничего не делаем
        if (1 != $response['responseCode']) {
            var_dump('responseCode != 1', $response);die;
            return false;
        }

        list($type, $id) = explode('_', $response['OrderID']);
        $model = '\\Modules\\Village\\Entities\\'.$type;
        /** @var ProductOrder $order */
        $order = $model::find((int)$id);

        if (!$order) {
            var_dump('Order '.$id.' not found', $response);die;
            return false;
        }

        $order->save([
           'payment_status' => 'paid'
        ]);

        die('ok');

//        return redirect()->route('register');
//        return redirect()->intended('/backend');
    }
}
