<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Margin extends Model
{
    // use Translatable;
	const TYPE_PERCENT = 'percent';
	const TYPE_CASH = 'percent';

    protected $table = 'village__margins';
    public $translatedAttributes = [];
    protected $fillable = ['type', 'price'];

    public function getTypes() {
    	return [self::TYPE_CASH, self::TYPE_PERCENT];
    }
}
