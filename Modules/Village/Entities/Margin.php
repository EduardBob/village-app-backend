<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bool is_removable
 * @property mixed id
 */
class Margin extends Model
{
	const TYPE_PERCENT = 'percent';
	const TYPE_CASH = 'cash';

    protected $table = 'village__margins';

    protected $fillable = ['type', 'value', 'title', 'order', 'is_removable'];

    /**
     * @return array
     */
    public static function getTypes()
    {
    	return [self::TYPE_CASH, self::TYPE_PERCENT];
    }

    public function getFinalPrice($price)
    {
    }
}
