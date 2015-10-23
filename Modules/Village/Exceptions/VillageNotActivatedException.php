<?php namespace Modules\Village\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;

class VillageNotActivatedException extends JWTException
{
    /**
     * @var integer
     */
    protected $statusCode = 403;

    public function __construct()
    {
        parent::__construct('village_not_activated', $this->statusCode);
    }
}
