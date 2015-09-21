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
        $serviceCategories = ServiceCategory::where(['active' => 1])->orderBy('order', 'desc')->get();

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
        $serviceCategory = ServiceCategory::find($serviceCategoryId);
        if(!$serviceCategory){
            return $this->response->errorNotFound('Not Found');
        }

        return $this->response->withItem($serviceCategory, new ServiceCategoryTransformer);
    }
}