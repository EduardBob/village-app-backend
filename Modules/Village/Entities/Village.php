<?php namespace Modules\Village\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Village\Entities\Scope\ApiScope;


class Village extends AbstractFacility
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
        'active', 'type', 'payed_until', 'packet', 'balance'
    ];

    public function getCurrentPacket()
    {
        if ($this->is_unlimited) {
            return false;
        }

        $packet              = [];
        $packet['name']      = '№' . $this->packet . ' ' . setting('village::village-' . $this->type . '-' . $this->packet . '-name');
        $packet['price']     = setting('village::village-' . $this->type . '-' . $this->packet . '-price');
        $packet['buildings'] = setting('village::village-' . $this->type . '-' . $this->packet . '-buildings');
        $packet['balance'] = $this->balance;

        return $packet;
    }

    public function getPackets()
    {
        $type = $this->type;

        $packets = [];
        for ($i = 1; $i <= env('VILLAGE_NUMBER_PACKETS'); $i++) {
            $packets[$i] = '№'.$i.' '.setting('village::village-' . $type . '-' . $i . '-name');
        }
        return $packets;

    }

    public function getVillagePackets()
    {
        $type    = $this->type;
        $packets = [];
        for ($i = 1; $i <= env('VILLAGE_NUMBER_PACKETS'); $i++) {
            $packets[$i]['name']      = '№' . $i . ' ' . setting('village::village-' . $type . '-' . $i . '-name');
            $packets[$i]['buildings'] = setting('village::village-' . $type . '-' . $i . '-buildings');
            $packets[$i]['price']     = setting('village::village-' . $type . '-' . $i . '-price');
            $packets[$i]['current']   = ($this->packet == $i) ? true : false;
        }
        return $packets;

    }

    public function setPayedUntilAttribute($value)
    {
        $this->attributes['payed_until'] = (new Carbon($value))->format('Y-m-d H:i:00');
    }

    public function mainAdmin()
    {
        return $this->belongsTo('Modules\Village\Entities\User', 'main_admin_id');
    }
    public function getT()
    {
        return $this->belongsTo('Modules\Village\Entities\User', 'main_admin_id');
    }

    public function buildings()
    {
        return $this->hasMany('Modules\Village\Entities\Building', 'village_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function (Village $village) {
            if (!$village->main_admin_id) {
                $village->main_admin_id = null;
            }
        });
    }

    public function additionalUsers()
    {
        return $this->belongsToMany('Modules\Village\Entities\Village', 'village__village_user');
    }

    static public function getUnitStepByVillage(Village $village, $unitTitle)
    {
        $field = 'product_unit_step_'.$unitTitle;

        return $village->$field;
    }
}
