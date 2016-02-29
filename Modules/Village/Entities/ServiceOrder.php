<?php namespace Modules\Village\Entities;

use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class ServiceOrder extends AbstractOrder
{
    use ApiScope;
    use VillageAdminScope;

    protected $table = 'village__service_orders';
    protected $fillable = [
        'user_id', 'service_id', 'status', 'perform_date', 'perform_time', 'comment', 'decline_reason', 'payment_type', 'payment_status',
        // используется для формы ордера у охранника
        'added_from', 'transaction_id'
    ];
    protected $dates = ['perform_date'];

	public function getOrderType()
	{
		return 'service';
	}

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
                $serviceOrder->unit_price = $serviceOrder->price = $serviceOrder->service->price;
                $serviceOrder->payment_status = 'paid';
            }
            else {
                $serviceOrder->unit_price = $serviceOrder->price = Margin::getFinalPrice($serviceOrder->village, $serviceOrder->service->price);
                $serviceOrder->payment_status = 'not_paid';
                $serviceOrder->status = 'processing';
            }
        }, 10);

        static::saving(function(ServiceOrder $serviceOrder) {
            if ($serviceOrder->perform_time === '') {
                $serviceOrder->perform_time = null;
            }
        }, 10);
    }
}
