<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class ServiceOrder extends Model
{
    use ApiScope;
    use VillageAdminScope;

    protected $table = 'village__service_orders';
    protected $fillable = ['user_id', 'service_id', 'status', 'perform_at', 'comment', 'decline_reason'];

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id');
    }

    public function service()
    {
    	return $this->belongsTo('Modules\Village\Entities\Service', 'service_id');
    }

    public function user()
    {
        return $this->belongsTo('Modules\Village\Entities\User', 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function(ServiceOrder $serviceOrder) {
            $serviceOrder->village()->associate($serviceOrder->service->category->village);
        });

        static::saving(function(ServiceOrder $serviceOrder) {
            $serviceOrder->price = $serviceOrder->service->price;
        });

        static::saved(function(ServiceOrder $serviceOrder) {
            if ($serviceOrder->isDirty('status')) {
                ServiceOrderChange::create([
                    'service_id' => $serviceOrder->service->id,
                    'status' => $serviceOrder->status,
                ]);
            }
        });
    }
}
