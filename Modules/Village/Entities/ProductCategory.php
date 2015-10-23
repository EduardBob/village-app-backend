<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Media\Support\Traits\MediaRelation;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class ProductCategory extends Model
{
    use MediaRelation;
    use ApiScope;
    use VillageAdminScope;

    protected $table = 'village__product_categories';

    protected $fillable = ['village_id', 'title', 'order', 'active'];

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id');
    }

    public function products()
    {
    	return $this->hasMany('Modules\Village\Entities\Product', 'category_id');
    }
}
