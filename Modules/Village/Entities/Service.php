<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class Service extends Model
{
    use MediaRelation;
    use ApiScope;
    use VillageAdminScope;
    use SoftDeletes;

    public $table = 'village__services';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'base_id', 'village_id', 'category_id', 'price', 'active', 'title', 'text', 'comment_label', 'order_button_label', 'show_perform_time'];

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $comment_label;

    /**
     * @var string
     */
    protected $order_button_label;

    public function base()
    {
        return $this->belongsTo('Modules\Village\Entities\BaseService', 'base_id');
    }

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id')->withTrashed();
    }

    public function category()
    {
    	return $this->belongsTo('Modules\Village\Entities\ServiceCategory', 'category_id')->withTrashed();
    }

    public function orders()
    {
    	return $this->hasMany('Modules\Village\Entities\ServiceOrder', 'service_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function executors()
    {
        return $this->hasMany('Modules\Village\Entities\ServiceExecutor');
    }

    static public function getRewriteFields()
    {
        return ['title', 'text', 'comment_label', 'order_button_label'];
    }

    public function getTitleAttribute($value)
    {
        if (!is_null($value)) {
            return $value;
        }
        elseif ($this->base) {
            return $this->base->title;
        }

        return '';
    }

    public function getTextAttribute($value)
    {
        if (!is_null($value)) {
            return $value;
        }
        elseif ($this->base) {
            return $this->base->text;
        }

        return '';
    }

    public function getCommentLabelAttribute($value)
    {
        if (!is_null($value)) {
            return $value;
        }
        elseif ($this->base) {
            return $this->base->comment_label;
        }

        return '';
    }

    public function getOrderButtonLabelAttribute($value)
    {
        if (!is_null($value)) {
            return $value;
        }
        elseif ($this->base) {
            return $this->base->order_button_label;
        }

        return '';
    }

    public function findOneByVillageAndBaseId(Village $village, $baseId)
    {
        return self::where(['village_id' => $village->id, 'base_id' => $baseId])->first();
    }
}
