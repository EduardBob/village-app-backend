<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Village\Entities\Scope\VillageAdminScope;

class BaseArticle extends Model
{
    use MediaRelation;
    use VillageAdminScope;

    protected $table = 'village__base__articles';

    protected $fillable = ['title', 'text', 'active', 'is_business', 'is_shopping', 'is_cottage', 'is_apartment'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function(BaseArticle $article) {
            $article->short = static::generateShort($article->text);
        });
    }

    public function category()
    {
        return $this->belongsTo('Modules\Village\Entities\ArticleCategory', 'category_id')->withTrashed();
    }

    /**
     * @param string $text
     * @param int    $limit
     *
     * @return string
     */
    static public function generateShort($text, $limit = 200)
    {
        return (mb_strlen($text) <= $limit) ? $text : substr($text, 0, $limit - 3).'...';
    }
}
