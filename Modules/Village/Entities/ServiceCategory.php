<?php namespace Modules\Village\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use Translatable;

    protected $table = 'village__servicecategories';
    public $translatedAttributes = [];
    protected $fillable = [];
}
