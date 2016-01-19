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
        $productCategories = ProductCategory::api()
            ->whereHas('products', function($query) {
                $query->where(['village__products.active' => 1, 'village_id' => $this->user()->village->id]);
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
        $productCategory = ProductCategory::api()->where('id', $productCategoryId)->first();
        if(!$productCategory){
            return $this->response->errorNotFound('Not Found');
        }

        return $this->response->withItem($productCategory, new ProductCategoryTransformer);
    }
}