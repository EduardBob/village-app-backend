<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductOrderTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'village__productorder_translations';
}
