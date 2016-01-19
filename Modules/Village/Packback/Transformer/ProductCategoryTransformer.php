<?php

namespace Modules\Village\Packback\Transformer;

use Modules\Village\Entities\ProductCategory;

class ProductCategoryTransformer extends BaseTransformer
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
            'image' => $this->getImage($productCategory->files()->first()),
        ];
    }
}