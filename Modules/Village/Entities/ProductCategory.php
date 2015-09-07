<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    // use Translatable;

    protected $table = 'village__productcategories';
    public $translatedAttributes = [];
    protected $fillable = ['title', 'order'];

    public function products()
    {
    	return $this->belongsToMany('Modules\Village\Entities\Product', 'product_category_id');
    }
}
