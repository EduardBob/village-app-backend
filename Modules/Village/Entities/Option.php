<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'village__options';

    protected $fillable = ['key', 'value'];
}
