<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model{

	protected $fillable = [
        'title',
        'description',
        'status'
    ];

	public function employee()
	{
		return $this->belongsTo('\App\Employee');
	}
}