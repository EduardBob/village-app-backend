<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class Survey extends Model
{
    use ApiScope;
    use VillageAdminScope;
    use SoftDeletes;

    protected $table = 'village__surveys';

    protected $dates = ['deleted_at', 'ends_at'];

    protected $fillable = ['village_id', 'title', 'options', 'ends_at', 'active'];

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id');
    }

    public function votes()
    {
    	return $this->hasMany('Modules\Village\Entities\SurveyVote');
    }

    /**
     * @return $this
     */
    static public function getCurrent()
    {
        return static::api()
            ->where('ends_at', '>', date('Y-m-d H:i:s'))
            ->orderBy('id', 'desc')
            ->first();
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function(Survey $survey) {
            if (is_array($survey->options)) {
                $survey->options = array_filter($survey->options);
                $survey->options = json_encode($survey->options);
            }
        });
    }
}
