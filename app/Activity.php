<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model{

	Protected $table = 'activity';

	public function user()
	{
		return $this->belongsTo('\App\User');
	}

}