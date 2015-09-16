<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    // use Translatable;

    protected $table = 'village__product_orders';
    public $translatedAttributes = [];
    protected $fillable = ['product_id', 'user_id', 'price', 'quantity', 'comment', 'status', 'perform_at'];

    public function product()
    {
    	return $this->belongsTo('Modules\Village\Entities\Product');
    }

    public function profile()
    {
    	return $this->belongsTo('Modules\Village\Entities\Profile', 'user_id');
    }

    public function getStatusIndex($status)
    {
        $items = config('village.order.statuses');

        foreach ($items as $key => $item) {
            if ($status === $item)
            {
                return $key;
            }
        }
    }
}
