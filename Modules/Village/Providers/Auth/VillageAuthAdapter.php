<?php

namespace Modules\Village\Providers\Auth;

use Modules\Village\Exceptions\UserNotActivatedException;
use Modules\Village\Entities\User;
use Modules\Village\Exceptions\UserWithoutBuildingException;
use Modules\Village\Exceptions\VillageNotActivatedException;
use Tymon\JWTAuth\Providers\Auth\IlluminateAuthAdapter;

class VillageAuthAdapter extends IlluminateAuthAdapter
{
    /**
     * Get the currently authenticated user
     *
     * @throws UserNotActivatedException
     * @throws UserWithoutBuildingException
     * @throws VillageNotActivatedException
     * @return User
     */
    public function user()
    {
        /** @var User $user */
        $user = $this->auth->user();

        if (!$user->isActivated()) {
            throw new UserNotActivatedException();
        }

        if (!$building = $user->building) {
            throw new UserWithoutBuildingException();
        }

        if (!$building->village->active) {
            throw new VillageNotActivatedException();
        }

        return $user;
    }
}
