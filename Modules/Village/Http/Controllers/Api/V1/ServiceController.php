<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\Service;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Packback\Transformer\ServiceTransformer;

class ServiceController extends ApiController
{
    /**
     * Get all services
     *
     * @return Response
     */
    public function index()
    {
        $services = Service::where(['active' => 1])->orderBy('title', 'asc')->get();

        return $this->response->withCollection($services, new ServiceTransformer);
    }

    /**
     * Get a single service
     *
     * @param int $serviceId
     * @return Response
     */
    public function show($serviceId)
    {
        $service = Service::find($serviceId);
        if(!$service){
            return $this->response->errorNotFound('Not Found');
        }

        return $this->response->withItem($service, new ServiceTransformer);
    }
}