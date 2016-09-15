<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class DocumentCategory extends Model
{
    use MediaRelation;
    use ApiScope;
    use VillageAdminScope;
    use SoftDeletes;

    protected $table = 'village__document_categories';


    protected $fillable = ['title', 'order', 'active', 'is_global'];

    public function documents()
    {
    	return $this->hasMany('Modules\Village\Entities\Document', 'category_id');
    }
}
