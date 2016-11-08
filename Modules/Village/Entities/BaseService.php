<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Village\Entities\Scope\VillageAdminScope;

class BaseService extends Model
{
    use MediaRelation;
    use VillageAdminScope;

    protected $table = 'village__base__services';

    protected $dates = ['deleted_at'];

    protected $fillable = [
	    'category_id', 'title', 'price', 'active', 'text', 'comment_label', 'order_button_label', 'show_perform_time',
	    'has_card_payment', 'is_business', 'is_shopping', 'is_cottage', 'is_apartment'
    ];

	protected $attributes = ['has_card_payment' => true];

    public function category()
    {
    	return $this->belongsTo('Modules\Village\Entities\ServiceCategory', 'category_id')->withTrashed();
    }
}
