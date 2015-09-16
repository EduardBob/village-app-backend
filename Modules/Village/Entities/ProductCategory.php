<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

use DB;

class ProductCategory extends Model
{
    // use Translatable;

    protected $table = 'village__product_categories';
    public $translatedAttributes = [];
    protected $fillable = ['title', 'order'];

    public function products()
    {
    	return $this->hasMany('Modules\Village\Entities\Product', 'category_id');
    }

    public function getAll()
    {
    	$items = DB::table($this->table)->lists('title', 'id');
    	
    	return $items;
    }
}
