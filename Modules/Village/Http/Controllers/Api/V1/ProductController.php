<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\Product;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Packback\Transformer\ProductTransformer;

class ProductController extends ApiController
{
    /**
     * Get all products
     *
     * @return Response
     */
    public function index()
    {
        $products = Product::where(['active' => 1])->orderBy('title', 'asc')->get();

        return $this->response->withCollection($products, new ProductTransformer);
    }

    /**
     * Get a single product
     *
     * @param int $productId
     * @return Response
     */
    public function show($productId)
    {
        $product = Product::find($productId);
        if(!$product){
            return $this->response->errorNotFound('Not Found');
        }

        return $this->response->withItem($product, new ProductTransformer);
    }
}