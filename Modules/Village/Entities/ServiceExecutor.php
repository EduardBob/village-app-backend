<?php namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceExecutor extends Model
{
    protected $table = 'village__service_executors';

    protected $fillable = [
        'service_id', 'user_id'
    ];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
    	return $this->belongsTo('Modules\Village\Entities\Service', 'service_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Modules\Village\Entities\User', 'user_id');
    }
}
