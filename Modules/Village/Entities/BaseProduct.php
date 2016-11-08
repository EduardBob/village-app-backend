<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;
use Modules\Village\Entities\Scope\AbstractBase;

class BaseProduct extends Model
{
    use MediaRelation;
    use VillageAdminScope;

    protected $table = 'village__base__products';

    protected $fillable = [
	    'category_id', 'title', 'price', 'unit_title', 'active', 'comment_label', 'text', 'show_perform_time', 'has_card_payment',
        'is_business', 'is_shopping', 'is_cottage', 'is_apartment'
    ] ;

	protected $attributes = ['has_card_payment' => true];

    public function category()
    {
    	return $this->belongsTo('Modules\Village\Entities\ProductCategory', 'category_id')->withTrashed();
    }

    public function getAll() {
        $items = DB::table($this->table)->lists('title', 'id');

        return $items;
    }
}
