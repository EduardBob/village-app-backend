<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class ProfileTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'village__profile_translations';
}
