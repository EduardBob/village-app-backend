<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

use Modules\User\Entities\Sentinel\User;
use Modules\Village\Entities\Building;

use Validator;
use Request;

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

    public function updateItem($user, $data)
    {
        $profile = $user->profile();

        $profile->update(['phone' => $data['phone']]);
        $profile->building()->associate(Building::find($data['building_id']));
        $profile->save();
    }

    public function createItem($data, $id)
    {
        $profile = new Profile(['phone' => $data['phone']]);

        $user = User::find($id);
        $building = Building::find($data['building_id']);

        $profile->user()->associate($user);
        $profile->building()->associate($building);
        $profile->save();
    }
}
