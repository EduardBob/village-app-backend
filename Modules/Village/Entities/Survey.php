<?php namespace Modules\Village\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use Translatable;

    protected $table = 'village__surveys';
    public $translatedAttributes = [];
    protected $fillable = [];
}
