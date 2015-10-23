<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class Article extends Model
{
    use MediaRelation;
    use ApiScope;
    use VillageAdminScope;

    protected $table = 'village__articles';

    protected $fillable = ['village_id', 'title', 'text', 'active'];

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function(Article $article) {
            $article->short = static::generateShort($article->text);
        });
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
