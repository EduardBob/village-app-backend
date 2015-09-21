<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    const TYPE_REGISTRATION = 'registration';
    const TYPE_CHANGE_PHONE = 'change_phone';
    const TYPE_RESET_PASSWORD = 'reset_password';

    protected $table = 'village__tokens';

    protected $fillable = ['type', 'session', 'phone', 'code', 'new_phone'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function(Token $token) {
            $token->session = str_random(config('village.token.session.length'));
            $token->code = rand(config('village.token.code.min'), config('village.token.code.max'));
        });

        static::saving(function(Token $token) {
            if (self::TYPE_CHANGE_PHONE !== $token->type) {
                $token->new_phone = null;
            }
        });
    }

    /**
     * @return array
     */
    static public function getTypes()
    {
    	return [self::TYPE_REGISTRATION, self::TYPE_CHANGE_PHONE, self::TYPE_RESET_PASSWORD];
    }

    /**
     * @param string $type
     * @param string $session
     * @param int    $code
     *
     * @return mixed
     */
    static public function findOneByTypeAndSessionAndCode($type, $session, $code)
    {
        return static::where(compact('type', 'session', 'code'))->first();
    }


    /**
     * @param string $type
     * @param string $session
     * @param int    $code
     * @param string $phone
     *
     * @return mixed
     */
    static public function _findOneByTypeAndSessionAndCodeAndPhone($type, $session, $code, $phone)
    {
        return static::where(compact('type', 'session', 'code', 'phone'))->first();
    }
}
