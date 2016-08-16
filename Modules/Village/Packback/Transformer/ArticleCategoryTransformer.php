<?php

namespace Modules\Village\Packback\Transformer;

use Modules\Village\Entities\ArticleCategory;

class ArticleCategoryTransformer extends BaseTransformer
{
    /**
     * Turn user object into generic array
     *
     * @param ArticleCategory $ArticleCategory
     * @return array
     */
    public function transform(ArticleCategory $ArticleCategory)
    {
        return [
            'id' =>  $ArticleCategory->id,
            'title' => $ArticleCategory->title,
        ];
    }
}