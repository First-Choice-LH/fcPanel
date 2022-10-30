<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobsite extends Model{

	protected $fillable = [
        'client_id',
        'title',
        'address',
        'postcode',
        'suburb',
        'state',
        'country',
        'status'
    ];

	public function client()
	{
		return $this->belongsTo('\App\Client');
	}

	public function supervisor()
	{
		return $this->belongsToMany('App\Supervisor');
	}

	public function employee()
	{
		return $this->belongsToMany('App\Employee');
	}

	public function timesheet()
	{
		return $this->hasMany('App\Timesheet');
	}
}