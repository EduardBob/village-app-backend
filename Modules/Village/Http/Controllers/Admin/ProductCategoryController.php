<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\ProductCategory;
use Modules\Village\Repositories\ProductCategoryRepository;

use Validator;

class ProductCategoryController extends AdminController
{
    /**
     * @param ProductCategoryRepository $productCategory
     */
    public function __construct(ProductCategoryRepository $productCategory)
    {
        parent::__construct($productCategory);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'productcategories';
    }

    /**
     * @param array           $data
     * @param ProductCategory $productCategory
     *
     * @return mixed
     */
    static function validate(array $data, ProductCategory $productCategory = null)
    {
        $productCategoryId = $productCategory ? $productCategory->id : '';

        return Validator::make($data, [
            'title' => "required|max:255|unique:village__product_categories,title,{$productCategoryId}",
        ]);
    }
}
