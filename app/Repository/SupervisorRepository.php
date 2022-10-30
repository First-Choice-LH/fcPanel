<?php

namespace App\Repository;

use App\Repository\BaseRepository as BaseRepository;
use App\Repository\Contract\SupervisorInterface as SupervisorInterface;

use App\Supervisor as Supervisor;

class SupervisorRepository extends BaseRepository implements SupervisorInterface{

	protected $model;

	public function __construct(Supervisor $supervisor)
	{
		$this->model = $supervisor;
    }

	public function getSupervisorId($id)
	{
		return $this->model->where('user_id',$id)->first();
	}

	public function paginateBySupervisor($id)
	{
		return $this->model->findOrFail($id)->jobsites()->paginate();
    }
    
    public function dropdownJobsite($id=0)
    {
		return $this->model->find($id)->client->jobsites()->get();
    }

	public function attach($supervisor_id, $jobsite_id)
	{
		$check = $this->model->find($supervisor_id)->jobsites()->where('supervisor_id',$supervisor_id)->where('jobsite_id',$jobsite_id)->count();

		if($check == 0)
		{
			return $this->model->find($supervisor_id)->jobsites()->attach([$jobsite_id]);
		}else{
			return true;
		}
	}

	public function detach($supervisor_id, $jobsite_id)
	{
		return $this->model->find($supervisor_id)->jobsites()->detach([$jobsite_id]);
    }
    
    public function getEmployeeByJobsite($id,$jobsite_id)
    {
    	$result = $this->model->find($id);

    	if($result->jobsites != null){
    		return $result->jobsites->find($jobsite_id)->employee()->paginate();
    	}else{
    		return [];
    	}
    }
}