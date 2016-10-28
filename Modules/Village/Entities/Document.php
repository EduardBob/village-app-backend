<?php namespace Modules\Village\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Village\Entities\Scope\ApiScope;
use Modules\Village\Entities\Scope\VillageAdminScope;


class Document extends Model
{

    use MediaRelation;
    use ApiScope;
    use VillageAdminScope;


    protected $table = 'village__documents';
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'published_at'];
    protected $fillable = ['village_id', 'title', 'text', 'active', 'published_at', 'is_personal', 'is_protected', 'role_id', 'category_id'];

    public function users()
    {
        return $this->belongsToMany('Modules\Village\Entities\User', 'village__document_user');
    }

    public function buildings()
    {
        return $this->belongsToMany('Modules\Village\Entities\Building', 'village__document_building');
    }

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id');
    }

    public function category()
    {
        return $this->belongsTo('Modules\Village\Entities\DocumentCategory', 'category_id');
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

    // Try to get description from media file if it is empty
    public function getTextAttribute($value)
    {
        if ($value == '' && $this->files) {
            $file = $this->files()->first();
            if ($file && mb_strlen($file->description) > 0) {
                $value = $file->description;
            }
        }
        return $value;

    }

    protected static function boot()
    {
        parent::boot();
        static::saving(function (Document $document) {
            $document->short = static::generateShort($document->text);
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
        $text    = strip_tags($text);
        $matches = array();
        preg_match_all('/%%(.*?)%%/', $text, $matches);
        if (isset($matches[1])) {
            foreach ($matches[1] as $match) {
                $replaceString = current(explode("^", $match));
                $text          = str_replace('%%' . $match . '%%', $replaceString, $text);
            }
        }
        $text = trim($text);
        return ((mb_strlen($text) <= $limit) ? $text : mb_substr($text, 0, $limit - 3) . '...');
    }
}
