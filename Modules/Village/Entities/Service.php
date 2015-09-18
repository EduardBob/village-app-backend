<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

use DB;

class Service extends Model
{
    protected $table = 'village__services';
    public $translatedAttributes = [];
    protected $fillable = ['title', 'price'];

    public function category()
    {
    	return $this->belongsTo('Modules\Village\Entities\ServiceCategory');
    }

    public function orders()
    {
    	return $this->hasMany('Modules\Village\Entities\ServiceOrder', 'service_id');
    }
}
