<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeePosition extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'position_id'
    ];

    public function position()
	{
		return $this->belongsTo('\App\Position');
	}
}
