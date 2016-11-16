<?php namespace Modules\Village\Http\Controllers\Admin;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Core\Contracts\Authentication;

class PacketController extends  AdminController
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

    // TODO integrate payment here.
    public function pay(Request $request)
    {
        flash()->success('In progress');
        return redirect()->route('dashboard.index');
    }
    /**
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function change(Request $request)
    {
        $user           = $this->auth->check();
        $village        = $user->village;
        $packets        = $village->getVillagePackets();
        $packetSelected = (int)trim($request->get('packet'));
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
