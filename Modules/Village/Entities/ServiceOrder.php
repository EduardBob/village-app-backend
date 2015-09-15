<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    // use Translatable;

    protected $table = 'village__service_orders';
    public $translatedAttributes = [];
    protected $fillable = ['status', 'perform_at'];

    public function service()
    {
    	return $this->belongsTo('Modules\Village\Entities\Service', 'service_id');
    }

    public function profile()
    {
    	return $this->belongsTo('Modules\Village\Entities\Profile', 'user_id');
    }
}
