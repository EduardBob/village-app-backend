<?php namespace Modules\Village\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Translatable;

    protected $table = 'village__products';
    public $translatedAttributes = [];
    protected $fillable = [];

    public function category()
    {
    	return $this->hasOne('Modules\Village\Entities\ProductCategory');
    }

    public function orders()
    {
    	return $this->hasMany('Modules\Village\Entities\ProductOrder', 'product_id');
    }
}
