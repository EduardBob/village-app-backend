<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    // use Translatable;

    protected $table = 'village__options';
    public $translatedAttributes = [];
    protected $fillable = ['key', 'value'];
}
