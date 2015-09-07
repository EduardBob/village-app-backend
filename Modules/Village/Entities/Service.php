<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    // use Translatable;

    protected $table = 'village__services';
    public $translatedAttributes = [];
    protected $fillable = ['service_category_id', 'title', 'price'];

    public function category()
    {
    	return $this->hasOne('Modules\Village\Entities\ServiceCategory');
    }

    public function orders()
    {
    	return $this->belongsToMany('Modules\Village\Entities\ServiceOrder', 'service_id');
    }
}
