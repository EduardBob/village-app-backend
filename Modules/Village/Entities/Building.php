<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $table = 'village__buildings';
    public $translatedAttributes = [];
    protected $fillable = ['address', 'code'];


	public function __toString()
	{
		return (string)$this->address;
	}

    protected static function boot()
    {
        parent::boot();

        static::creating(function(Building $building) {
            if (!$building->code) {
                $building->code = $building->generateCode();
            }
        });
    }

    /**
     * @param int $length
     *
     * @return string
     */
    static function generateCode($length = 7)
    {
        return substr(md5(rand()), 0, $length);
    }
}
