<?php namespace Modules\Village\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;

class UserWithoutBuildingException extends JWTException
{
    /**
     * @var integer
     */
    protected $statusCode = 403;

    public function __construct()
    {
        parent::__construct('user_without_building', $this->statusCode);
    }
}
