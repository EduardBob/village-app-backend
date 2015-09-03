<?php namespace Modules\Village\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use Translatable;

    protected $table = 'village__buildings';
    public $translatedAttributes = [];
    protected $fillable = [];


    public function user()
    {
    	return $this->belongsTo('Modules\Village\Entities\User', 'building_id');
    }
}
