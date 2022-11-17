<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'client_id',
        'jobsite_id',
        'supervisor_id',
        'position_id',
        'employee_id',
        'assigned_by',
        'last_updated_by',
        'start_time',
        'end_time',
        'comments',
        'status'
   ];

    public function client()
	{
		return $this->hasOne('App\Client', 'id', 'client_id');
	}

	public function jobSite()
	{
		return $this->hasOne('App\Jobsite', 'id', 'jobsite_id');
	}

    public function position()
	{
		return $this->hasOne('App\Position', 'id', 'position_id');
	}

    public function supervisor()
	{
		return $this->hasOne('App\Supervisor', 'id', 'supervisor_id');
	}

    public function employee()
	{
		return $this->hasOne('App\Employee', 'id', 'employee_id');
	}

    public function allocator()
	{
		return $this->hasOne('App\User', 'id', 'assigned_by');
	}

    public function updater()
	{
		return $this->hasOne('App\User', 'id', 'last_updated_by');
	}
}
