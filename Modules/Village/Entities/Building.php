<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    // use Translatable;

    protected $table = 'village__buildings';
    public $translatedAttributes = [];
    protected $fillable = ['address', 'code'];


    public function user()
    {
    	return $this->hasOne('Modules\Village\Entities\VillageUser');
    }
}
