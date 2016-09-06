<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Entities\Article;
use Modules\Village\Packback\Transformer\ArticleTransformer;
use Request;

class ArticleController extends ApiController
{

    /**
     * Get all articles
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $articles = Article::api()
                           ->where('published_at', '<=', date('Y-m-d H:i:s'))
                           ->orWhere(function ($query) {
                               $query->whereNull('village_id')
                                     ->where('published_at', '<=', date('Y-m-d H:i:s'));
                           })
                           ->orderBy('published_at', 'desc')->paginate(10);

        if ($categoryId = $request::query('category_id')) {
            $articles = Article::api()
                               ->where('published_at', '<=', date('Y-m-d H:i:s'))
                               ->where('category_id', '=', (int)$categoryId)
                               ->orWhere(function ($query) use ($categoryId) {
                                   $query->whereNull('village_id')
                                         ->where('category_id', '=', (int)$categoryId)
                                         ->where('published_at', '<=', date('Y-m-d H:i:s'));
                               })
                               ->orderBy('published_at', 'desc')->paginate(10);
        }
        return $this->response->withCollection($articles, new ArticleTransformer);
    }

    /**
     * Get a single article
     *
     * @param int $articleId
     *
     * @return Response
     */
    public function show($articleId)
    {

        $article = Article::api();
        $article->where('id', $articleId);
        $article->orWhere(function ($query) use ($articleId) {
            $query->where('id', $articleId)
                  ->whereNull('village_id');
        });
        $article = $article->first();
        
        if (!$article) {
            return $this->response->errorNotFound('Not Found');
        }

        return $this->response->withItem($article, new ArticleTransformer);
    }
}
