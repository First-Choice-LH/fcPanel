<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientNote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'note', 'added_by'
    ];

    public function userInfo()
	{
		return $this->belongsTo('\App\User', 'added_by');
	}
}
