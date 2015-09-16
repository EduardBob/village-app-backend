<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Margin extends Model
{
    // use Translatable;
	const TYPE_PERCENT = 'percent';
	const TYPE_CASH = 'cash';

    protected $table = 'village__margins';
    public $translatedAttributes = [];
    protected $fillable = ['type', 'value', 'title'];

    public function getTypes() 
    {
    	return [self::TYPE_CASH, self::TYPE_PERCENT];
    }

    public function getTypeId($formType)
    {
    	$types = $this->getTypes();

    	foreach ($types as $key => $type) {
    		if ($formType === $type)
    		{
    			return $key;
    		}
    	}
    }
}
