<?php namespace Modules\Village\Entities;

use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;
use Modules\Media\Support\Traits\MediaRelation;


class PacketOrder extends AbstractOrder
{
    use ApiScope;

    protected $table = 'village__packet_orders';
    protected $fillable = ['user_id', 'quantity', 'status', 'perform_date', 'perform_time', 'decline_reason', 'payment_status', 'done_at'];
    protected $dates = ['perform_date', 'done_at'];

	public function getOrderType()
	{
		return 'packet';
	}

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo('Modules\Village\Entities\User', 'user_id');
    }
}
