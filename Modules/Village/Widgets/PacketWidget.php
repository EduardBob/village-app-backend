<?php

namespace Modules\Village\Widgets;

use Carbon\Carbon;
use Modules\Core\Contracts\Authentication;
use Modules\Dashboard\Foundation\Widgets\BaseWidget;
use Modules\Village\Entities\Village;

class PacketWidget extends BaseWidget
{

    public function __construct(Authentication $auth, Village $village)
    {
        $this->auth = $auth;
    }
    /**
     * Get the widget name
     * @return string
     */
    protected function name()
    {
        return get_class();
    }
    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'village::admin.packet.widgets.index';
    }
    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data()
    {
        $user = $this->auth->check();
        $village = $user->village;
        $packets = $village->getVillagePackets();
        $activeTo = '';

        if ($village->active) {
            $payedUntil = new Carbon($village->payed_until);
            $activeTo .= $payedUntil->format(config('village.date.human.shorter'));
            $now        = Carbon::now();
            $difference = $payedUntil->diff($now)->days;
            if ($difference <= 5) {
                $activeTo .= ($difference == 0) ? ' (сегодня) ' : ' (' . $difference . ' дней)';
            }
        } else {
            $activeTo .= ' ' . trans('village::villages.packet.not_active');
        }
        $totalBuildings = $village->buildings->count();
        $buildingsLeft = (int) $packets[$village->packet]['buildings'] - $totalBuildings;

        return [
          'currentUser'   => $user,
          'village'       => $village,
          'packets'       => $packets,
          'activeTo'      => $activeTo,
          'buildingsLeft' => $buildingsLeft,
        ];
    }

    /**
     * Get the widget type
     * @return string
     */
    protected function options()
    {
        $user = $this->auth->check();
        // Minimum widget height for other users.
        $height = '0';
        if ($user && $user->inRole('village-admin') && !$user->village->is_unlimited) {
            $height = '4';
        }
        return [
            'width' => '12',
            'height' => $height,
            'x' => '0',
            'y' => '0',
        ];
    }
}