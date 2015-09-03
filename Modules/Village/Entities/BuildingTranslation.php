<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class BuildingTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'village__building_translations';
}
