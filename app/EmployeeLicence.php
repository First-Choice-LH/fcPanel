<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeLicence extends Model{

    Protected $table = 'employee_licence';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'emp_id', 'license_type', 'other_type', 'license_date', 'license_number', 'license_image_front', 'license_image_back'
    ];

}
