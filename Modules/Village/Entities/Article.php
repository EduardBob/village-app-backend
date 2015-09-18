<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'village__articles';
    public $translatedAttributes = [];
    protected $fillable = ['title', 'text', 'short'];
}
