<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Entities\Article;
use Modules\Village\Packback\Transformer\ArticleTransformer;
use Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends ApiController
{

    /**
     * Get all articles
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = $this->user()->load('building');
        $userRoles = $user->roles()->select('id')->lists('id');
        $personalArticles = $user->articles()->select('article_id')->lists('article_id')->toArray();
        $personalAllArticles = $users = DB::table('village__article_user')->groupBy('article_id')->lists('article_id');
        $categoryId = (int) $request::query('category_id');

        $articles = Article::api();
        $articles->where('published_at', '<=', date('Y-m-d H:i:s'));
        $articles->where('is_personal', '=', 0);
        $articles->where('active', '=', 1);
        if ($categoryId) {
            $articles
              ->where('category_id', '=', $categoryId)
              ->orWhere(function ($query) use ($categoryId) {
                  $query->whereNull('village_id')
                        ->where('category_id', '=', (int)$categoryId)
                        ->where('active', '=', 1)
                        ->where('published_at', '<=', date('Y-m-d H:i:s'));
              })
              // Getting personal items by user role, item should not be assigned to any user.
              ->orWhere(function ($query) use ($categoryId, $userRoles, $personalAllArticles) {
                  $query->where('is_personal', '=', 1)
                        ->where('category_id', '=', (int)$categoryId)
                        ->where('active', '=', 1)
                        ->whereNotIn('id', $personalAllArticles)
                        ->where('published_at', '<=', date('Y-m-d H:i:s'))
                        ->whereIn('role_id', $userRoles);
              })
              // Getting personal items by user relation.
              ->orWhere(function ($query) use ($personalArticles, $categoryId) {
                  $query->whereIn('id', $personalArticles)
                        ->where('category_id', '=', (int)$categoryId)
                        ->where('active', '=', 1)
                        ->where('published_at', '<=', date('Y-m-d H:i:s'));
              });

        } else {
            $articles
              ->orWhere(function ($query) {
                  $query->whereNull('village_id')
                        ->where('active', '=', 1)
                        ->where('published_at', '<=', date('Y-m-d H:i:s'));
              })
              // Adding personal articles attached to users role.
              ->orWhere(function ($query) use ($userRoles, $personalAllArticles) {
                  $query->where('is_personal', '=', 1)
                        ->where('published_at', '<=', date('Y-m-d H:i:s'))
                        ->where('active', '=', 1)
                        ->whereNotIn('id', $personalAllArticles)
                        ->whereIn('role_id', $userRoles);
              })
              ->orWhere(function ($query) use ($personalArticles) {
                  $query->whereIn('id', $personalArticles)
                        ->where('active', '=', 1)
                        ->where('published_at', '<=', date('Y-m-d H:i:s'));
              });
        }

        $articles = $articles->orderBy('published_at', 'desc')->paginate(10);
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
