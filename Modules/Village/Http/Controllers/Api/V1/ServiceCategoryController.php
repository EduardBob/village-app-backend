<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\ServiceCategory;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Packback\Transformer\ServiceCategoryTransformer;

class ServiceCategoryController extends ApiController
{
    /**
     * Get all serviceCategories
     *
     * @return Response
     */
    public function index()
    {
        $serviceCategories = ServiceCategory::api()
            ->whereHas('services', function($query) {
                $query->where(['village__services.active' => 1, 'village_id' => $this->user()->village->id]);
            })
            ->orderBy('order', 'asc')->get();

        return $this->response->withCollection($serviceCategories, new ServiceCategoryTransformer);
    }

    /**
     * Get a single serviceCategory
     *
     * @param int $serviceCategoryId
     * @return Response
     */
    public function show($serviceCategoryId)
    {
        $serviceCategory = ServiceCategory::api()->where('id', $serviceCategoryId)->first();
        if(!$serviceCategory){
            return $this->response->errorNotFound('Not Found');
        }

        return $this->response->withItem($serviceCategory, new ServiceCategoryTransformer);
    }
}