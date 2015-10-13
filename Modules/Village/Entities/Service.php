<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Media\Support\Traits\MediaRelation;

class Service extends Model
{
    use MediaRelation;

    protected $table = 'village__services';

    protected $fillable = ['category_id', 'title', 'price', 'active', 'text', 'comment_label', 'order_button_label'];

    public function category()
    {
    	return $this->belongsTo('Modules\Village\Entities\ServiceCategory', 'category_id');
    }

    public function orders()
    {
    	return $this->hasMany('Modules\Village\Entities\ServiceOrder', 'service_id');
    }
}
