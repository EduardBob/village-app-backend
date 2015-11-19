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

    protected $fillable = ['village_id', 'type', 'value', 'title', 'active', 'order', 'is_removable'];

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

    /**
     * @param $price
     *
     * @return float
     */
    static public function getFinalPrice($price)
    {
        if ($price <= 0) return 0;

        $margins = Margin::api()->orderBy('order', 'ASC')->get();

        foreach ($margins as $margin) {
            if (Margin::TYPE_PERCENT == $margin['type']) {
                $price += $price * ($margin['value']/100);
            }
            elseif (Margin::TYPE_CASH == $margin['type']) {
                $price += $margin['value'];
            }
        }

        return round($price, 2);
    }
}
