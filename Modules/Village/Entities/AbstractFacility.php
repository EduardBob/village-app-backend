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
}
