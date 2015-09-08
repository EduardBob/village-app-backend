<?php namespace Modules\Village\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Translatable;

    protected $table = 'village__products';
    public $translatedAttributes = [];
    protected $fillable = [];
}
