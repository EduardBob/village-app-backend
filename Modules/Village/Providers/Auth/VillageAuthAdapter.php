<?php

namespace Modules\Village\Providers\Auth;

use Modules\Village\Exceptions\UserNotActivatedException;
use Modules\Village\Entities\User;
use Tymon\JWTAuth\Providers\Auth\IlluminateAuthAdapter;

class VillageAuthAdapter extends IlluminateAuthAdapter
{
    /**
     * Get the currently authenticated user
     *
     * @throws UserNotActivatedException
     * @return User
     */
    public function user()
    {
        if (!$this->auth->user()->isActivated()) {
            throw new UserNotActivatedException('user not activated');
        }

        return $this->auth->user();
    }
}
