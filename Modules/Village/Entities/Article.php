<?php namespace Modules\Village\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;

class Article extends Model
{

    use MediaRelation;
    use ApiScope;
    use VillageAdminScope;

//    protected $casts = [
//      'is_admin' => 'boolean',
//    ];
    protected $table = 'village__articles';
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'published_at'];
    protected $fillable = ['village_id', 'title', 'text', 'active', 'base_id', 'category_id', 'published_at'];

    public function base()
    {
        return $this->belongsTo('Modules\Village\Entities\BaseArticle', 'base_id');
    }

    public function category()
    {
        return $this->belongsTo('Modules\Village\Entities\ArticleCategory', 'category_id');
    }

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id');

    }

    /**
     * Null value setter for DB query (by default empty sting is passed).
     *
     * @param $value
     */
    public function setVillageIdAttribute($value)
    {
        $this->attributes['village_id'] = ($value == '') ? null : $value;
    }

    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = (new Carbon($value))->format('Y-m-d H:i:00');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function (Article $article) {

            $article->short = static::generateShort($article->text);
        });
    }

    /**
     * @param string $text
     * @param int $limit
     *
     * @return string
     */
    static public function generateShort($text, $limit = 200)
    {
        return (mb_strlen($text) <= $limit) ? $text : substr($text, 0, $limit - 3) . '...';
    }
}
