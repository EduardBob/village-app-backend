<?php

namespace Modules\Village\Http\Controllers\Api\V1\Security;

use Modules\Village\Entities\Service;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Http\Controllers\Api\V1\ApiController;
use Modules\Village\Packback\Transformer\ServiceTransformer;
use Request;

class ServiceController extends ApiController
{
    /**
     * Get all services where user assigned as executor
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $services = Service::api()
            ->select('village__services.*')
            ->leftJoin('village__service_executors', 'village__service_executors.service_id', '=', 'village__services.id')
            ->where('village__service_executors.user_id', $this->user()->id)
            ->orderBy('title', 'asc')
        ;

//        if ($categoryId = $request::query('category_id')) {
//            $services->where('category_id', $categoryId);
//        }

        return $this->response->withCollection($services->get(), new ServiceTransformer);
    }
}