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

    /**
     * @return $this
     */
    static public function getCurrent()
    {
        return static
            ::where(['active' => 1])
            ->where('ends_at', '>', date('Y-m-d H:i:s'))
            ->orderBy('id', 'desc')
            ->first();
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function(Survey $survey) {
            if (is_array($survey->options)) {
                $survey->options = json_encode($survey->options);
            }
        });
    }
}
