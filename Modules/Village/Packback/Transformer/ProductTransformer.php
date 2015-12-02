<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\Resource\Item;
use Modules\Village\Entities\Margin;
use Modules\Village\Entities\Product;

class ProductTransformer extends BaseTransformer
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['category'];

    /**
     * List of resources to automatically include
     *
     * @var  array
     */
    protected $defaultIncludes = ['category'];

    /**
     * Turn product object into generic array
     *
     * @param Product $product
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'id' =>  $product->id,
            'title' => $product->title,
            'price' => Margin::getFinalPrice($product->price),
            'unit_title' => $product->unit_title,
            'text' => $product->text,
            'comment_label' => $product->comment_label,
            'show_perform_at' => $product->show_perform_at,
            'image' => $this->getImage($product->files()->first()),
        ];
    }

    /**
     * Include category in product
     *
     * @param Product $product
     * @return Item
     */
    public function includeCategory(Product $product)
    {
        return $this->item($product->category, new ProductCategoryTransformer);
    }
}