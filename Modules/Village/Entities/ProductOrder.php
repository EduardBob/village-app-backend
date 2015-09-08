<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    // use Translatable;

    protected $table = 'village__product_orders';
    public $translatedAttributes = [];
    protected $fillable = ['product_id', 'user_id', 'dateTime', 'price', 'quantity', 'comment', 'status'];

    public function product()
    {
    	return $this->belongsTo('Modules\Village\Entities\Product');
    }

    public function user()
    {
    	return $this->belongsTo('Modules\Village\Entities\User');
    }
}
