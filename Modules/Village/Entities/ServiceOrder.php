<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $table = 'village__service_orders';
    public $translatedAttributes = [];
    protected $fillable = ['status', 'perform_at', 'price', 'comment', 'decline_reason'];

    public function service()
    {
    	return $this->belongsTo('Modules\Village\Entities\Service', 'service_id');
    }

    public function profile()
    {
    	return $this->belongsTo('Modules\Village\Entities\Profile', 'user_id');
    }

    public function getStatusIndex($status)
    {
        $items = config('village.order.statuses');

        foreach ($items as $key => $item) {
            if ($status === $item)
            {
                return $key;
            }
        }
    }
}
