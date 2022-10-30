<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestJobsite extends Model
{
    protected $table = 'request_jobsite';

    public function client()
	{
		return $this->belongsTo('\App\Client');
	}

	public function jobsite()
	{
		return $this->belongsTo('\App\Jobsite');
	}

	public function position()
	{
		return $this->belongsTo('\App\Position');
	}
	public function user()
	{
		return $this->belongsTo('\App\User');
	}

}
