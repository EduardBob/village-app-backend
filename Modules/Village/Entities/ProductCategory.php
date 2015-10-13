<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Media\Support\Traits\MediaRelation;

class ProductCategory extends Model
{
    use MediaRelation;

    protected $table = 'village__product_categories';

    protected $fillable = ['title', 'order', 'active'];

    public function products()
    {
    	return $this->hasMany('Modules\Village\Entities\Product', 'category_id');
    }
}
