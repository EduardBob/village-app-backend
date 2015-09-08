<?php namespace Modules\Village\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Margin extends Model
{
    use Translatable;

    protected $table = 'village__margins';
    public $translatedAttributes = [];
    protected $fillable = [];
}
