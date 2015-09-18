<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

use DB;

class ProductCategory extends Model
{
    protected $table = 'village__product_categories';
    public $translatedAttributes = [];
    protected $fillable = ['title', 'order'];

    public function products()
    {
    	return $this->hasMany('Modules\Village\Entities\Product', 'category_id');
    }
}
