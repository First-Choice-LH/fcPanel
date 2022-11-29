<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model{

	protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'position_id',
        'phone',
        'email',
        'account_name',
        'account_number',
        'account_bsb',
        'file_number',
        'superannuation',
        'member_number',
        'abn',
        'insurance',
        'status'
   ];

	public function client()
	{
		return $this->belongsTo('\App\Client');
	}

	public function jobsites()
	{
		return $this->belongsToMany('App\Jobsite');
	}

    public function jobs()
	{
		return $this->belongsToMany('App\Job');
	}

	public function timesheets()
	{
		return $this->hasMany('\App\Timesheet');
	}

    public function documents()
	{
		return $this->hasMany('\App\EmployeeLicence', 'emp_id');
	}

    function positions() {
        return $this->hasMany('\App\EmployeePosition');
    }

    function notes() {
        return $this->hasMany('\App\EmployeeNote');
    }
}
