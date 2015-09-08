<?php namespace Modules\Village\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use Translatable;

    protected $table = 'village__productorders';
    public $translatedAttributes = [];
    protected $fillable = [];
}
