<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;

use Request;
use DB;

class Profile extends Model
{
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

    /**
     * @param User  $user
     * @param array $data
     */
    public function updateItem(User $user, array $data)
    {
        $profile = $user->profile();

        if ($profile) {
            $profile->update(['phone' => $data['phone']]);
            $profile->building()->associate(Building::find($data['building_id']));
            $profile->save();
        }
    }

    /**
     * @param array $data
     * @param       $id
     */
    public function createItem(array $data, $id)
    {
        $profile = new Profile(['phone' => $data['phone']]);

        $user = User::find($id);
        $building = Building::find($data['building_id']);

        $profile->user()->associate($user);
        $profile->building()->associate($building);
        $profile->save();
    }

    public function getList()
    {
        $users = User::all(['last_name', 'first_name', 'id']);

        $list = [];
        foreach ($users as $key => $user) {
            $list[$user->id] = $user->last_name . ' ' . $user->first_name;
        }

        return $list;
    }
}
