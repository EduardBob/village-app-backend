<?php namespace Modules\Village\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Modules\User\Entities\Sentinel\User as BaseUser;
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
    // Users with role 'executor' can be attached by administrator to additional villages.
    public function additionalVillages()
    {
        return $this->belongsToMany('Modules\Village\Entities\Village', 'village__village_user');
    }

    public function articles()
    {
        return $this->belongsToMany('Modules\Village\Entities\Article', 'village__article_user');
    }

    public function documents()
    {
        return $this->belongsToMany('Modules\Village\Entities\Document', 'village__document_user');
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
     * Get all users array of village_id->role_id->user.
     * @return array
     */
    public function getListWithRoles()
    {
        $users = $this->all(['last_name', 'first_name', 'village_id', 'id']);
        $list  = [];
        foreach ($users as $key => $user) {
            foreach ($user->roles as $role) {
                $list[$user->village_id][$role->id][$user->id] = str_replace('"', '', $user->last_name . ' ' . $user->first_name);
            }
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
