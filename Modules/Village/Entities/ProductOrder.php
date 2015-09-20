<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $table = 'village__product_orders';
    public $translatedAttributes = [];
    protected $fillable = ['product_id', 'user_id', 'price', 'quantity', 'comment', 'status', 'perform_at', 'decline_reason'];

    public function product()
    {
    	return $this->belongsTo('Modules\Village\Entities\Product');
    }

    public function profile()
    {
    	return $this->belongsTo('Modules\Village\Entities\Profile', 'user_id');
    }
}
