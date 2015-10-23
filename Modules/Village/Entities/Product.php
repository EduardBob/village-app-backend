<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

use DB;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class Product extends Model
{
    use MediaRelation;
    use ApiScope;
    use VillageAdminScope;

    protected $table = 'village__products';

    protected $fillable = ['category_id', 'title', 'price', 'unit_title', 'active', 'comment_label', 'text'];

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id');
    }

    public function category()
    {
    	return $this->belongsTo('Modules\Village\Entities\ProductCategory', 'category_id');
    }

    public function orders()
    {
    	return $this->hasMany('Modules\Village\Entities\ProductOrder', 'product_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function(Product $product) {
            $product->village()->associate($product->category->village);
        });
    }

    public function getAll() {
        $items = DB::table($this->table)->lists('title', 'id');

        return $items;
    }
}
