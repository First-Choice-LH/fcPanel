<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model{

	protected $fillable = [
        'employee_id',
        'jobsite_id',
        'date',
        'start',
        'end',
        'break',
        'status'
    ];

	public function employee()
	{
		return $this->belongsTo('\App\Employee');
	}

	public function jobsite()
	{
		return $this->belongsTo('\App\Jobsite');
	}

	public function images()
	{
		return $this->hasMany('\App\Image');
	}
}