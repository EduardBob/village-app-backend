<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

use DB;
use Modules\Media\Support\Traits\MediaRelation;

class Product extends Model
{
    use MediaRelation;

    protected $table = 'village__products';

    protected $fillable = ['category_id', 'title', 'price', 'image', 'active', 'comment_label', 'text'];

    public function category()
    {
    	return $this->belongsTo('Modules\Village\Entities\ProductCategory', 'category_id');
    }

    public function orders()
    {
    	return $this->hasMany('Modules\Village\Entities\ProductOrder', 'product_id');
    }

    public function getAll() {
        $items = DB::table($this->table)->lists('title', 'id');

        return $items;
    }
}
