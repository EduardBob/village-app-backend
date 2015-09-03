<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'village__serviceorder_translations';
}
