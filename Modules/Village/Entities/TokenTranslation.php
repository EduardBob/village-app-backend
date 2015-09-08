<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class TokenTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'village__token_translations';
}
