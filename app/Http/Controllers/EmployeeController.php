<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use PDF;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Activity;
use App\RequestJobsite;
use App\User;
use App\Employee;
use App\Jobsite;
use App\EmployeeLicence;
use App\Position;
use App\EmployeeJobsite;
use App\EmployeePosition;
use App\EmployeeNote;

use Carbon\Carbon;
use App\Timesheet;
use DB;
use App\Repository\Contract\UserInterface as UserInterface;
use App\Repository\Contract\EmployeeInterface as EmployeeInterface;
use App\Repository\Contract\PositionInterface as PositionInterface;
use App\Repository\Contract\ClientInterface as ClientInterface;
use App\Repository\Contract\JobsiteInterface as JobsiteInterface;
use App\Repository\Contract\TimesheetInterface as TimesheetInterface;
use App\Repository\Contract\ImageInterface as ImageInterface;

use App\Http\Requests\EmployeeRequest as EmployeeRequest;

class EmployeeController extends Controller
{
    //
    private $user;
    private $employee;
    private $position;
    private $client;
    private $jobsite;
    private $timesheet;
    private $image;
    private $request;

    public function __construct(Request $request, EmployeeInterface $employee, PositionInterface $position, ClientInterface $client,
        JobsiteInterface $jobsite, TimesheetInterface $timesheet, UserInterface $user, ImageInterface $image)
    {
        $this->request = $request;
    	$this->user = $user;
        $this->employee = $employee;
        $this->client = $client;
        $this->jobsite = $jobsite;
        $this->position = $position;
        $this->timesheet = $timesheet;
        $this->image = $image;
    }

    public function dashboard(){
        $user_id = Auth::id();
        $employee_id = Employee::where('user_id',$user_id)->value('id');

        $activity1 = Activity::where('user_id',$user_id);
        if($employee_id != null){
            $activity1 = $activity1->orWhere('employee_id',$employee_id);
        }
        $activity1 = $activity1->orderBy('id','desc')->paginate(15);
        $activity['rows'] = $activity1;
        return view('employees.dashboard',$activity);
    }

    public function index(Request $request){

        $search = isset($request['employee']) ? $request['employee'] : '';
        if($search != ''){
           $employee = Employee::where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%')->pluck('id')->toArray();

        }

        if(isset($employee)){

            if(isset($request['orderby']) && isset($request['sortby'])){
                $data['rows'] = Employee::whereIn('id',$employee)->orderBy($request['orderby'], $request['sortby'])->paginate(15);
            }
            else{
                $data['rows'] = Employee::whereIn('id',$employee)->paginate(15);

            }
            return view('employees.list',$data);
        }
        if(isset($request['orderby']) && isset($request['sortby'])){
            $data['rows'] = Employee::orderBy($request['orderby'], $request['sortby'])->paginate(15);
        }
        else{
            $data['rows'] = Employee::paginate(15);
        }

        return view('employees.list',$data);
    }

    public function create(){
        $data = array();

        $data['clients'] = $this->client->dropdown();

        $positions              = Position::where('status', 1)->get();
        $data['positions']      = [];
        foreach($positions as $position) {
            $data['positions'][] = [
                'id'            => $position->id,
                'label'         => $position->title
            ];
        }

        $data['positions']      = json_encode($data['positions']);

        return view('employees.create', $data);
    }

    public function update($id) {
        $data = [];
        $data['row'] = $this->employee->show($id);
        $data['licence'] = EmployeeLicence::where('emp_id',$data['row']->id)->get();

        $positions              = Position::where('status', 1)->get();
        $data['positions']      = [];
        foreach($positions as $position) {
            $data['positions'][] = [
                'id'            => $position->id,
                'label'         => $position->title
            ];
        }

        $data['positions']          = json_encode($data['positions']);
        $data['employeePositions']  = EmployeePosition::where('employee_id', $id)->with('position')->get()->toArray();
        $data['employeePositions']  = json_encode($data['employeePositions']);

        $data['notes']              = EmployeeNote::where('employee_id', $id)->with('userInfo')->orderBy('created_at', 'DESC')->get();

        $emp_id = $this->employee->show($id)->user_id;
        $data['user'] = User::where('id',$emp_id)->first();

        return view('employees.create', $data);
    }

    public function save(EmployeeRequest $request)
    {
        $id = $request->input('id');
        $jobsite_id = $request->input('jobsite_id');


        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:employees'. ($id ? (',email,'.$id) : '')
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($id) {
            $new_user   = $this->employee->show($id);
        }

        $name       = !empty($new_user) ? $new_user->license_image : '';


        $email = $request->input('email');
        $emp_id = $id;

        $files = $request->file('license_image');
        if($files != null && is_array($files)){
            foreach($files as $file) {
                $name = strtotime(Carbon::now()).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('/dore/employee'), $name);
            }
        }

        $fields = [
            'first_name',
            'last_name',
            'phone',
            'email',
            'account_name',
            'account_number',
            'account_bsb',
            'file_number',
            'superannuation',
            'member_number',
            'abn',
            'status'
        ];
        $public = '';
        $insurance = $request->input('insurance');
        if($insurance && count($insurance) > 0){
            $public = implode(",",$insurance);
        }


        $employee_row = $request->only($fields);
        $employee_row['license_image'] = $name;
        $employee_row['insurance'] = $public;
        DB::beginTransaction();
        if($id == null){
            $new_employee = $this->employee->create($employee_row);
            $this->employee->attach($new_employee->id, $jobsite_id);
            $emp_id = $new_employee->id;
            $message = "created an Employee";
            $type = EMP_PROFILE;
            activity(Auth::id(),$message,$type,$emp_id,NULL,NULL,NULL);

        }else{
            $emp = $this->employee->update($employee_row, $id);
            $message = "updated by Admin";
            $type = EMP_PROFILE;
            $emp_id = $id;
            activity(Auth::id(),$message,$type,$emp_id,NULL,NULL,NULL);
        }


       $positionFields     = $request->only('position_id');
       // Delete previous entries, add new ones
       EmployeePosition::where('employee_id', $id)->delete();

       foreach($positionFields['position_id'] as $index => $value) {
           if(!$value) continue;

           EmployeePosition::create([
               'employee_id'     => $id,
               'position_id'   => $value
           ]);
       }

       // Save note if any
       if( $request->get('notes') ) {
            EmployeeNote::create([
                'employee_id'       => $id,
                'note'              => $request->get('notes'),
                'added_by'          => Auth::user()->id
            ]);
        }

        /*start*/

        $old_lic = EmployeeLicence::where('emp_id',$emp_id)->pluck('id')->toArray();

        if( !empty($request['license_number']) ) {
            foreach($request['license_number'] as $key => $licence) {
                if(empty($request['license_type'][$key])) continue;

                if(isset($request['license_id'][$key])){
                    $lic = EmployeeLicence::find($request['license_id'][$key]);
                    if (($key2 = array_search($request['license_id'][$key], $old_lic)) !== false) {
                        unset($old_lic[$key2]);
                    }
                }else{
                    if($request['license_number'][$key] != ''){
                        $lic = new EmployeeLicence;
                    }else{
                        continue;
                    }
                }

                $file = is_array($request['license_image_front']) && !empty($request['license_image_front'][$key]) ? $request['license_image_front'][$key] : null;
                if($file != null ){
                    $name = strtotime(Carbon::now()).'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('/dore/employee'), $name);

                    if(isset($lic->license_image_front) && $lic->license_image_front != ''){
                        if (file_exists(public_path('/dore/employee/'.$lic->license_image_front))){
                            unlink(public_path('/dore/employee/'.$lic->license_image_front));
                        }

                    }
                }else{
                    $name = isset($lic->license_image_front) ? $lic->license_image_front : '';
                }

                $file1 = is_array($request['license_image_back']) && !empty($request['license_image_back'][$key]) ? $request['license_image_back'][$key] : null;
                if($file1 != null ){
                    $name1 = strtotime(Carbon::now()).'.'.$file1->getClientOriginalExtension();
                    $file1->move(public_path('/dore/employee'), $name1);

                    if(isset($lic->license_image_back) && $lic->license_image_back != ''){
                        if (file_exists(public_path('/dore/employee/'.$lic->license_image_back))){
                        unlink(public_path('/dore/employee/'.$lic->license_image_back));
                        }
                    }
                }else{
                    $name1 = isset($lic->license_image_back) ? $lic->license_image_back : '';
                }


                $lic->emp_id = $emp_id;
                $lic->license_type = $request['license_type'][$key];
                $lic->other_type = $request['type_other'][$key];
                $lic->license_date = $request['license_date'][$key];
                $lic->license_number = $request['license_number'][$key];
                $lic->license_image_front = $name;
                $lic->license_image_back = $name1;
                $lic->save();
            }
        }

        if(count($old_lic) > 0){
            foreach($old_lic as $old){
                $db_lic = EmployeeLicence::find($old);
                if(isset($db_lic->license_image_front) && $db_lic->license_image_front != ''){
                    if (file_exists(public_path('/dore/employee/'.$db_lic->license_image_front))){
                    unlink(public_path('/dore/employee/'.$db_lic->license_image_front));
                    }
                }
                if(isset($db_lic->license_image_back) && $db_lic->license_image_back != ''){
                    if (file_exists(public_path('/dore/employee/'.$db_lic->license_image_back))){
                    unlink(public_path('/dore/employee/'.$db_lic->license_image_back));
                    }
                }
                $db_lic =$db_lic->delete();
            }
        }
        /*end*/
        DB::commit();
        return redirect('/employees/');
    }
    public function createEmployee(){
       return view('employees.createEmployee');
    }
    public function myAccount(){
       $data = [];
       $data['row'] = $this->employee->getEmployeeId(Auth::id());
       $data['licence'] = EmployeeLicence::where('emp_id',$data['row']->id)->get();
       return view('employees.createEmployee', $data);
    }
    public function saveEmployee(Request $request){

        $id = $request->input('id');
        $jobsite_id = isset($request->jobsite_id) ? $request->jobsite_id : '';

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:employees'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $fields = [
            'first_name',
            'last_name',
            'phone',
            'email',
            'account_name',
            'account_number',
            'account_bsb',
            'file_number',
            'superannuation',
            'member_number',
            'abn',
            'status'
        ];

        $public = '';
        $insurance = $request->input('insurance');
        if(is_array($insurance) && count($insurance) > 0){
            $public = implode(",",$insurance);
        }

        $employee_row = $request->only($fields);
        $employee_row['insurance'] = $public;

       if($id == null){
            $new_employee = $this->employee->create($employee_row);
            $emp_id = $new_employee->id;
            if($jobsite_id != ''){
                $this->employee->attach($new_employee->id, $jobsite_id);
            }
            $message = "joined";
            $type = EMP_PROFILE;
            $employeeid = $id;
            activity(Auth::id(),$message,$type,$employeeid,NULL,NULL,NULL);


       }else{
            $this->employee->update($employee_row, $id);
            $message = "changed account information";
            $type = EMP_PROFILE;
            $employeeid = $id;
            activity(Auth::id(),$message,$type,$employeeid,NULL,NULL,NULL);
       }

       $positionFields     = $request->only('position_id');

       // Delete previous entries, add new ones
       EmployeePosition::where('employee_id', $id)->delete();

       foreach($positionFields['position_id'] as $index => $value) {
           if(!$value) continue;

           EmployeePosition::create([
               'employee_id'     => $id,
               'position_id'   => $value
           ]);
       }


        $old_lic = EmployeeLicence::where('emp_id',$emp_id)->pluck('id')->toArray();
        foreach($request['license_number'] as $key => $licence){

            if(isset($request['license_id'][$key])){
                $lic = EmployeeLicence::find($request['license_id'][$key]);
                if (($key2 = array_search($request['license_id'][$key], $old_lic)) !== false) {
                    unset($old_lic[$key2]);
                }
            }else{
                if($request['license_number'][$key] != ''){
                    $lic = new EmployeeLicence;
                }else{
                    continue;
                }
            }

            $file = $request['license_image_front'][$key];
            if($file != null ){
                $name = strtotime(Carbon::now()).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('/dore/employee'), $name);

                if(isset($lic->license_image_front) && $lic->license_image_front != ''){
                    if (file_exists(public_path('/dore/employee/'.$lic->license_image_front))){
                    unlink(public_path('/dore/employee/'.$lic->license_image_front));
                    }
                }
            }else{
                $name = isset($lic->license_image_front) ? $lic->license_image_front : '';
            }

            $file1 = $request['license_image_back'][$key];
            if($file1 != null ){
                $name1 = strtotime(Carbon::now()).'.'.$file1->getClientOriginalExtension();
                $file1->move(public_path('/dore/employee'), $name1);

                if(isset($lic->license_image_back) && $lic->license_image_back != ''){
                    if (file_exists(public_path('/dore/employee/'.$lic->license_image_back))){
                    unlink(public_path('/dore/employee/'.$lic->license_image_back));
                    }
                }
            }else{
                $name1 = isset($lic->license_image_back) ? $lic->license_image_back : '';
            }


            $lic->emp_id = $emp_id;
            $lic->license_type = $request['license_type'][$key];
            $lic->other_type = $request['type_other'][$key];
            $lic->license_date = $request['license_date'][$key];
            $lic->license_number = $request['license_number'][$key];
            $lic->license_image_front = $name;
            $lic->license_image_back = $name1;
            $lic->save();
        }
        if(count($old_lic) > 0){
            foreach($old_lic as $old){
                $db_lic = EmployeeLicence::find($old);
                if(isset($db_lic->license_image_front) && $db_lic->license_image_front != ''){
                    if (file_exists(public_path('/dore/employee/'.$db_lic->license_image_front))){
                    unlink(public_path('/dore/employee/'.$db_lic->license_image_front));
                    }
                }
                if(isset($db_lic->license_image_back) && $db_lic->license_image_back != ''){
                    if (file_exists(public_path('/dore/employee/'.$db_lic->license_image_back))){
                    unlink(public_path('/dore/employee/'.$db_lic->license_image_back));
                    }
                }
                $db_lic =$db_lic->delete();
            }
        }

        if($id == null){
            return redirect('login');
        }else{
           return redirect()->back()->withSuccess("Data successfully updated");
        }

   }
    public function remove_image(Request $request)
    {
        $id=$request['id'];
        $data=$this->employee->show($id);
        $row = array();
        if (file_exists(public_path('/dore/employee/'.$data->license_image))){
        unlink(public_path('/dore/employee/'.$data->license_image));
        }
        $row['license_image'] = "";
        $this->employee->update($row,$data->id);
        return redirect('/employees/');
    }

    public function jobsite($id)
    {
        $employee_id = $id;

        $data = [];
        $data['employee_id'] = $employee_id;
        $data['rows'] = $this->employee->paginateByEmployee($employee_id);
        return view('employees.jobsite', $data);
    }

    public function jobsites(Request $request)
   {
      $employee = $this->employee->getEmployeeId(Auth::id());
      //dd($employee);
      $employee_id = (!empty($employee->id)) ? $employee->id : 0;
      $data_id = $employee_id;
      $employee = Employee::where('id',$data_id)->first();
      $data['rows'] = $employee->jobsites();
      //dd($data['rows']);

      $temp1 = DB::table('employees')
      ->join('employee_jobsite', 'employees.id', '=', 'employee_jobsite.employee_id')
      ->join('jobsites', 'employee_jobsite.jobsite_id', '=', 'jobsites.id')
      ->join('clients', 'jobsites.client_id', '=', 'clients.id')
      ->select('jobsites.*' ,'clients.company_name', 'employees.id as employee_id')
      ->where('employees.id',$data_id);


      if(isset($request['orderby']) && isset($request['sortby'])){

       $allowed = ['company_name', 'address', 'status'];
       if(in_array($request['orderby'], $allowed)){
           $approve['rows'] = $temp1->orderBy($request['orderby'],$request['sortby'])->paginate(15, ['*'], 'approve');
       }else{
               $approve['rows'] = $temp1->paginate(15, ['*'], 'approve');
           }

       }
       else{
           $approve['rows'] = $temp1->paginate(15, ['*'], 'approve');
       }

     $temp2 = DB::table('request_jobsite')
     ->join('employees', 'request_jobsite.user_id', 'employees.user_id')
      ->join('positions', 'request_jobsite.position_id', 'positions.id')
      ->select('request_jobsite.*', 'positions.title')
      ->where('employees.id',$data_id);
      if(isset($request['orderby']) && isset($request['sortby'])){

       $allowed = ['project_name', 'title', 'address', 'status'];
       if(in_array($request['orderby'], $allowed)){


           $notapprove['rows'] = $temp2->orderBy($request['orderby'],$request['sortby'])->paginate(15, ['*'], 'notapprove');

       }else{
           $notapprove['rows'] = $temp2->paginate(15, ['*'], 'notapprove');
       }

       }
       else{
           $notapprove['rows'] = $temp2->paginate(15, ['*'], 'notapprove');
       }

      return view('employees.jobsites', array('notapprove'=>$notapprove, 'approve'=>$approve));
   }

    public function timesheet($jobsite_id=0,$client_id=0)
    {
        $employee = $this->employee->getEmployeeId(Auth::id());
        $employee_id = $employee->id;

        $data = [];

        $data['client_id'] = $client_id;
        $data['jobsite_id'] = $jobsite_id;
        $data['employee_id'] = $employee_id;

        $date = $this->request->get('date');

        if(!empty($date)){
            $dayStart = new \DateTime($date);

            if($dayStart->format("D") != "Mon"){
                $dayStart->modify("last monday");
            }

        }else{
            $dayStart = new \DateTime("last monday");
        }

        $baseDate = $dayStart->format("Y-m-d");
        $previousWeek = new \DateTime($baseDate);
        $previousWeek->modify("previous monday");
        $nextWeek = new \DateTime($baseDate);
        $nextWeek->modify("next monday");

        $data['previousWeek'] = url('/employees/jobsites/timesheet/'.$jobsite_id.'/'.$client_id.'/?date='.$previousWeek->format("Y-m-d"));
        $data['nextWeek'] = url('/employees/jobsites/timesheet/'.$jobsite_id.'/'.$client_id.'/?date='.$nextWeek->format("Y-m-d"));

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
        if(!empty($data['rows'][6]->images)){
            $data['images'] = $data['rows'][6]->images()->get();
        }else{
            $data['images'] = [];
        }

        $agent = new Agent();

        if($agent->isMobile()){
            $data['is_mobile'] = true;
            return view('employees.timesheet', $data);
        }else{
            $data['is_mobile'] = false;
            return view('employees.timesheet', $data);
        }
    }

    /*public function timesheet_save()
    {
        $employee = $this->employee->getEmployeeId(Auth::id());
        $employee_id = $employee->id;

        $export_pdf = $this->request->input('export_pdf');
        $download_mode = $this->request->input('download_mode');

        $client_id = $this->request->input('client_id');
        $jobsite_id = $this->request->input('jobsite_id');

        $ids = $this->request->input('id');
        $dates = $this->request->input('date');
        $starts = $this->request->input('start');
        $ends = $this->request->input('end');
        $break = $this->request->input('break');
        $status = $this->request->input('status');

        for($i=0; $i< sizeof($ids); $i++)
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
            }else{
                $this->timesheet->update($row,$id);
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

        $activity = new Activity;
        $activity->user_id = $employee->user_id;
        $activity->message = "employee has added a timesheet";
        $activity->save();

        return redirect('/employees/jobsites/timesheet/thankyou')->with('from',$dates[0])->with('to',$dates[sizeof($dates)-1]);

    }*/
    public function timesheet_save()
    {
        $employee = $this->employee->getEmployeeId(Auth::id());
        $employee_id = $employee->id;
        $export_pdf = $this->request->input('export_pdf');
        $download_mode = $this->request->input('download_mode');
        $client_id = $this->request->input('client_id');
        $jobsite_id = $this->request->input('jobsite_id');

        $ids = $this->request->input('id');
        $dates = $this->request->input('date');
        $starts = $this->request->input('start');
        $ends = $this->request->input('end');
        $break = $this->request->input('break');
        $status = $this->request->input('status');

        for($i=0; $i< sizeof($ids); $i++)
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
                $userid = $employee->user_id;
                $employeeid = $employee->id;
                $message = "entered a timesheet for Week Ending ".$row['start'];
                $type = EMP_TIMESHEET;
                activity($userid,$message,$type,$employeeid,NULL,$jobsite_id,NULL);
            }else{
                $row['status'] = 0;
                $this->timesheet->update($row,$id);
                $userid = $employee->user_id;
                $employeeid = $employee->id;
                $message = "edited a timesheet for Week Ending ".$row['start'];
                $type = EMP_TIMESHEET;
                activity($userid,$message,$type,$employeeid,NULL,$jobsite_id,NULL);
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
        $data['employee_id'] = $id;

        $data['clients'] = $this->client->dropdown();

        return view('employees.assign', $data);
    }

    public function assign_save(Request $request)
    {
        $employee_id = $request->input('employee_id');
        $client_id = $request->input('client_id');
        $jobsite_id = $request->input('jobsite_id');

        //dd($this->employee->show($employee_id));

        $this->employee->attach($employee_id, $jobsite_id);
        $userid = Employee::where('id',$employee_id)->value('user_id');
        $message = " assigned to a jobsite.";
        $type = EMP_REQ_APR;
        activity($userid,$message,$type,$employee_id,NULL,$jobsite_id,NULL);

        return redirect('/employees/jobsite/'.$employee_id);
    }

    public function unassign($employee_id, $jobsite_id)
    {
        $this->employee->detach($employee_id, $jobsite_id);
        $userid = Employee::where('id',$employee_id)->value('user_id');
        $message = " detached to a jobsite.";
        $type = EMP_REQ_APR;
        activity($userid,$message,$type,$employee_id,NULL,$jobsite_id,NULL);
        return redirect('/employees/jobsite/'.$employee_id);
    }

    public function thankyou(Request $request)
    {
        $data = [];
        $data['start'] = new \DateTime($request->session()->get('from'));
        $data['end'] = new \DateTime($request->session()->get('to'));

        return view('employees.thankyou', $data);
    }
    public function jobsiteRequest(){
       $data = array();
       $data['clients'] = $this->client->dropdown();
       $data['positions'] = $this->position->dropdown();
       return view('employees.request_jobsite',$data);
   }

    public function addRequest(Request $request){
       $validator = Validator::make($request->all(), [
          'project_name' => 'required',
          'position' => 'required',
          'address' => 'required',
          'suburb' => 'required',
          'state' => 'required',
          'postcode' => 'required',


      ]);

      if ($validator->fails()){
          return redirect()->back()->withErrors($validator);
      }

      $reqjobsite = new RequestJobsite;
      $reqjobsite->user_id = Auth::id();
      //$reqjobsite->client_id = $request->company;
      //$reqjobsite->jobsite_id = $request->jobsite;
      $reqjobsite->project_name = $request->project_name;
      $reqjobsite->position_id = $request->position;
      $reqjobsite->address = $request->address;
      $reqjobsite->suburb = $request->suburb;
      $reqjobsite->state = $request->state;
      $reqjobsite->postcode = $request->postcode;
      $reqjobsite->status = 0;
      $reqjobsite->save();

        $userid = Auth::id();
        $message = "requested for jobsite.";
        $type = EMP_REQ_JOB;
        $employeeid = Employee::where('user_id',$userid)->value('id');
        activity($userid,$message,$type,$employeeid,NULL,$reqjobsite->jobsite_id,NULL);

       return view('employees.message');
   }

   public function getJobsite($id){
       $emp = $this->employee->getEmployeeId(Auth::id());
       $jobsites_emp = $emp->jobsites;
       $jobsites_client = $this->jobsite->byClientId($id);
       $data = [];

        foreach ($jobsites_emp as $key => $value) {
           if($value->client_id == $id){
               $data[] = $value;
           }
        }
       return response()->json($data);
   }

   public function timesheetList(Request $request){

   $emp = $this->employee->getEmployeeId(Auth::id());
   $emp_id = $emp->id;

   $jobsite_id = EmployeeJobsite::where('employee_id', $emp_id)->orderBy('id','desc')->first();

   if(isset($jobsite_id->jobsite_id) && $jobsite_id->jobsite_id != NULL){
       $timehsheet = Timesheet::where('employee_id', $emp_id)->orderBy('id','desc')->first();
       if(!$timehsheet){
           $jobsitesId = $jobsite_id->jobsite_id;

       }else{
           $jobsitesId = $timehsheet->jobsite_id;
       }
       $jobsite_ids = Jobsite::where('id', $jobsitesId)->orderBy('id', 'desc')->first();
       $client_id = $jobsite_ids->client_id;
       return redirect('employee/jobsites/timesheet/'.$client_id.'/'.$jobsitesId.'/'.$emp_id.'?latest=1');
   }
   else{
       return view('employees.timesheetlist');
   }

 }
   public function saveEmployeeAfterSocial(Request $request){

        $user = [
            'name' => $request['name'],
            'email' => $request['email'],
            'username' => $request['username'],
            'password' => '',
        ];

        $new_user = $this->user->createWithRole($user, 'employee');

        $employee_row['user_id'] = $new_user->id;
        $employee_row['first_name'] = $user['name'];
        $employee_row['email'] = $user['email'];
        $employee_row['status'] = 0;

        Log::debug(json_encode($request->all()));

        $new_employee = $this->employee->create($employee_row);

        $userid = $new_user->id;
        $message = "joined using social login";
        $type = SOCIAL;
        $employeeid = Employee::where('user_id',$userid)->value('id');
        activity($userid,$message,$type,$employeeid,NULL,NULL,NULL);

        Auth::login($new_user);

        $user['social'] = $request['social'];
        return view('employees.social',['user' => $user]);
        return redirect('/');


   }

}
