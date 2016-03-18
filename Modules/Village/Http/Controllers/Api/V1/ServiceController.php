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
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $services = Service::api()
	        ->select('village__services.*')
	        ->orderBy('village__services.order', 'asc')
        ;

        if ($categoryId = $request::query('category_id')) {
            $services->where(['village__services.category_id' => $categoryId]);
        }

	    if ($search = $request::query('search')) {
		    $fields = ['title', 'comment_label', 'text'];
		    $services
                ->join('village__base__services', 'village__services.base_id', '=', 'village__base__services.id')
			    ->where(function($query) use ($search, $fields){
			    foreach($fields as $field) {
				    $query
					    ->orWhere(\DB::raw('(IFNULL(village__services.'.$field.', village__base__services.'.$field.'))'), 'like', '%'.$search.'%')
				    ;
			    }
		    });
	    }

        return $this->response->withCollection($services->paginate(10), new ServiceTransformer);
    }

    /**
     * Get a single service
     *
     * @param int $serviceId
     * @return Response
     */
    public function show($serviceId)
    {
        $service = Service::api()->where('id', $serviceId)->first();
        if(!$service || $service->active != 1){
            return $this->response->errorNotFound('Not Found');
        }

        return $this->response->withItem($service, new ServiceTransformer);
    }
}