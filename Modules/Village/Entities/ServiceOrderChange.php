<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderChange extends Model
{
    protected $table = 'village__service_order_changes';
    protected $fillable = ['service_id', 'user_id', 'status'];

    public function service()
    {
    	return $this->belongsTo('Modules\Village\Entities\Service');
    }

    public function user()
    {
    	return $this->belongsTo('Modules\Village\Entities\User', 'user_id');
    }
}
