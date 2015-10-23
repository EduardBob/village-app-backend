<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Media\Support\Traits\MediaRelation;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class Service extends Model
{
    use MediaRelation;
    use ApiScope;
    use VillageAdminScope;

    protected $table = 'village__services';

    protected $fillable = ['category_id', 'title', 'price', 'active', 'text', 'comment_label', 'order_button_label'];

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id');
    }

    public function category()
    {
    	return $this->belongsTo('Modules\Village\Entities\ServiceCategory', 'category_id');
    }

    public function orders()
    {
    	return $this->hasMany('Modules\Village\Entities\ServiceOrder', 'service_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function(Service $service) {
            $service->village()->associate($service->category->village);
        });
    }
}
