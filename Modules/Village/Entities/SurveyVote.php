<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class SurveyVote extends Model
{
    use ApiScope;
    use VillageAdminScope;

    protected $table = 'village__survey_votes';

    protected $fillable = ['village_id', 'survey_id', 'user_id', 'choice'];

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
            $surveyVote->village()->associate($surveyVote->survey()->first()->village_id);
        });
    }

    static public function findVote(Survey $survey, User $user)
    {
        return static::where(['survey_id' => $survey->id, 'user_id' => $user->id])->first();
    }

    static public function countVotesBySurvey(Survey $survey)
    {
        $data = static
            ::select(\DB::raw("COUNT(choice) count, choice"))
            ->where(['survey_id' => $survey->id])
            ->groupBy('choice')
            ->orderBy('choice', 'ASC')
            ->get()
            ->toArray()
        ;

        $result = [];
        foreach ($data as $item) {
            $result[$item['choice']] = $item['count'];
        }

        return $result;
    }
}
