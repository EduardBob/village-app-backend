<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $table = 'village__villages';

    protected $fillable = [
        'name', 'shop_name', 'shop_address',
        'service_payment_info', 'service_bottom_text',
        'product_payment_info', 'product_bottom_text',
        'product_unit_step_kg', 'product_unit_step_bottle', 'product_unit_step_piece',
        'active'
    ];
}
