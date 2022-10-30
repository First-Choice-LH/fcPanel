<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $table = 'images';

	protected $fillable = [
		'timesheet_id',
        'imagename'
    ];

	public function timesheets()
	{
		return $this->belongsTo('\App\Timesheet');
	}
}
