<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\Service;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Packback\Transformer\ServiceTransformer;
use Request;

class ServiceController extends ApiController
{
    /**
     * Get all services
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $services = Service::where(['active' => 1])->orderBy('title', 'asc');
        if ($categoryId = $request::query('category_id')) {
            $services->where(['category_id' => $categoryId]);
        }

        return $this->response->withCollection($services->get(), new ServiceTransformer);
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