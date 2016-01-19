<?php namespace App\Observers;

use Modules\User\Events\UserWasUpdated;

class UserObserver
{
    /**
     * @param UserWasUpdated $user
     */
    public function handle(UserWasUpdated $user) {
    }
}