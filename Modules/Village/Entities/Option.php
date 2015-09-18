<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'village__options';
    public $translatedAttributes = [];
    protected $fillable = ['key', 'value'];
}
