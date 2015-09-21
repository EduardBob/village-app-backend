<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use EllipseSynergie\ApiResponse\Contracts\Response;

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
}