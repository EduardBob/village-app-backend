<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Scope\VillageAdminScope;

class Building extends Model
{
    use VillageAdminScope;

    protected $table = 'village__buildings';

    protected $fillable = ['village_id', 'address', 'link', 'code'];

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id');
    }

    public function __toString()
    {
        return (string)$this->address;
    }

    /**
     * Get all users array of village_id->role_id->user.
     * @return array
     */
    public function getListWithFacilities()
    {
        $buildings = $this->all(['address', 'village_id', 'id']);
        $list  = [];

        foreach ($buildings as $key => $building) {
            $list[$building->village_id][$building->id] = str_replace('"', '', $building->address);

        }
        return $list;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Building $building) {
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
