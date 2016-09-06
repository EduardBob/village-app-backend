<?php
namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractDevice extends Model implements DeviceInterface
{
	/**
	 * @return array
	 */
	public static function getTypes()
	{
		return [
		static::TYPE_IOS,
		static::TYPE_ANDROID,
		];
	}
}
