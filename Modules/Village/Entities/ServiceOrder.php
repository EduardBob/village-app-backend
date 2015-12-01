<?php namespace Modules\Village\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class ServiceOrder extends Model
{
    use ApiScope;
    use VillageAdminScope;

    protected $table = 'village__service_orders';
    protected $fillable = ['user_id', 'service_id', 'status', 'perform_at', 'comment', 'decline_reason', 'payment_type', 'payment_status'];
    protected $dates = ['perform_at'];

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id')->withTrashed();
    }

    public function service()
    {
    	return $this->belongsTo('Modules\Village\Entities\Service', 'service_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo('Modules\Village\Entities\User', 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function(ServiceOrder $serviceOrder) {
            $serviceOrder->village()->associate($serviceOrder->service->village);

            if ($serviceOrder->service->price == 0) {
                $serviceOrder->price = $serviceOrder->service->price;
                $serviceOrder->payment_status = 'paid';
            }
            else {
                $serviceOrder->price = Margin::getFinalPrice($serviceOrder->service->price);
                $serviceOrder->payment_status = 'not_paid';
                $serviceOrder->status = 'processing';
            }
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
