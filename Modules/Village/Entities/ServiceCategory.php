<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class ServiceCategory extends Model
{
    use MediaRelation;
    use ApiScope;
    use VillageAdminScope;
    use SoftDeletes;

    protected $table = 'village__service_categories';

    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'order', 'active'];

    public function services()
    {
        return $this->hasMany('Modules\Village\Entities\Service', 'category_id');
    }
}
