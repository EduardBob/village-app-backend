<?php

namespace Modules\Village\Packback\Transformer;

use Modules\Village\Entities\Article;

class ArticleTransformer extends BaseTransformer
{
    /**
     * Turn article object into generic array
     *
     * @param Article $article
     * @return array
     */
    public function transform(Article $article)
    {
        return [
            'id' =>  $article->id,
            'title' => $article->title,
            'short' => $article->short,
            'text' => $article->text,
            'image' => $this->getImage($article->files()->first()),
        ];
    }
}