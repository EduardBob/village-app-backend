<?php namespace Modules\Village\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use Translatable;

    protected $table = 'village__services';
    public $translatedAttributes = [];
    protected $fillable = [];
}
