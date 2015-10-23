<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class Margin extends Model
{
    use ApiScope;
    use VillageAdminScope;

	const TYPE_PERCENT = 'percent';
	const TYPE_CASH = 'cash';

    protected $table = 'village__margins';

    protected $fillable = ['village_id', 'type', 'value', 'title', 'order', 'is_removable'];

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id');
    }

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
