<?php namespace Modules\Village\Entities;

use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class ProductOrder extends AbstractOrder
{
    use ApiScope;
    use VillageAdminScope;

    protected $table = 'village__product_orders';
    protected $fillable = ['user_id', 'product_id', 'quantity', 'comment', 'status', 'perform_date', 'perform_time', 'decline_reason', 'payment_type', 'payment_status', 'done_at'];
    protected $dates = ['perform_date', 'done_at'];

	public function getOrderType()
	{
		return 'product';
	}

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id')->withTrashed();
    }

    public function product()
    {
    	return $this->belongsTo('Modules\Village\Entities\Product')->withTrashed();
    }

    public function user()
    {
    	return $this->belongsTo('Modules\Village\Entities\User', 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function(ProductOrder $productOrder) {
            $productOrder->village()->associate($productOrder->product->village);
            if ($productOrder->product->price == 0) {
                $productOrder->unit_price = $productOrder->price = $productOrder->product->price;
                $productOrder->payment_status = $productOrder::PAYMENT_STATUS_PAID;
            }
            else {
                $productOrder->unit_price = Margin::getFinalPrice($productOrder->village, $productOrder->product->price);
                $productOrder->price = $productOrder->unit_price * $productOrder->quantity;
                $productOrder->payment_status = $productOrder::PAYMENT_STATUS_NOT_PAID;
            }
            $productOrder->unit_title = $productOrder->product->unit_title;
        }, 10);

        static::saving(function(ProductOrder $productOrder) {
            if ($productOrder->perform_time === '') {
                $productOrder->perform_time = null;
            }

	        if ($productOrder::STATUS_DONE === $productOrder->status) {
		        $productOrder->done_at = new \DateTime();
	        }
	        else {
		        $productOrder->done_at = null;
	        }
        }, 10);
    }
}
