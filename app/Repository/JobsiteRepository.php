<?php

namespace App\Repository;

use App\Repository\BaseRepository as BaseRepository;
use App\Repository\Contract\JobsiteInterface as JobsiteInterface;

use App\Jobsite as Jobsite;

class JobsiteRepository extends BaseRepository implements JobsiteInterface{

	protected $model;

	public function __construct(Jobsite $jobsite)
	{
		$this->model = $jobsite;
	}

	public function dropdown(){
		return $this->model->where('status',1)->get();
	}

	public function unassignJobsite($id)
	{
		return $this->model->destroy($id);
	}

	public function byClientId($id)
	{
		return $this->model->select('id','title','status')->where('client_id',$id)->where('status',true)->get();
	}

}