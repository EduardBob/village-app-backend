<?php namespace Modules\Village\Entities;

use Crypt;
use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Scope\ApiScope;

class SmartHome extends Model
{

    use ApiScope;
    protected $table = 'village__smarthouses';
    protected $fillable = ['name', 'api', 'password'];

    public function smartHome()
    {
        return $this->belongsTo('Modules\SmartHome\Entities\User');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Crypt::encrypt($value);
    }

    public function getPasswordAttribute($value)
    {
        return Crypt::decrypt($value);
    }
}
