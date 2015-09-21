<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

use DB;

class Service extends Model
{
    protected $table = 'village__services';

    protected $fillable = ['category_id', 'title', 'price', 'active'];

    public function category()
    {
    	return $this->belongsTo('Modules\Village\Entities\ServiceCategory', 'category_id');
    }

    public function orders()
    {
    	return $this->hasMany('Modules\Village\Entities\ServiceOrder', 'service_id');
    }
}
