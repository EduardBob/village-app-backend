<?php namespace Modules\Village\Http\Controllers\Admin;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Core\Contracts\Authentication;
use Modules\Village\Entities\PacketOrder;
use Modules\Village\Services\Packet;
use Modules\Village\Services\SentryPaymentGateway;

class PacketController extends AdminController
{

    /**
     * @var Authentication
     */
    protected $auth;

    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function getViewName()
    {
    }

    public function configureDatagridColumns()
    {
    }

    public function pay(Request $request)
    {
        if ($user = $this->auth->check()) {
            $order = new PacketOrder();
            $order->village()->associate($user->village);
            $order->user()->associate($user);
            $order->packet = (int)$request->get('packet');
            $order->period = (int)$request->get('period');
            $this->calculatePrice($order);
            $order->save();
            $order->fresh();
            $payment = new SentryPaymentGateway();
            $link    = $payment->generateTransactionUrl($order->transaction_id, 'DESKTOP');

            return redirect($link);
        }
    }

    private function calculatePrice(PacketOrder &$order)
    {
        $packetService = new Packet();
        $type          = $order->village->type;
        $packet        = $order->packet;
        $period        = $order->period;
        $order->price  = $packetService->getCurrencyPrice($type, $packet, $period);
        $order->coins  = $packetService->getCoinsPrice($type, $packet, $period);
        return $order;
    }

    /**
     * @param  Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function change(Request $request)
    {
        $user           = $this->auth->check();
        $village        = $user->village;
        $packetSelected = (int) trim($request->get('packet'));
        $packets        = (new Packet())->getListByType($village->type, $packetSelected);
        if (!array_key_exists($packetSelected, $packets)) {
            flash()->error(trans('village::villages.packet.chose_error'));
            return redirect()->route('dashboard.index');
        }
        $village->payed_until = $payedUntil = (new Carbon())->addDay(1)->format('Y-m-d H:i:00');
        $village->packet      = $packetSelected;
        $village->save();
        $successMessage = trans('village::villages.packet.switched_to') . ' "' . $packets[$packetSelected]['name'] . '"';
        if ($village->balance < $packets[$packetSelected]['price']) {
            $successMessage .= trans('village::villages.packet.balance_refill_left');
        } else {
            $successMessage .= trans('village::villages.packet.balance_tomorrow');
        }
        flash()->success($successMessage);
        return redirect()->route('dashboard.index');
    }
}
