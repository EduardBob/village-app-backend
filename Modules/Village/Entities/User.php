<?php namespace Modules\Village\Entities;

use Modules\User\Entities\Sentinel\User as BaseUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends BaseUser implements AuthenticatableContract
{
    use Authenticatable;

    protected $fillable = [
        'email',
        'password',
        'permissions',
        'first_name',
        'last_name',
        'phone',
        'building_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function(User $user) {
            if (!$user->building_id) {
                $user->building_id = null;
            }
        });
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
}
