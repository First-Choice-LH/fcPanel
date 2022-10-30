<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model{

	protected $fillable = [
        'user_id',
        'company_name',
        'company_abn',
		'office_address',
		'state',
		'suburb',
		'country',
		'postcode',
        'office_phone',
        'email',
        'status'
	];

	public function jobsites()
	{
		return $this->hasMany('\App\Jobsite');
	}

	public function supervisor()
	{
		return $this->hasMany('\App\Supervisor');
	}

	public function employees()
	{
		return $this->hasMany('\App\Employee');
	}

}