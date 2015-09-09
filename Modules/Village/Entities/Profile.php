<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    // use Translatable;

    protected $table = 'village__profiles';
    public $translatedAttributes = [];
    protected $fillable = ['phone', 'user_id', 'activated', 'building_id'];

    public function user()
    {
        $driver = config('asgard.user.users.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

    public function building() 
    {
        return $this->belongsTo('Modules\Village\Entities\Building')->first();
    }

    public function orders()
    {
    	return $this->hasMany('Modules\Village\Entities\ProductOrder', 'user_id');
    }

    public function votes()
    {
        return $this->hasMany('Modules\Village\Entities\SurveyVote', 'user_id');
    }
}
