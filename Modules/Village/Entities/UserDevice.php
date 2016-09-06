<?php namespace Modules\Village\Entities;


use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Scope\ApiScope;

class UserDevice extends AbstractDevice
{
    use ApiScope;
    protected $table = 'village__user_devices';
    protected $fillable = ['token', 'type'];
    public function user()
    {
        return $this->belongsTo('Modules\SmartHome\Entities\User');
    }
    public function getByToken($token)
    {
        return self::where(['token' => $token])->first();
    }
}
