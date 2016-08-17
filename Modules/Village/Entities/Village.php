<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Village\Entities\Scope\ApiScope;

class Village extends Model
{
    use SoftDeletes;
    use ApiScope;
    protected $table = 'village__villages';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'main_admin_id', 'name', 'shop_name', 'shop_address',
        'service_payment_info', 'service_bottom_text',
        'product_payment_info', 'product_bottom_text',
        'product_unit_step_kg', 'product_unit_step_bottle', 'product_unit_step_piece',
        'send_sms_to_village_admin', 'send_sms_to_executor', 'important_contacts',
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

    static public function getImportantContactsAttribute($value)
    {
        return unserialize($value);

    }

    static public function getUnitStepByVillage(Village $village, $unitTitle)
    {
        $field = 'product_unit_step_'.$unitTitle;

        return $village->$field;
    }
}
