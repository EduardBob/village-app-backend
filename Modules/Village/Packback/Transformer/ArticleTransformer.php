<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\TransformerAbstract;
use Modules\Village\Entities\Article;

class ArticleTransformer extends TransformerAbstract
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
        ];
    }
}