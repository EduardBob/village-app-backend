<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Scope\VillageAdminScope;

class BaseSurvey extends Model
{
    use VillageAdminScope;

    protected $table = 'village__base__surveys';

    protected $fillable = ['title', 'options', 'active'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function(BaseSurvey $survey) {
            if (is_array($survey->options)) {
                $survey->options = array_filter($survey->options);
                $survey->options = json_encode($survey->options);
            }
        });
    }
}
