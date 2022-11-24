<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPositionRate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'position_id', 'rate'
    ];

    public function position()
	{
		return $this->belongsTo('\App\Position');
	}
}
