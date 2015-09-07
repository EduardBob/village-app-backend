<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    // use Translatable;

    protected $table = 'village__tokens';
    public $translatedAttributes = [];
    protected $fillable = ['code', 'phone', 'type'];
}
