<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $table = 'village__villages';

    protected $fillable = [
        'main_admin_id', 'name', 'shop_name', 'shop_address',
        'service_payment_info', 'service_bottom_text',
        'product_payment_info', 'product_bottom_text',
        'product_unit_step_kg', 'product_unit_step_bottle', 'product_unit_step_piece',
        'active'
    ];

    public function mainAdmin()
    {
        return $this->belongsTo('Modules\Village\Entities\User', 'main_admin_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function(Village $village) {
            if (!$village->main_admin_id) {
                $village->main_admin_id = null;
            }
        });
    }
}
