<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class SurveyVote extends Model
{
    use ApiScope;
    use VillageAdminScope;

    protected $table = 'village__survey_votes';

    protected $fillable = ['survey_id', 'user_id', 'choice'];

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id');
    }

    public function survey()
    {
    	return $this->belongsTo('Modules\Village\Entities\Survey');
    }

    public function user()
    {
        return $this->belongsTo('Modules\Village\Entities\User');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function(SurveyVote $surveyVote) {
            $surveyVote->village()->associate($surveyVote->survey->village);
        });
    }

    static public function findVote(Survey $survey, User $user)
    {
        return static::where(['survey_id' => $survey->id, 'user_id' => $user->id])->first();
    }
}
