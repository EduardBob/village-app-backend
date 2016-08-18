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
            'short' => str_replace(array("\r\n", "\r", "\n"), "<br />", strip_tags($article->short)),
            'text' => str_replace(array("\r\n", "\r", "\n"), "<br />", strip_tags($article->text)),
            'created_at' => $article->created_at->format('Y-m-d H:i:s'),
            'published_at' =>  $article->published_at,
            'category_id' => $article->category->id,
            'category_title' => $article->category->title,
            'image' => $this->getImage($article->files()->first()),
        ];
    }
}