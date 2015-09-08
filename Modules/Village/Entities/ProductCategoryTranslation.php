<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'village__productcategory_translations';
}
