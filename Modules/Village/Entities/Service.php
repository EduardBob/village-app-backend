<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

use DB;

class Service extends Model
{
    // use Translatable;

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

    public function getAll() {
        $items = DB::table($this->table)->lists('title', 'id');

        return $items;
    }
}
