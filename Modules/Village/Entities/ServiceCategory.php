<?php namespace Modules\Village\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use Translatable;

    protected $table = 'village__servicecategories';
    public $translatedAttributes = [];
    protected $fillable = [];

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
        return $this->belongsToMany('Modules\Village\Entities\Service', 'service_category_id');
    }
}
