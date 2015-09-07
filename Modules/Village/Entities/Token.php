<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    // use Translatable;
	const TYPE_RESTORE = 'restore';
	const TYPE_RESET = 'reset';
	const TYPE_CREATE = 'create';

    protected $table = 'village__tokens';
    public $translatedAttributes = [];
    protected $fillable = ['code', 'phone', 'type'];

    public function getTypes() {
    	return [self::TYPE_RESTORE, self::TYPE_RESET, self::TYPE_CREATE];
    }
}
