<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'village__service_translations';
}
