<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;

class VillageUser extends User
{
    // use Translatable;

    // protected $table = 'village__users';
    // public $translatedAttributes = [];
    // protected $fillable = ['first_name', 'last_name', 'phone', 'password', 'building_id'];


    public function building() 
    {
        return $this->belongsTo('Modules\Village\Entities\Building');
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
