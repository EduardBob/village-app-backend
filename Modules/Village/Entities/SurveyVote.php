<?php namespace Modules\Village\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class SurveyVote extends Model
{
    use Translatable;

    protected $table = 'village__surveyvotes';
    public $translatedAttributes = [];
    protected $fillable = [];

    public function survey()
    {
    	return $this->belongsTo('Modules\Village\Entities\Survey');
    }

    public function user()
    {
    	return $this->belongsTo('Modules\Village\Entities\User');
    }
}
