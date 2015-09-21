<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Village\Entities\Product;
use Modules\Village\Repositories\ProductRepository;

use Modules\Village\Entities\ProductCategory;
use Validator;

class ProductController extends AdminController
{
    /**
     * @param ProductRepository $product
     */
    public function __construct(ProductRepository $product)
    {
        parent::__construct($product, Product::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'products';
    }

    /**
     * @param array   $data
     * @param Product $product
     *
     * @return Validator
     */
    static function validate(array $data, Product $product = null)
    {
        $productId = $product ? $product->id : '';

        return Validator::make($data, [
            'category_id' => 'required|exists:village__product_categories,id',
            'title' => "required|max:255|unique:village__products,title,{$productId}",
            'price' => 'required|numeric|min:1',
            'active' => "required|boolean",
        ]);
    }
}
