<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'village__articles';

    protected $fillable = ['title', 'text', 'active'];

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
     * @param string $chr
     *
     * @return string
     */
    static public function generateShort($text, $limit = 200, $chr = '&#8230;')
    {
        return (mb_strlen($text) <= $limit) ? $text : substr($text, 0, $limit - 3).$chr;
    }
}
