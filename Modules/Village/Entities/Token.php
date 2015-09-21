<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
	const TYPE_RESTORE = 'restore';
	const TYPE_RESET = 'reset';
	const TYPE_CREATE = 'create';

    protected $table = 'village__tokens';

    protected $fillable = ['code', 'phone', 'type'];

    /**
     * @return array
     */
    public function getTypes()
    {
    	return [self::TYPE_RESTORE, self::TYPE_RESET, self::TYPE_CREATE];
    }
}
