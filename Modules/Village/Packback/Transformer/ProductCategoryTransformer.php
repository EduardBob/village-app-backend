<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\TransformerAbstract;
use Modules\Village\Entities\ProductCategory;

class ProductCategoryTransformer extends TransformerAbstract
{
    /**
     * Turn user object into generic array
     *
     * @param ProductCategory $productCategory
     * @return array
     */
    public function transform(ProductCategory $productCategory)
    {
        return [
            'id' =>  $productCategory->id,
            'title' => $productCategory->title,
        ];
    }
}