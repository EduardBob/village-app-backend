<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\Article;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Packback\Transformer\ArticleTransformer;

class ArticleController extends ApiController
{
    /**
     * Get all articles
     *
     * @return Response
     */
    public function index()
    {
        $articles = Article::api()
          ->where('village__articles.published_at',  '<=', date('Y-m-d H:i:s'))
          ->orderBy('village__articles.published_at', 'desc')->paginate(10);
        return $this->response->withCollection($articles, new ArticleTransformer);
    }

    /**
     * Get a single article
     *
     * @param int $articleId
     * @return Response
     */
    public function show($articleId)
    {
        $article = Article::api()->where('id', $articleId)->first();
        if(!$article){
            return $this->response->errorNotFound('Not Found');
        }

        return $this->response->withItem($article, new ArticleTransformer);
    }
}