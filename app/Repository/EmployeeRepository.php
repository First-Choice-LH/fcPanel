<?php

namespace App\Repository;

use App\Repository\BaseRepository as BaseRepository;
use App\Repository\Contract\EmployeeInterface as EmployeeInterface;

use App\Employee as Employee;

class EmployeeRepository extends BaseRepository implements EmployeeInterface{

	protected $model;

	public function __construct(Employee $employee)
	{
		$this->model = $employee;
	}

    public function paginate($limit=15,$q="")
    {
		if(empty($q))
		{
			return $this->model->paginate($limit);
		}else{
			return $this->model->where('first_name','LIKE','%'.$q.'%')
			->orWhere('last_name','LIKE','%'.$q.'%')
			->orWhere('phone','LIKE','%'.$q.'%')
			->orWhere('email','LIKE','%'.$q.'%')
			->paginate($limit);
		}
    }

	public function getEmployeeId($id)
	{
		return $this->model->where('user_id',$id)->first();
	}

	public function paginateByEmployee($id)
	{
		return $this->model->findOrFail($id)->jobsites()->paginate();
	}

	public function attach($employee_id, $jobsite_id)
	{
		$check = $this->model->find($employee_id)->jobsites()->where('employee_id',$employee_id)->where('jobsite_id',$jobsite_id)->count();
		
		if($check == 0){			
			return $this->model->find($employee_id)->jobsites()->attach([$jobsite_id]);
		}else{
			return true;
		}
	}

	public function detach($employee_id, $jobsite_id)
	{
		return $this->model->find($employee_id)->jobsites()->detach([$jobsite_id]);
	}

}