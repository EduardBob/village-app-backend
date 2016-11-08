<?php
namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractFacility extends Model implements FacilityInterface
{

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
          static::TYPE_BUSINESS,
          static::TYPE_SHOPPING,
          static::TYPE_COTTAGE,
          static::TYPE_APARTMENT,
        ];
    }

    /**
     * Asgard settings page form.
     * @return mixed
     */
    public static function getSettings()
    {
        $types                        = self::getTypes();
        $settings['village-currency'] = [
          'description'  => trans('village::villages.services.currency_conversion'),
          'view'         => 'number',
          'translatable' => false
        ];

        foreach ($types as $type) {
            for ($i = 1; $i <= env('VILLAGE_NUMBER_PACKETS'); $i++) {
                $settings['village-' . $type . '-' . $i . '-name']      = [
                  'description'  => trans('village::villages.type.' . $type) . ': название пакета №' . $i,
                  'view'         => 'text',
                  'translatable' => false
                ];
                $settings['village-' . $type . '-' . $i . '-buildings'] = [
                  'description'  => trans('village::villages.type.' . $type) . ': кол-во домов пакета №' . $i,
                  'view'         => 'number',
                  'translatable' => false
                ];
                $settings['village-' . $type . '-' . $i . '-price']     = [
                  'description'  => trans('village::villages.type.' . $type) . ': базовая цена (за месяц) для пакета №' . $i,
                  'view'         => 'number',
                  'translatable' => false
                ];
            }
        }
        return $settings;
    }
}
