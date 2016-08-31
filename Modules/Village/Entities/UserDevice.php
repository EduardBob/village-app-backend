<?php namespace Modules\Village\Entities;


use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Scope\ApiScope;

class UserDevice extends Model
{

    use ApiScope;
    protected $table = 'village__user_devices';
    protected $fillable = ['token', 'type'];
    const DEVICE_TYPES = 'ios,gcm';
    public function devices()
    {
        return $this->belongsTo('Modules\SmartHome\Entities\User');
    }

    public function getByToken($token)
    {
        return self::where(['token' => $token])->first();
    }
}
