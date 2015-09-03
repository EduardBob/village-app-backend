<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class UserTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'village__user_translations';
}
