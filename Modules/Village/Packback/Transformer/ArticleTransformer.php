<?php

namespace Modules\Village\Packback\Transformer;

use Modules\Village\Entities\Article;
use Tymon\JWTAuth\Facades\JWTAuth;

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
     * @return User
     */
    protected function user()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    /**
     * Turn article object into generic array
     *
     * @param Article $article
     *
     * @return array
     */
    public function transform(Article $article)
    {
        $article = $this->personalizeArticle($article);

        return [
          'id'           => $article->id,
          'title'        => $article->title,
          'short'        => str_replace(array("\r\n", "\r", "\n"), "<br />", strip_tags($article->short)),
          'text'         => $article->text,
          'created_at'   => $article->created_at->format('Y-m-d H:i:s'),
          'published_at' => $article->published_at->format('Y-m-d H:i:s'),
          'image'        => $this->getImage($article->files()->first()),
          'is_personal'  => $article->is_personal
        ];
    }

    /**
     * Personalize article if needed.
     *
     * @param Article $article
     *
     * @return Article
     */
    private function personalizeArticle(Article $article)
    {
        $user = $this->user()->load('building');
        if ($article->is_personal && strpos($article->text, '##') !== false) {
            $templates            = ['##first_name##', '##last_name##', '##facility##', '##address##'];
            $personalReplacements = [$user->first_name, $user->last_name, $user->village->name, $user->building->address];
            $article->text        = str_replace($templates, $personalReplacements, $article->text);
            $article->short       = str_replace($templates, $personalReplacements, $article->short);
        }
        return $article;
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
        if ($article->category) {
            return $this->item($article->category, new ArticleCategoryTransformer);
        }
        return;
    }
}
