<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\Contract\TimesheetInterface as TimesheetInterface;
use App\Repository\Contract\EmployeeInterface as EmployeeInterface;
use App\Repository\Contract\JobsiteInterface as JobsiteInterface;
use App\Http\Requests\TimesheetRequest as TimesheetRequest;
use App\Repository\Contract\ClientInterface as ClientInterface;
use Response;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Employee;
use App\Timesheet;
use DB;


class TimesheetController extends Controller
{
    //
	private $request;
	private $timesheet;
	private $employee;
    private $jobsite;
    private $client;

    public function __construct(Request $request, TimesheetInterface $timesheet, EmployeeInterface $employee, JobsiteInterface $jobsite, ClientInterface $client)
    {
    	$this->request = $request;
    	$this->timesheet = $timesheet;
    	$this->employee = $employee;
    	$this->jobsite = $jobsite;
        $this->client = $client;
    }

    /*public function index()
    {
        $jobsite_id = $this->request->input('id');
        $date = $this->request->input('date');

        $data = [];
        $data['clients'] = $this->client->dropdown();
        if($jobsite_id > 0){
            $data['jobsites'] = $this->jobsite->dropdown();
        }

        $data['rows'] = $this->timesheet->paginateByJobSiteDate($jobsite_id, $date, 10);

        return view('timesheets.list', $data);
    }*/
    public function index(Request $request){
        $search = isset($request['employee']) ? $request['employee'] : '';
        if($search != ''){
           $employee = Employee::where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%')->pluck('id')->toArray();

        }
        
        $final = [];
        $employee_ids = Timesheet::where('status',1)->pluck('employee_id')->toArray();

        if(isset($employee)){
          $employee_ids = array_intersect($employee, $employee_ids);
        }
        if(isset($request['orderby']) && isset($request['sortby'])){
            $employee['final'] = DB::table('employees')
                        ->join('employee_jobsite', 'employees.id', '=', 'employee_jobsite.employee_id')
                        ->join('jobsites', 'employee_jobsite.jobsite_id', '=', 'jobsites.id')
                        ->join('clients', 'jobsites.client_id', '=', 'clients.id')
                        ->select('employees.*', 'jobsites.title' ,'clients.company_name' ,'jobsites.id as jobsite_id')
                        ->whereIn('employees.id',$employee_ids)
                        ->orderBy($request['orderby'],$request['sortby'])
                        ->paginate(15);
        }else{
            $employee['final'] = DB::table('employees')
                        ->join('employee_jobsite', 'employees.id', '=', 'employee_jobsite.employee_id')
                        ->join('jobsites', 'employee_jobsite.jobsite_id', '=', 'jobsites.id')
                        ->join('clients', 'jobsites.client_id', '=', 'clients.id')
                        ->select('employees.*', 'jobsites.title' ,'clients.company_name' ,'jobsites.id as jobsite_id')
                        ->whereIn('employees.id',$employee_ids)
                        ->paginate(15);
        }

      

       return view('timesheets.list', $employee);
   }

   public function getTimesheet(Request $request){
       $emp_id = $request->emp_id;
       $date = $request->last_updated_jobsite_date;
       $temp = [];

        if(isset($request['orderby']) && isset($request['sortby'])){
            $timesheet = Timesheet::where('employee_id',$emp_id)->where('jobsite_id',$request->jobsite_id)->orderBy($request['orderby'], $request['sortby'])->paginate(15);
        }else{
            $timesheet = Timesheet::where('employee_id',$emp_id)->where('jobsite_id',$request->jobsite_id)->paginate(15);
        }

       //$timesheet = $this->timesheet->sortable($request)->getByEmployee($emp_id)->paginate();
     
       return view('timesheets.emptimesheet',array('final'=>$timesheet));
   }

    public function employee($jobsite_id=0, $employee_id=0)
    {
        $data = [];

        $data['jobsite_id'] = $jobsite_id;
        $data['employee_id'] = $employee_id;

        $date = $this->request->get('date');
        
        if(!empty($date)){
            $dayStart = new \DateTime($date);
            
            if($dayStart->format("D") != "Mon"){               
                $dayStart->modify("previous monday");
            }
        }else{
            $dayStart = new \DateTime("last monday");
        }

        $baseDate = $dayStart->format("Y-m-d");
        $previousWeek = new \DateTime($baseDate);
        $previousWeek->modify("previous monday");
        $nextWeek = new \DateTime($baseDate);
        $nextWeek->modify("next monday");

        $data['previousWeek'] = url('/timesheets/employee/'.$jobsite_id.'/'.$employee_id.'/?date='.$previousWeek->format("Y-m-d"));
        $data['nextWeek'] = url('/timesheets/employee/'.$jobsite_id.'/'.$employee_id.'/?date='.$nextWeek->format("Y-m-d"));

        $data['jobsite'] = $this->jobsite->show($jobsite_id);
        $data['employee'] = $this->employee->show($employee_id);
        $data['week'] = [];
        $day = 0;
        
        while($day < 7){
            $tempDay = new \DateTime($dayStart->format("Y-m-d"));
            $tempDay->modify("+".$day." day");
            
            $data['week'][] = $tempDay;
            $data['rows'][] = $this->timesheet->getByDate($employee_id, $jobsite_id, $tempDay);
            $day++;
        }

        $time = [];
        $start_hour = 0;
        $end_hour = 24;

        $data['default_start'] = '07:00:00';
        $data['default_end'] = '15:30:00';

        for($i=$start_hour;$i<=$end_hour;$i++)
        {
            if($i != $end_hour){
                // hour
                if($i > 12){
                    $temp_hour = str_pad($i-12, 2, '0', STR_PAD_LEFT);
                }else{
                    $temp_hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                }
            }

            for($j=0;$j<60;$j+=15){
                
                $temp_min =  str_pad($j, 2, '0', STR_PAD_LEFT);

                if($i != $end_hour && $j <= 30)
                {
                    if($i < 12)
                    {
                        $temp_suffix = 'AM';
                    }else{
                        $temp_suffix = 'PM';
                    }
                    
                    $time[]['key'] = $temp_hour.':'.$temp_min.' '.$temp_suffix;
                    $time[count($time)-1]['value'] = str_pad($i, 2, '0', STR_PAD_LEFT).':'.$temp_min.':00';
                }
            }
        }

        $data['times'] = $time;

        return view('timesheets.employee', $data);
    }

    public function create(Request $request)
    {
        $employee_id = 1;
        $jobsite_id = $request->get('jobsite_id');
        $date = $request->get('date');
        
        if(!empty($date)){
            $dayStart = new \DateTime($date);
            
            if($dayStart->format("D") != "Mon"){               
                $dayStart->modify("previous monday");
            }
        }else{
            $dayStart = new \DateTime("last monday");
        }

        $data = [];
        $data['jobsite_id'] = $jobsite_id;
        $data['employee_id'] = $employee_id;
        $data['jobsite'] = $this->jobsite->show($jobsite_id);
        $data['employee'] = $this->employee->show($employee_id);
        $data['week'] = [];
        $day = 0;
        
        while($day < 7){
            $tempDay = new \DateTime($dayStart->format("Y-m-d"));
            $tempDay->modify("+".$day." day");
            
            $data['week'][] = $tempDay;
            $data['rows'][] = $this->timesheet->getByDate($employee_id, $jobsite_id, $tempDay);
            $day++;
        }

        return view('timesheets.create', $data);
    }

    public function save(TimesheetRequest $request)
    {
        $employee_id = $request->input('employee_id');
        $jobsite_id = $request->input('jobsite_id');
        
        $ids = $request->input('id');
        $dates = $request->input('date');
        $starts = $request->input('start');
        $ends = $request->input('end');
        $status = $request->input('status');
        
        for($i=0; $i< sizeof($ids); $i++)
        {
            $row = [];
            $id = $ids[$i];
            $row['date'] = $dates[$i];
            $row['employee_id'] = intval($employee_id);
            $row['jobsite_id'] = intval($jobsite_id);
            $start = new \DateTime($dates[$i].' '.$starts[$i]);
            $row['start'] = $start->format("Y-m-d H:i:s");
            $end = new \DateTime($dates[$i].' '.$ends[$i]);
            $row['end'] = $end->format("Y-m-d H:i:s");
            $row['status'] = (bool) $status[$i];
            //dd($row);

            if($id == null)
            {
                $this->timesheet->create($row);
            }else{
                $this->timesheet->update($row,$id);
            }
        }
        
        return redirect('/timesheets/employee/'.$jobsite_id[0]);
    }

    public function dump($id=0,$date=""){

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $timesheets = $this->timesheet->dump($id,$date);
        
        $columns = array('Id', 'Employee', 'JobSite', 'Date', 'Start', 'End', 'Break', 'Status');
                
        $callback = function() use ($timesheets, $columns)
        {
            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);
    
            foreach($timesheets as $timesheet) {
                $fields = array($timesheet->id, $timesheet->employee->first_name.' '.$timesheet->employee->last_name, $timesheet->jobsite->title, date("d/m/Y", strtotime($timesheet->date)), date("H:i A", strtotime($timesheet->start)), date("H:i A", strtotime($timesheet->end)), $timesheet->break, $timesheet->status);
                fputcsv($file, $fields);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
