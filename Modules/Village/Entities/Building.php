<?php namespace Modules\Village\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Profile;

class Building extends Model
{
    // use Translatable;

    protected $table = 'village__buildings';
    public $translatedAttributes = [];
    protected $fillable = ['address', 'code'];


    public function profile()
    {
    	return $this->hasOne('Modules\Village\Entities\Profile');
    }

    /**
     * Get available buildings
     * $id = profile id, if profile has building add to response
     */
    public function getAvailable($id = false)
    {
    	$items = $this->all();

    	$response = [];

    	foreach ($items as $item) {
    	    if ($item->profile()->first() === null) {
    	        $response = array_add($response, $item->id, $item->address);
    	    }
    	}

    	if ($id) {
    		$item = Profile::find($id)->building()->first();
    		$response = array_add($response, $item->id, $item->address);
    	}

    	return $response;
    }
}
