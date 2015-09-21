<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'village__surveys';

    protected $fillable = ['title', 'options', 'ends_at', 'active'];

    public function votes()
    {
    	return $this->hasMany('Modules\Village\Entities\SurveyVote');
    }
}
