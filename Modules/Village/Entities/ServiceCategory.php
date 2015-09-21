<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class ServiceCategory extends Model
{
    protected $table = 'village__service_categories';

    protected $fillable = ['title', 'order', 'active'];

    public function parent()
    {
        return $this->belongsTo('Modules\Village\Entities\ServiceCategory', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Modules\Village\Entities\ServiceCategory', 'parent_id');
    }

    public function services()
    {
        return $this->hasMany('Modules\Village\Entities\Service', 'category_id');
    }
}
