<?php namespace Modules\Village\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Translatable;

    protected $table = 'village__users';
    public $translatedAttributes = [];
    protected $fillable = [];
}
