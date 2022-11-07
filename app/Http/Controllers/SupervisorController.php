<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use PDF;
use Jenssegers\Agent\Agent;
use App\Activity;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\RequestJobsite;
use App\Supervisor;
use App\Timesheet;
use App\Employee;
use App\Jobsite;
use App\EmployeeJobsite;
use DB;
use carbon\carbon;

use App\Repository\Contract\UserInterface as UserInterface;
use App\Repository\Contract\EmployeeInterface as EmployeeInterface;
use App\Repository\Contract\SupervisorInterface as SupervisorInterface;
use App\Repository\Contract\ClientInterface as ClientInterface;
use App\Repository\Contract\JobsiteInterface as JobsiteInterface;
use App\Repository\Contract\TimesheetInterface as TimesheetInterface;
use App\Repository\Contract\PositionInterface as PositionInterface;
use App\Repository\Contract\ImageInterface as ImageInterface;

use App\Http\Requests\SupervisorRequest as SupervisorRequest;

class SupervisorController extends Controller
{
    //
    private $user;
    private $supervisor;
    private $employee;
    private $client;
    private $jobsite;
    private $timesheet;
    private $position;
    private $request;

    public function __construct(Request $request, EmployeeInterface $employee, SupervisorInterface $supervisor, ClientInterface $client,
        JobsiteInterface $jobsite, TimesheetInterface $timesheet, PositionInterface $position, UserInterface $user, ImageInterface $image)
    {
        $this->request = $request;
        $this->user = $user;
        $this->supervisor = $supervisor;
        $this->employee = $employee;
        $this->client = $client;
        $this->jobsite = $jobsite;
        $this->position = $position;
        $this->image = $image;
        $this->timesheet = $timesheet;
    }

    public function dashboard(){

        $id =Auth::id();
        $supervisor_tms = Supervisor::Where('user_id',$id)->first();
        $supervisor_id = $supervisor_tms->id;
        $jobsites = Supervisor::findOrFail($supervisor_id)->jobsites()->get();
        $jobsites_ids = $jobsites->pluck('id')->toArray();
        $employee_ids =  EmployeeJobsite::whereIn('jobsite_id',$jobsites_ids)->pluck('employee_id')->toArray();
        $activity['rows'] = Activity::where('user_id',$supervisor_tms->user_id)->orWhereIn('jobsite_id',$jobsites_ids)->orWhere('supervisor_id',$supervisor_id)->orderBy('id','desc')->paginate(15);

        return view('supervisors.activity',$activity);
    }

    public function activity($client_id=0, $jobsite_id=0){

        $id =Auth::id();
        $supervisor_tms = Supervisor::Where('user_id',$id)->first();
        $supervisor_id = $supervisor_tms->id;
        $jobsites = Supervisor::findOrFail($supervisor_id)->jobsites()->get();
        $jobsites_ids = $jobsites->pluck('id')->toArray();
        $employee_ids =  EmployeeJobsite::whereIn('jobsite_id',$jobsites_ids)->pluck('employee_id')->toArray();
        $ids = Employee::whereIn('id',$employee_ids)->pluck('user_id')->toArray();
        $acts = Activity::whereIn('user_id',$ids)->orderBy('id','desc')->paginate(15);
        return view('dashboard.activity',array('user'=>$acts));
    }

    public function index(Request $request){

        if(isset($request['orderby']) && isset($request['sortby'])){

           $data['rows'] = Supervisor::orderBy($request['orderby'], $request['sortby'])->paginate(15);
        }
        else{
           $data['rows'] = Supervisor::paginate(15);
        }
       return view('supervisors.list', $data);
    }

    public function create(){

        $data = array();
        $data['clients'] = $this->client->dropdown();
        return view('supervisors.create', $data);
    }

    public function update($id){

        $data = [];
        $data['clients'] = $this->client->dropdown();
        $data['row'] = $this->supervisor->show($id);
        return view('supervisors.create', $data);
    }

    public function save(SupervisorRequest $request){

        $id = $request->input('id');
        $jobsite_id = $request->input('jobsite_id');

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:supervisors'. ($id ? (',email,'.$id) : ''),
            'client_id' => 'required'
        ]);

        if ($validator->fails()) {
           return redirect()->back()->withErrors($validator)->withInput();
        }

        $fields = [
            'first_name',
            'last_name',
            'phone',
            'email',
            'client_id',
            'status'
        ];

        $supervisor_row = $request->only($fields);

        if($id == null){
            $new_supervisor = $this->supervisor->create($supervisor_row);
            $this->supervisor->attach($new_supervisor->id, $jobsite_id);
            $message = "created by Admin";
            $type = SUP_PROFILE;
            $supervisorid = $id;
            activity(Auth::id(),$message,$type,NULL,$supervisorid,NULL,NULL);
        }
        else{
            unset($supervisor_row['user_id']);
            $this->supervisor->update($supervisor_row, $id);
            $supervisorid = $id;
            $type = SUP_PRO_ADM;
            $message = "updated by admin";
            activity(Auth::id(),$message,$type,NULL,$supervisorid,NULL,NULL);
        }
        return redirect('/supervisors/');
    }

    public function jobsite($id){

        $supervisor_id = $id;
        $data = [];
        $data['supervisor_id'] = $supervisor_id;
        $data['rows'] = $this->supervisor->paginateBySupervisor($supervisor_id);
        return view('supervisors.jobsite', $data);
    }

    public function jobsites(Request $request){

        $supervisor = $this->supervisor->getSupervisorId(Auth::id());
        $supervisor_id = $supervisor->id;
        $data = [];
        $final = [];
        $data['supervisor_id'] = $supervisor_id;
        $jobsites = Supervisor::findOrFail($supervisor_id)->jobsites()->get();
       foreach ($jobsites as $key => $value) {
          $temp = [];
          $temp['id'] = $value->id;
          $temp['title'] = $value->title;
          $temp['company_name'] = $value->client->company_name;
          $temp['client_id'] = $value->client_id;
          $final[] = $temp;
      }
        $data['rows'] = sortArray($final, $request);
        return view('supervisors.jobsites', $data);
    }

    public function employees($client_id=0, $jobsite_id=0,Request $request)
    {
        $supervisor = $this->supervisor->getSupervisorId(Auth::id());
        $supervisor_id = $supervisor->id;
        $final = [];
        $data = [];
        $data['jobsite_id'] = $jobsite_id;
        $data['client_id'] = $client_id;
        $data['supervisor_id'] = $supervisor_id;
        $employee_ids = EmployeeJobsite::where('jobsite_id',$data['jobsite_id'])->pluck('employee_id')->toArray();

        if(isset($request['orderby']) && isset($request['sortby'])){
            $data['employees'] =  Employee::whereIn('id',$employee_ids)->orderBy($request['orderby'], $request['sortby'])->paginate(15);
        }else{
            $data['employees'] =  Employee::whereIn('id',$employee_ids)->paginate(15);
        }
       return view('supervisors.employees', $data);
    }

    public function timesheet($client_id=0, $jobsite_id=0, $employee_id=0)
   {
       //$supervisor = $this->supervisor->getSupervisorId(Auth::id());
       //$supervisor_id = $supervisor->id;
       $data = [];

       $data['client_id'] = $client_id;
       $data['jobsite_id'] = $jobsite_id;
       $data['employee_id'] = $employee_id;
       $employee = EmployeeJobsite::where('employee_id',$data['employee_id'])->pluck('jobsite_id')->toArray();

       $data['job'] = Jobsite::whereIn('id',$employee)->get()->toArray();
       $date = $this->request->get('date');
       //dd($date);
       if(!empty($date)){
           $dayStart = new \DateTime($date);
           if($dayStart->format("D") != "Mon"){
               $dayStart->modify("previous monday");
           }
       }else{
           $dayStart = new \DateTime("monday");
       }

       $baseDate = $dayStart->format("Y-m-d");
       $previousWeek = new \DateTime($baseDate);
       $previousWeek->modify("previous monday");
       $nextWeek = new \DateTime($baseDate);
       $nextWeek->modify("next monday");

       $data['previousWeek'] = url('/employee/jobsites/timesheet/'.$client_id.'/'.$jobsite_id.'/'.$employee_id.'/?date='.$previousWeek->format("Y-m-d"));
       $data['nextWeek'] = url('/employee/jobsites/timesheet/'.$client_id.'/'.$jobsite_id.'/'.$employee_id.'/?date='.$nextWeek->format("Y-m-d"));

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
       $start_hour = 7;
       $end_hour = 16;
       $data['start'] =  $start_hour.":00:00";
       $data['end'] =  $end_hour.":00:00";

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
       if(!empty($data['rows'][6]->images)){
           $data['images'] = $data['rows'][6]->images()->get();
       }else{
           $data['images'] = [];
       }

       $latest = $this->request->get('latest');
       if($latest == 1){
           $data['is_mobile'] = false;
           return view('employees.etimesheet', $data);
       }else{
           $agent = new Agent();

           if($agent->isMobile()){
               $data['is_mobile'] = true;
               return view('supervisors.etimesheet', $data);
           }else{
               $data['is_mobile'] = false;
                return view('supervisors.etimesheet', $data);
           }
       }


       //return view('supervisors.timesheet', $data);
   }


    public function timesheet_save()
   {
       $export_pdf = $this->request->input('export_pdf');
       $download_mode = $this->request->input('download_mode');

       $employee_id = $this->request->input('employee_id');
       $client_id = $this->request->input('client_id');
       $jobsite_id = $this->request->input('jobsite_id');

       $supervisor_id = Supervisor::where('user_id',Auth::id())->value('id');

       $ids = $this->request->input('id');
       $dates = $this->request->input('date');
       $starts = $this->request->input('start');
       $ends = $this->request->input('end');
       $break = $this->request->input('break');
       $status = $this->request->input('status');

       for($i=0; $i < sizeof($ids); $i++)
       {
           // if date is empty don't proceed
           if(empty($starts[$i]) || empty($ends[$i])) continue;

           $row = [];
           $id = $ids[$i];
           $row['date'] = $dates[$i];
           $row['employee_id'] = intval($employee_id);
           $row['jobsite_id'] = intval($jobsite_id);
           $start = new \DateTime($dates[$i]);
           $start->modify($starts[$i]);
           $row['start'] = $start->format("Y-m-d H:i:s");
           $end = new \DateTime($dates[$i]);
           $end->modify($ends[$i]);
           $row['end'] = $end->format("Y-m-d H:i:s");
           $row['break'] = $break[$i];
           $row['status'] = $status[$i];

           if($id == null)
           {
                $id = $this->timesheet->create($row);
                $userid = Auth::id();
                $message = "aproved timesheet for ".$row['start'];
                $type = EMP_TIME_APR;
                activity($userid,$message,$type,$employee_id,$supervisor_id ,$jobsite_id,NULL);
           }else{
               $this->timesheet->update($row,$id);
                $userid = Auth::id();
                $employee = Employee::where('id',$employee_id)->first();
                $message = "aproved updated timesheet for ".$row['start'];
                $type = EMP_TIME_APR;
                activity($userid,$message,$type,$employee_id,$supervisor_id ,$jobsite_id,NULL);
           }

           // store images against last days entry
           if($i == 6 && !is_null($this->request->timesheetfile)){
               $filename = $this->request->timesheetfile->store('public');

               if(isset($filename)){
                   if(is_object($id))
                   {
                       $timesheet_id = $id->id;
                   }else{
                       $timesheet_id = $id;
                   }
                   $this->image->create(['timesheet_id' => $timesheet_id, 'imagename' => $filename]);
               }
           }
       }

       if($export_pdf == 1)
       {
           for($i=0; $i< sizeof($ids); $i++)
           {
               $tempDay = new \DateTime($dates[$i]);
               $rows[] = $this->timesheet->getByDate($employee_id, $jobsite_id, $tempDay);
           }

           $columns = ['Date', 'Start Time', 'End Time', 'Break', 'Status'];

           $content = implode(',',$columns)."\r\n";

           $frows = array();

           foreach($rows as $row) {
               $row_date = Date('d/m/Y', strtotime($row->date));
               $row_start = Date('H:i:s', strtotime($row->start));
               $row_end = Date('H:i:s', strtotime($row->end));
               $row_break = $row->break.' min(s)';

               $row_status = ($row->status == 1) ? 'Approved' : 'Unapproved';

               $frows[] = [$row_date, $row_start, $row_end, $row_break, $row_status];

               $content .= implode(',',[$row_date, $row_start, $row_end, $row_break, $row_status])."\r\n";
           }

           if($download_mode == 'pdf'){
               view()->share('rows', $frows);

               PDF::setOptions(['dpi' => 150, 'orientation' => 'landscape', 'defaultFont' => 'sans-serif']);

               $pdf = PDF::loadView('pdf');

               return $pdf->download('timesheet.pdf');
           }

           Storage::disk('local')->put('timesheet.csv', $content);

           return Storage::download('timesheet.csv');
       }
       return back();
   }

    public function assign($id=0)
    {
        $data = [];
        $data['supervisor_id'] = $id;

        //$data['jobsites'] = $this->supervisor->dropdownJobsite($id);
        $client_id = Supervisor::where('id',$id)->value('client_id');
        $data['jobsites'] = $this->jobsite->byClientId($client_id);

        return view('supervisors.assign', $data);
    }

    public function assign_save(Request $request)
    {
        $supervisor_id = $request->input('supervisor_id');
        $client_id = $request->input('client_id');
        $jobsite_id = $request->input('jobsite_id');

        $this->supervisor->attach($supervisor_id, $jobsite_id);
        $title = Jobsite::where('id',$jobsite_id)->value('title');
        $userid = Supervisor::where('id',$supervisor_id)->value('user_id');
        $message = " have been assigned to a jobsite for ".$title;
        $type = SUP_REQ_JOB;
        activity($userid,$message,$type,NULL,$supervisor_id,$jobsite_id,NULL);

        return redirect('/supervisors/jobsite/'.$supervisor_id);
    }

    public function unassign($supervisor_id, $jobsite_id)
    {
        $this->supervisor->detach($supervisor_id, $jobsite_id);
        $title = Jobsite::where('id',$jobsite_id)->value('title');
        $userid = Supervisor::where('id',$supervisor_id)->value('user_id');
        $message = " have been detached to a jobsite for ".$title;
        $type = SUP_REQ_JOB;
        activity($userid,$message,$type,NULL,$supervisor_id,$jobsite_id,NULL);
        return redirect('/supervisors/jobsite/'.$supervisor_id);
    }

    public function thankyou(Request $request)
    {
        $data = [];
        $data['start'] = new \DateTime();//new \DateTime($request->session()->get('from'));
        $data['end'] = new \DateTime();//new \DateTime($request->session()->get('to'));

        return view('supervisors.thankyou', $data);
    }

   public function employee(Request $request){

       $id =Auth::id();
       $supervisor_tms = Supervisor::Where('user_id',$id)->first();
       $supervisor_id = $supervisor_tms->id;
       $jobsites = Supervisor::findOrFail($supervisor_id)->jobsites()->get();
       $jobsites_ids = $jobsites->pluck('id')->toArray();
       $employee_ids =  EmployeeJobsite::whereIn('jobsite_id',$jobsites_ids)->pluck('employee_id')->toArray();

       if(isset($request['orderby']) && isset($request['sortby'])){

           $employee['rows'] = DB::table('employee_jobsite')
                  ->whereIn('employee_jobsite.employee_id', $employee_ids)
                  ->join('employees', 'employees.id', 'employee_jobsite.employee_id')
                  ->select('employees.id', 'employees.first_name', 'employees.last_name', 'employees.phone', 'employee_jobsite.employee_id', 'employee_jobsite.jobsite_id','employee_jobsite.employee_id')
                  ->orderBy($request['orderby'], $request['sortby'])
                  ->paginate(15);

      }else{

       $employee['rows'] = DB::table('employee_jobsite')
       ->whereIn('employee_jobsite.employee_id', $employee_ids)
       ->join('employees', 'employees.id', 'employee_jobsite.employee_id')
       ->select('employees.id', 'employees.first_name', 'employees.last_name', 'employees.phone', 'employee_jobsite.employee_id', 'employee_jobsite.jobsite_id','employee_jobsite.employee_id')
       ->paginate(15);
      }

       return view('supervisors.employee', $employee);
  }

    public function employeeTimesheet(Request $request){
        $search = isset($request['employee']) ? $request['employee'] : '';

        if($search != ''){
           $employee = Employee::where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%')->pluck('id')->toArray();
        }

        $supervisor_tms = $this->supervisor->getSupervisorId(Auth::id());
        $supervisor_id = $supervisor_tms->id;
        $jobsites = Supervisor::findOrFail($supervisor_id)->jobsites()->get();
        $jobsites_ids = $jobsites->pluck('id')->toArray();
        $employee_ids =  EmployeeJobsite::whereIn('jobsite_id',$jobsites_ids)->pluck('employee_id')->toArray();
        $employee_ids = Timesheet::whereIn('employee_id',$employee_ids)->where('status',1)->pluck('employee_id')->toArray();

        if(isset($employee)){
          $employee_ids = array_intersect($employee, $employee_ids);
        }
        if(isset($request['orderby']) && isset($request['sortby'])){
            $employee = DB::table('employees')
                        ->join('employee_jobsite', 'employees.id', '=', 'employee_jobsite.employee_id')
                        ->join('jobsites', 'employee_jobsite.jobsite_id', '=', 'jobsites.id')
                        ->join('clients', 'jobsites.client_id', '=', 'clients.id')
                        ->select('employees.*', 'jobsites.title' ,'clients.company_name')
                        ->whereIn('employees.id',$employee_ids)
                        ->orderBy($request['orderby'],$request['sortby'])
                        ->paginate(15);
        }
        else{
            $employee = DB::table('employees')
                        ->join('employee_jobsite', 'employees.id', '=', 'employee_jobsite.employee_id')
                        ->join('jobsites', 'employee_jobsite.jobsite_id', '=', 'jobsites.id')
                        ->join('clients', 'jobsites.client_id', '=', 'clients.id')
                        ->select('employees.*', 'jobsites.title' ,'clients.company_name')
                        ->whereIn('employees.id',$employee_ids)
                        ->paginate(15);
        }


       return view('supervisors.timesheets', array('final'=>$employee));
    }

     public function getTimesheet(Request $request){
       $emp_id = $request->emp_id;
       $date = $request->last_updated_jobsite_date;
       $temp = [];

        if(isset($request['orderby']) && isset($request['sortby'])){
            $timesheet = Timesheet::where('employee_id',$emp_id)->where('status',1)->orderBy($request['orderby'], $request['sortby'])->paginate(15);
        }else{
            $timesheet = Timesheet::where('employee_id',$emp_id)->where('status',1)->paginate(15);

        }

       //$timesheet = $this->timesheet->sortable($request)->getByEmployee($emp_id)->paginate();

       return view('timesheets.emptimesheet',array('final'=>$timesheet));
   }

    public function myaccount(Request $request){
       $Record_get  = $this->supervisor->getSupervisorId(Auth::id());
       $uname_get = User::where('email', $Record_get->email)->first();
       return view('supervisors.myaccount', ['Record_get' => $Record_get, 'uname_get' => $uname_get]);
   }

   public function Update1(Request $request)
   {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
       ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

       $id = $request->id;
       $new_user = $this->supervisor->show($id);

        if($id != null){
            $email = $request->input('email');

            $fields = [
               'first_name',
               'last_name',
               'phone',
               'email',
            ];

           $supervisor_row = $request->only($fields);
           $this->supervisor->update($supervisor_row, $id);

            $userid = Auth::id();
            $message = "updated profile";
            $type = SUP_PROFILE;
            $supervisorid = $id;
            activity($userid,$message,$type,NULL,$supervisorid,NULL,NULL);
        }
        else{
            $message = "Something Went Wrong";
        }
       return back();
   }
   public function jobsiteRequest(){
       $data = array();
       $data['clients'] = $this->client->dropdown();
       return view('supervisors.request_jobsite',$data);
   }
    public function addRequest(Request $request){
        $validator = Validator::make($request->all(), [
           'company' => 'required',
           'jobsite' => 'required'
       ]);

       if ($validator->fails()){
           return redirect()->back()->withErrors($validator);
       }

       $reqjobsite = new RequestJobsite;
       $reqjobsite->user_id = Auth::id();
       $reqjobsite->client_id = $request->company;
       $reqjobsite->jobsite_id = $request->jobsite;
       $reqjobsite->status = $request->status;
       $reqjobsite->save();

            $userid = Auth::id();
            $message = "requested for jobsite.";
            $type = SUP_REQ_JOB;
            $supervisorid = Supervisor::where('user_id',$userid)->value('id');
            activity($userid,$message,$type,NULL,$supervisorid,NULL,NULL);

       return view('supervisors.message');
   }
    public function sup_pending_req(Request $request){

       $now = Carbon::now();
       $timesheet['start'] = $now->startOfWeek()->format('Y-m-d');
       $timesheet['date'] =  $now->endOfWeek()->format('Y-m-d');

       $id =Auth::id();
       $supervisor_tms = Supervisor::Where('user_id',$id)->first();
       $supervisor_id = $supervisor_tms->id;
       $jobsites = Supervisor::findOrFail($supervisor_id)->jobsites()->get();
       $jobsites_ids = $jobsites->pluck('id')->toArray();
       $jobsite_clientId = $jobsites->pluck('client_id')->toArray();

       $employee_ids =  EmployeeJobsite::whereIn('jobsite_id',$jobsites_ids)->pluck('employee_id')
                       ->toArray();
        $final=[];
        foreach($employee_ids as $employee_id)
        {
            $timesheet_rec = Timesheet::where('employee_id', $employee_id)
                           ->where('status', 0)
                           ->get();
           $jobsite_ids = [];
           foreach($timesheet_rec as $value){

               $cId = $value->jobsite_id;
               $clientId = Jobsite::where('id', $cId)
                       ->pluck('client_id');
               if(in_array($value->jobsite_id, $jobsite_ids)){
                   continue;
               }
               $jobsite_ids[] = $value->jobsite_id;
               $temp = [];

               $temp['emp_id']=$value->employee->id;
               $temp['first_name'] = $value->employee->first_name;
               $temp['last_name'] = $value->employee->last_name;
               $temp['date'] = $value->date;
               $temp['start'] = $value->start;
               $temp['end'] = $value->end;
               $temp['status'] = $value->status;
               $temp['client_id'] = $clientId[0];
               $temp['jobsite_id'] = $value->jobsite_id;

               $final[]=$temp;
           }
        }

        $timesheet['rows'] = sortArray($final, $request);
        return view('supervisors.pendingTimesheet', $timesheet);
   }

    public function approveRequest(Request $request){

        if($request->action == 1){

            $approve = Timesheet::where('id',$request->id)->first();
            $approve->status = 1;
            $approve->save();

            $supervisor = $this->supervisor->getSupervisorId(Auth::id());

            $activity = new Activity;
            $activity->user_id = $supervisor->user_id;
            $activity->message = "supervisor has approved timesheet request";
            $activity->save();

            sendEmail($approve->user_id,EMP_JOBSITE_APPR);
        }
        if($request->delete == 1){

            $approve = Timesheet::where('id',$request->id)->first();

            $activity = new Activity;
            $activity->user_id = $approve->employee_id;
            $activity->message = "supervisor has removed timesheet request";
            $activity->save();

            $approve->delete();

        }
        return redirect()->action('SupervisorController@sup_pending_req');

    }

}
