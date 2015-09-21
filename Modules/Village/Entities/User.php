<?php namespace Modules\Village\Entities;

use Modules\User\Entities\Sentinel\User as BaseUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends BaseUser implements AuthenticatableContract
{
    use Authenticatable;

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
