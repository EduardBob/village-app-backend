<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\ProductCategory;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Packback\Transformer\ProductCategoryTransformer;

class ProductCategoryController extends ApiController
{
    /**
     * Get all productCategories
     *
     * @return Response
     */
    public function index()
    {
        $productCategories = ProductCategory::where(['active' => 1])
            ->whereHas('products', function($query) {
                $query->where(['active' => 1]);
            })
            ->orderBy('order', 'desc')->get();

        return $this->response->withCollection($productCategories, new ProductCategoryTransformer);
    }

    /**
     * Get a single productCategory
     *
     * @param int $productCategoryId
     * @return Response
     */
    public function show($productCategoryId)
    {
        $productCategory = ProductCategory::find($productCategoryId);
        if(!$productCategory){
            return $this->response->errorNotFound('Not Found');
        }

        return $this->response->withItem($productCategory, new ProductCategoryTransformer);
    }
}