<?php namespace Modules\Village\Entities;

use Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Village\Entities\Scope\ApiScope;


class SmartHome extends Model
{

    use SoftDeletes;
    use ApiScope;
    protected $table = 'village__smart_houses';
    protected $fillable = ['name', 'api', 'password', 'user_id'];
    protected $dates = ['deleted_at'];


    public function smartHome()
    {
        return $this->belongsTo('Modules\SmartHome\Entities\User', 'smarthouse_id');
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
            return $e->getMessage();
        }
    }

}
