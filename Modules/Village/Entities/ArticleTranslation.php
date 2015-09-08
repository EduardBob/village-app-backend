<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class ArticleTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'village__article_translations';
}
