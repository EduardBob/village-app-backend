<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class Product extends Model
{
    use MediaRelation;
    use ApiScope;
    use VillageAdminScope;
    use SoftDeletes;

    protected $table = 'village__products';

    protected $dates = ['deleted_at'];

    protected $fillable = ['base_id', 'village_id', 'category_id', 'executor_id', 'title', 'price', 'unit_title', 'active', 'comment_label', 'text'];

    public function base()
    {
        return $this->belongsTo('Modules\Village\Entities\BaseSurvey', 'base_id');
    }

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id')->withTrashed();
    }

    public function category()
    {
    	return $this->belongsTo('Modules\Village\Entities\ProductCategory', 'category_id')->withTrashed();
    }

    public function executor()
    {
        return $this->belongsTo('Modules\Village\Entities\User', 'executor_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function(Product $product) {
            $product->village()->associate($product->village_id);
        });

        static::saving(function(Product $product) {
            if (!$product->executor_id) {
                $product->executor_id = null;
            }
        });
    }

    public function getAll() {
        $items = DB::table($this->table)->lists('title', 'id');

        return $items;
    }
}
