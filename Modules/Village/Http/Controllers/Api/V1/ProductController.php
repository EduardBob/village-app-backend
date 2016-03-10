<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\Product;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Packback\Transformer\ProductTransformer;
use Request;

class ProductController extends ApiController
{
    /**
     * Get products list
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $products = Product::api()->orderBy('order', 'asc');
        if ($categoryId = $request::query('category_id')) {
            $products->where(['category_id' => $categoryId]);
        }

        return $this->response->withCollection($products->paginate(10), new ProductTransformer);
    }

    /**
     * Get a single product
     *
     * @param int $productId
     * @return Response
     */
    public function show($productId)
    {
        $product = Product::api()->where('id', $productId)->first();
        if(!$product || $product->active != 1){
            return $this->response->errorNotFound('Not Found');
        }

        return $this->response->withItem($product, new ProductTransformer);
    }
}