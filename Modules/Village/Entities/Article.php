<?php namespace Modules\Village\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Translatable;

    protected $table = 'village__articles';
    public $translatedAttributes = [];
    protected $fillable = [];
}
