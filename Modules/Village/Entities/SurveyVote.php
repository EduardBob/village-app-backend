<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class SurveyVote extends Model
{
    protected $table = 'village__survey_votes';
    public $translatedAttributes = [];
    protected $fillable = ['choice'];

    public function survey()
    {
    	return $this->belongsTo('Modules\Village\Entities\Survey');
    }

    public function profile()
    {
        return $this->belongsTo('Modules\Village\Entities\Profile', 'user_id');
    }
}
