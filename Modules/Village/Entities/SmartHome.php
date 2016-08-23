<?php namespace Modules\Village\Entities;

use Crypt;
use Illuminate\Database\Eloquent\Model;
use Log;
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
        try {
            return Crypt::decrypt($value);
        } catch (DecryptException $e) {
            Log::critical('Getting user password exception: ' . $e->getMessage());
            die('FATAL ERROR: '.$e->getMessage());
        }
    }

}
