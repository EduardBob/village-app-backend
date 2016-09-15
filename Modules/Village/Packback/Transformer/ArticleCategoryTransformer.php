<?php

namespace Modules\Village\Packback\Transformer;

use Modules\Village\Entities\ArticleCategory;

class ArticleCategoryTransformer extends BaseTransformer
{
    /**
     * Turn user object into generic array
     *
     * @param ArticleCategory $category
     * @return array
     */
    public function transform(ArticleCategory $category)
    {
        return [
          'id'    => $category->id,
          'title' => $category->title,
        ];
    }
}
