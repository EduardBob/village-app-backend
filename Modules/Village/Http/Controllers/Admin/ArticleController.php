<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\Article;
use Modules\Village\Repositories\ArticleRepository;

use Validator;

class ArticleController extends AdminController
{
    /**
     * @param ArticleRepository $article
     */
    public function __construct(ArticleRepository $article)
    {
        parent::__construct($article, Article::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'articles';
    }

    /**
     * @param array   $data
     * @param Article $article
     *
     * @return Validator
     */
    static function validate(array $data, Article $article = null)
    {
        return Validator::make($data, [
            'title' => "required|max:255",
            'text' => "required",
            'active' => "required|boolean",
        ]);
    }
}
