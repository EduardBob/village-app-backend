<?php namespace Modules\Village\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class ProductOrder extends Model
{
    use ApiScope;
    use VillageAdminScope;

    protected $table = 'village__product_orders';
    protected $fillable = ['user_id', 'product_id', 'quantity', 'comment', 'status', 'perform_at', 'decline_reason', 'payment_type', 'payment_status'];
    protected $dates = ['perform_at'];

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id')->withTrashed();
    }

    public function product()
    {
    	return $this->belongsTo('Modules\Village\Entities\Product')->withTrashed();
    }

    public function user()
    {
    	return $this->belongsTo('Modules\Village\Entities\User', 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function(ProductOrder $productOrder) {
            $productOrder->village()->associate($productOrder->product->village);
            if ($productOrder->product->price == 0) {
                $productOrder->price = $productOrder->product->price;
                $productOrder->payment_status = 'paid';
            }
            else {
                $productOrder->price = Margin::getFinalPrice($productOrder->product->price) * $productOrder->quantity;
                $productOrder->payment_status = 'not_paid';
            }
            $productOrder->unit_title = $productOrder->product->unit_title;
        });
    }

    public function getPerformAtAttribute($value)
    {
        if ($value === '0000-00-00 00:00:00') {
            return null;
        }

        try {
            return Carbon::createFromFormat($this->getDateFormat(), $value);
        }
        catch (\Exception $ex) {
            return null;
        }
    }
}
