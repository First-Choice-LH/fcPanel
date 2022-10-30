<?php

namespace App\Repository;

use App\Repository\BaseRepository as BaseRepository;
use App\Repository\Contract\PositionInterface as PositionInterface;

use App\Position as Position;

class PositionRepository extends BaseRepository implements PositionInterface{

	protected $model;

	public function __construct(Position $position)
	{
		$this->model = $position;
	}

	public function dropdown(){
		return $this->model->where('status',1)->get()->keyBy('id');
	}
}