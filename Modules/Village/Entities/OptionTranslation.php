<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class OptionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'village__option_translations';
}
