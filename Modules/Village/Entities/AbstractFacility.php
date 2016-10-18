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
		static::FACILITY_BUSINESS,
		static::FACILITY_SHOPPING,
		static::FACILITY_COTTAGE,
		static::FACILITY_APARTMENT,
		];
	}

}