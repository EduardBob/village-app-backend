<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    // use Translatable;

    protected $table = 'village__serviceorders';
    public $translatedAttributes = [];
    protected $fillable = ['service_id', 'dateTime', 'price', 'status'];

    public function service()
    {
    	return $this->hasOne('Modules\Village\Entities\Service');
    }
}
