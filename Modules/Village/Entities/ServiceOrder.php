<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $table = 'village__service_orders';
    protected $fillable = ['user_id', 'service_id', 'status', 'perform_at', 'comment', 'decline_reason'];

    public function service()
    {
    	return $this->belongsTo('Modules\Village\Entities\Service', 'service_id');
    }

    public function user()
    {
        return $this->belongsTo('Modules\User\Entities\Sentinel\User', 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function(ServiceOrder $serviceOrder) {
            $serviceOrder->price = $serviceOrder->service->price;
        });
    }
}
