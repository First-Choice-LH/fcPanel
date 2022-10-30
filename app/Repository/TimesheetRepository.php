<?php

namespace App\Repository;

use App\Repository\BaseRepository as BaseRepository;
use App\Repository\Contract\TimesheetInterface as TimesheetInterface;

use App\Timesheet as Timesheet;

class TimesheetRepository extends BaseRepository implements TimesheetInterface{

	protected $model;

	public function __construct(Timesheet $timesheet)
	{
		$this->model = $timesheet;
	}

	public function getByDate($employee_id=0, $jobsite_id=0, $date=[]){
		return $this->model->where('date',$date)->where('employee_id', $employee_id)->where('jobsite_id', $jobsite_id)->first();
	}

    public function paginateByJobSite($id=0, $limit=15)
    {
        return $this->model->where('jobsite_id',$id)->paginate($limit);
	}

    public function paginateByJobSiteDate($id=0, $date="",$limit=15)
    {
		if(empty($date) && $id > 0){		
			return $this->model->where('jobsite_id',$id)->paginate($limit);
		}else if(empty($date) && $id == 0){
            return $this->model->paginate($limit);
        }
        else if(!empty($date) && $id == 0){
            $date = date("Y-m-d", strtotime($date));        
            return $this->model->where('date',$date)->paginate($limit);
        }
        else{
			$date = date("Y-m-d", strtotime($date));		
			return $this->model->where('jobsite_id',$id)->where('date',$date)->paginate($limit);
		}
	}
	
	public function dump($id=0,$date="")
	{		
		if($id == 0)
		{
			return $this->model->where('date',$date)->get();
		}else{
			if(empty($date))
			{
				return $this->model->where('jobsite_id',$id)->get();
			}else{
				return $this->model->where('jobsite_id',$id)->where('date',$date)->get();
			}
			
		}
	}
    
    public function getPendingTimesheetByEmployeeIds($ids){
       return $this->model->whereIn('employee_id',$ids)->where('status',0)->get();
    }
    public function getTimesheetByEmployeeIds($ids){
       return $this->model->whereIn('employee_id',$ids)->where('status',1)->get();
    }
    public function getJobsiteCompany($id){
        $obj = $this->model->where('employee_id',$id)->orderBy('id','desc')->first();
        if($obj){
            return $obj->jobsite->client->company_name;
        }else{
            return '';
        }
    }
    public function getLastUpdatedJobsite($id){
         $obj = $this->model->where('employee_id',$id)->orderBy('id','desc')->first();
         if($obj){
             return $obj->jobsite->title;
         }else{
             return '';
         }
    }
    public function getLastUpdatedTimesheet($id){
         $obj = $this->model->where('employee_id',$id)->orderBy('id','desc')->first();
         if($obj){
             return $obj->updated_at;
         }else{
             return '';
         }
    }

}