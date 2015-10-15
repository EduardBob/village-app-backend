<?php namespace Modules\Village\Events\Handlers;

use Modules\User\Events\UserHasRegistered;

class SendRegistrationConfirmationEmail extends \Modules\User\Events\Handlers\SendRegistrationConfirmationEmail
{
    public function handle(UserHasRegistered $event)
    {
        return false;
    }
}
