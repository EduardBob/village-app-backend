<?php namespace Modules\Village\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use Translatable;

    protected $table = 'village__productorders';
    public $translatedAttributes = [];
    protected $fillable = [];

    public function product()
    {
    	return $this->belongsTo('Modules\Village\Entities\Product');
    }

    public function user()
    {
    	return $this->belongsTo('Modules\Village\Entities\User');
    }
}
