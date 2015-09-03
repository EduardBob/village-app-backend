<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class SurveyVoteTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'village__surveyvote_translations';
}
