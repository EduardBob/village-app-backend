<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use DB;
class ServiceCategory extends Model
{
    // use Translatable;

    protected $table = 'village__service_categories';
    public $translatedAttributes = [];
    protected $fillable = ['title', 'order'];

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

    public function getAll() {
        $items = DB::table($this->table)->lists('title', 'id');

        return $items;
    }
}
