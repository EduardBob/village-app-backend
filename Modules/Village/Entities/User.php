<?php namespace Modules\Village\Entities;

use Modules\User\Entities\Sentinel\User as BaseUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Modules\Village\Entities\Scope\VillageAdminScope;

class User extends BaseUser implements AuthenticatableContract
{
    use Authenticatable;
    use VillageAdminScope;

    protected $fillable = [
        'email',
        'password',
        'permissions',
        'first_name',
        'last_name',
        'phone',
        'building_id',
        'has_mail_notifications',
        'has_sms_notifications'
    ];

    public function activation()
    {
        return $this->hasOne('Cartalyst\Sentinel\Activations\EloquentActivation');
    }

    public function smartHome()
    {
        return $this->hasOne('Modules\Village\Entities\SmartHome');
    }

    public function devices()
    {
        return $this->hasMany('Modules\Village\Entities\UserDevice');
    }

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id');
    }

    public function building()
    {
        return $this->belongsTo('Modules\Village\Entities\Building', 'building_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (User $user) {
            if ($user->building) {
                $user->village()->associate($user->building->village);
            }
        });

        static::saving(function (User $user) {
            if (!$user->email) {
                $user->email = null;
            }
            if (!$user->village_id) {
                $user->village_id = null;
            }
            if (!$user->building_id) {
                $user->building_id = null;
            }
        });
    }

    /**
     * Check if the current user is activated
     * @return bool
     */
    public function isActivated()
    {
        $activation = $this->activation;

        return $activation ? (bool)$activation->completed : false;
    }

    /**
     * @return array
     */
    public function getList()
    {
        $users = $this->all(['last_name', 'first_name', 'id']);

        $list = [];
        foreach ($users as $key => $user) {
            $list[$user->id] = $user->last_name . ' ' . $user->first_name;
        }

        return $list;
    }

	/**
	 * @return array
	 */
	public function getVillageAdminList()
	{
		$users = $this->all(['last_name', 'first_name', 'id']);

		$list = [];
		foreach ($users as $key => $user) {
			if ($user->inRole('village-admin')) {
				$list[$user->id] = $user->last_name . ' ' . $user->first_name;
			}
		}

		return $list;
	}
}
