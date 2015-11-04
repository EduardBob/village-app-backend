<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductOrderChange extends Model
{
    protected $table = 'village__product_order_changes';
    protected $fillable = ['product_id', 'user_id', 'status'];

    public function product()
    {
    	return $this->belongsTo('Modules\Village\Entities\Product');
    }

    public function user()
    {
    	return $this->belongsTo('Modules\Village\Entities\User', 'user_id');
    }
}
