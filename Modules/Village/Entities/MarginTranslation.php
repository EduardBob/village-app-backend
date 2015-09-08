<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class MarginTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'village__margin_translations';
}
