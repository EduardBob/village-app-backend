<?php namespace Modules\Village\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;

class UserNotActivatedException extends JWTException
{
    /**
     * @var integer
     */
    protected $statusCode = 400;
}
