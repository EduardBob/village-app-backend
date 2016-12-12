<?php namespace Modules\Village\Services;

use Modules\Village\Entities\FacilityInterface;
use Modules\Village\Entities\AbstractFacility;

/**
 * Class Packet
 * @package Modules\Village\Services
 */
class Packet
{

    /**
     * Get Packet by facility type.
     * @param $type
     *
     * @return array
     */
    public function getByType($type)
    {
        $packets = [];
        for ($i = 1; $i <= env('VILLAGE_NUMBER_PACKETS'); $i++) {
            $packets[$i] = '№' . $i . ' ' . setting('village::village-' . $type . '-' . $i . '-name');
        }

        return $packets;
    }

    /**
     * Get formatted packet list of packets by type.
     * @param $type
     * @param $packet
     *
     * @return array
     */
    public function getListByType($type, $packet)
    {
        $packets = [];
        for ($i = 1; $i <= env('VILLAGE_NUMBER_PACKETS'); $i++) {
            $packets[$i]['name']      = '№' . $i . ' ' . setting('village::village-' . $type . '-' . $i . '-name');
            $packets[$i]['buildings'] = setting('village::village-' . $type . '-' . $i . '-buildings');
            $packets[$i]['price']     = setting('village::village-' . $type . '-' . $i . '-price');
            $packets[$i]['current']   = ($packet == $i) ? true : false;
        }

        return $packets;
    }

    /**
     * Get coins to money coefficient, price of 1000 RUB in coins.
     * @return int
     */
    public function getCoefficient()
    {
        return (int)setting('village::village-currency');
    }

    /**
     * @param $type
     * @param $packetNumber
     *
     * @return int
     */
    public function getPrice($type, $packetNumber)
    {
        return (int)setting('village::village-' . $type . '-' . $packetNumber . '-price');
    }

    /**
     * @param $type
     * @param $packetNumber
     * @param int $period
     *
     * @return int
     */
    public function getCurrencyPrice($type, $packetNumber, $period = 1)
    {
        $price           = $this->getPrice($type, $packetNumber);
        $coefficient     = $this->getCoefficient();
        $priceInCurrency = $price * (1000 / $coefficient) * $period;

        return $priceInCurrency;
    }

    /**
     * @param $type
     * @param $packetNumber
     * @param int $period
     *
     * @return float|int
     */
    public function getCoinsPrice($type, $packetNumber, $period = 1)
    {
        $price    = $this->getPrice($type, $packetNumber);
        $coins    = $price * $period;
        $discount = 0;
        if (6 >= $period || 11 <= $period) {
            $discount = 25;
        }
        if (12 >= $period) {
            $discount = 50;
        }
        if ($discount) {
            $coins += floor($coins / 100 * $discount);
        }

        return $coins;
    }

    /**
     * @param \Modules\Village\Entities\FacilityInterface $facility
     *
     * @return array
     */
    public function getCurrent(FacilityInterface $facility)
    {
        $packet              = [];
        $packet['name']      = '№' . $facility->packet . ' ' . setting('village::village-' . $facility->type . '-' . $facility->packet . '-name');
        $packet['price']     = setting('village::village-' . $facility->type . '-' . $facility->packet . '-price');
        $packet['buildings'] = setting('village::village-' . $facility->type . '-' . $facility->packet . '-buildings');
        $packet['balance']   = $facility->balance;

        return $packet;
    }

    /**
     * Asgard settings page form.
     * @return mixed
     */
    public static function getSettings()
    {
        $types = AbstractFacility::getTypes();
        $settings['village-currency'] = [
          'description'  => trans('village::villages.services.currency_conversion'),
          'view'         => 'number',
          'translatable' => false
        ];
        foreach ($types as $type) {
            for ($i = 1; $i <= env('VILLAGE_NUMBER_PACKETS'); $i++) {
                $settings['village-' . $type . '-' . $i . '-name']      = [
                  'description'  => trans('village::villages.type.' . $type) . ': ' . trans('village::villages.packet.name_and_number') . $i,
                  'view'         => 'village::admin.admin.fields.facilityname',
                  'translatable' => false
                ];
                $settings['village-' . $type . '-' . $i . '-buildings'] = [
                  'description'  => trans('village::villages.type.' . $type) . ': ' . trans('village::villages.packet.house_number') . $i,
                  'view'         => 'village::admin.admin.fields.facilitybuildings',
                  'translatable' => false
                ];
                $settings['village-' . $type . '-' . $i . '-price']     = [
                  'description'  => trans('village::villages.type.' . $type) . ': ' .trans('village::villages.packet.base_price') . $i,
                  'view'         => 'village::admin.admin.fields.facilityprice',
                  'translatable' => false
                ];
            }
        }

        return $settings;
    }
}
