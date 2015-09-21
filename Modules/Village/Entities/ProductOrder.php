<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $table = 'village__product_orders';
    protected $fillable = ['user_id', 'product_id', 'quantity', 'comment', 'status', 'perform_at', 'decline_reason'];

    public function product()
    {
    	return $this->belongsTo('Modules\Village\Entities\Product');
    }

    public function user()
    {
    	return $this->belongsTo('Modules\Village\Entities\User', 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function(ProductOrder $productOrder) {
            $productOrder->price = $productOrder->product->price * $productOrder->quantity;
            $productOrder->unit_title = $productOrder->product->unit_title;
        });
    }
}
