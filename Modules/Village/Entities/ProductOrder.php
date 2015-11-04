<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class ProductOrder extends Model
{
    use ApiScope;
    use VillageAdminScope;

    protected $table = 'village__product_orders';
    protected $fillable = ['user_id', 'product_id', 'quantity', 'comment', 'status', 'perform_at', 'decline_reason'];

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id');
    }

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

        static::creating(function(ProductOrder $productOrder) {
            $productOrder->village()->associate($productOrder->product->category->village);
        });

        static::saving(function(ProductOrder $productOrder) {
            $productOrder->price = $productOrder->product->price * $productOrder->quantity;
            $productOrder->unit_title = $productOrder->product->unit_title;
        });

        static::saved(function(ProductOrder $productOrder) {
            if ($productOrder->isDirty('status')) {
                ProductOrderChange::create([
                    'product_id' => $productOrder->product->id,
                    'status' => $productOrder->status,
                ]);
            }
        });
    }
}
