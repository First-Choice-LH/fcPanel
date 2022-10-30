<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model{

	protected $fillable = [
        'user_id',
        'client_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'status'
    ];

	public function client()
	{
		return $this->belongsTo('App\Client');
	}

	public function jobsites()
	{
		return $this->belongsToMany('App\Jobsite');
	}

}