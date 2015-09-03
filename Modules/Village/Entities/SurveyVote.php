<?php namespace Modules\Village\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class SurveyVote extends Model
{
    use Translatable;

    protected $table = 'village__surveyvotes';
    public $translatedAttributes = [];
    protected $fillable = [];
}
