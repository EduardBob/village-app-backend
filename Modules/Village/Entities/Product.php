<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

use DB;

class Product extends Model
{
    // use Translatable;

    protected $table = 'village__products';
    public $translatedAttributes = [];
    protected $fillable = ['title', 'price', 'image', 'decline_reason', 'comment'];

    public function category()
    {
    	return $this->belongsTo('Modules\Village\Entities\ProductCategory', 'category_id');
    }

    public function orders()
    {
    	return $this->hasMany('Modules\Village\Entities\ProductOrder', 'product_id');
    }

    public function getAll() {
        $items = DB::table($this->table)->lists('title', 'id');

        return $items;
    }
}
