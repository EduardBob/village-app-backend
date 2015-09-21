<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class SurveyVote extends Model
{
    protected $table = 'village__survey_votes';

    protected $fillable = ['survey_id', 'user_id', 'choice'];

    public function survey()
    {
    	return $this->belongsTo('Modules\Village\Entities\Survey');
    }

    public function user()
    {
        return $this->belongsTo('Modules\User\Entities\Sentinel\User');
    }
}
