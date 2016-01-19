<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductOrderChange extends Model
{
    protected $table = 'village__product_order_changes';
    protected $fillable = ['order_id', 'user_id', 'from_status', 'to_status'];

    public function order()
    {
    	return $this->belongsTo('Modules\Village\Entities\ProductOrder', 'order_id');
    }

    public function user()
    {
    	return $this->belongsTo('Modules\Village\Entities\User', 'user_id');
    }
}
