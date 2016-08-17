<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\ArticleCategory;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Packback\Transformer\ArticleCategoryTransformer;

class ArticleCategoryController extends ApiController
{
    /**
     * Get all ArticleCategories
     *
     * @return Response
     */
    public function index()
    {
        $articleCategories = ArticleCategory::api()->orderBy('order', 'desc')->get();
        return $this->response->withCollection($articleCategories, new ArticleCategoryTransformer);
    }

}