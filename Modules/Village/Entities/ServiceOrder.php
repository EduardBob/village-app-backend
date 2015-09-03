<?php namespace Modules\Village\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use Translatable;

    protected $table = 'village__serviceorders';
    public $translatedAttributes = [];
    protected $fillable = [];
}
