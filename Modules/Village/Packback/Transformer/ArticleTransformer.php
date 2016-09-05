<?php

namespace Modules\Village\Packback\Transformer;

use Modules\Village\Entities\Article;

class ArticleTransformer extends BaseTransformer
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
     * Turn article object into generic array
     *
     * @param Article $article
     *
     * @return array
     */
    public function transform(Article $article)
    {
        return [
          'id'             => $article->id,
          'title'          => $article->title,
          'short'          => str_replace(array("\r\n", "\r", "\n"), "<br />", strip_tags($article->short)),
          'text'           => str_replace(array("\r\n", "\r", "\n"), "<br />", strip_tags($article->text)),
            // TODO remove this on second release.
          'category_id'    => $article->category->id,
          'category_title' => $article->category->title,
          'created_at'   => $article->created_at->format('Y-m-d H:i:s'),
          'published_at' => $article->published_at->format('Y-m-d H:i:s'),
          'image'        => $this->getImage($article->files()->first()),
        ];
    }

    /**
     * Include ArticleCategory
     *
     * @param Article $article
     *
     * @return Item
     */
    public function includeCategory(Article $article)
    {
        return $this->item($article->category, new ArticleCategoryTransformer);
    }
}