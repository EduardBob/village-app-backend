<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Entities\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return User
     */
    protected function user()
    {
        return JWTAuth::parseToken()->authenticate();
    }
}