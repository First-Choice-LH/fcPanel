<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Pagination\LengthAwarePaginator;

use App\User;
use App\Employee;
use App\Supervisor;
USE aPP\Jobsite;
use App\Timesheet;
use App\Activity;

use Illuminate\Support\Facades\Mail;
use App\Mail\PanelEmail;

function sendEmail($user_id, $type){
    $user = User::find($user_id);

    if($user && $user->email != ''){

        if($type == USER_VERIFY){
            $message = array(
                'to' => $user->email,
                'name' => $user->name,
                'accessToken' => $user->accessToken,
                'type' => $type
            );
            Mail::to($message['to'])->send(new PanelEmail($message));
        }
        else{
            $message = array(
                'to' => $user->email,
                'type' => $type
            );
            Mail::to($message['to'])->send(new PanelEmail($message));
        }

    }
}

/*function sortArray($array, $request){
    if(!is_array($array)){
        $array = (array) $array;
    }
    $orderby = isset($request['orderby']) ? $request['orderby'] : '';
    $sortby = isset($request['sortby']) ? $request['sortby'] : '';

    if($orderby == '' || $sortby == ''){
        return $array;
    }
    foreach ($array as $k => $v) {
        $sort[$orderby][$k] = $v[$orderby];
    }
    if(count($array) > 0){
        if($sortby == 'asc'){
            array_multisort($sort[$orderby], SORT_ASC, $array);
        }else{
            array_multisort($sort[$orderby], SORT_DESC, $array);
        }
    }
    return $array;
}*/
function sortArray($array, $request){

  $orderby = isset($request['orderby']) ? $request['orderby'] : '';
  $sortby = isset($request['sortby']) ? $request['sortby'] : '';
  if($orderby == '' || $sortby == ''){
      //return $array;
      $new = createObject($array, $request);
      return $new;
  }
  foreach ($array as $k => $v) {
      $sort[$orderby][$k] = $v[$orderby];
  }
  if(count($array) > 0){
      if($sortby == 'asc'){
          array_multisort($sort[$orderby], SORT_ASC, $array);
      }else{
          array_multisort($sort[$orderby], SORT_DESC, $array);
      }
  }
  $array1 = createObject($array, $request);
  return $array1;
}
function createObject($array, $request){

   $page = isset($request->page) ? $request->page : 1;
   $perPage = 5;
   $offset = ($page * $perPage) - $perPage;

   $entries =  new LengthAwarePaginator(
       array_slice($array, $offset, $perPage, true),
       count($array), // Total items
       $perPage, // Items per page
       $page, // Current page
       ['path' => $request->url(), 'query' => $request->query()]
   );
   return $entries;
}
function getEmployeeCompany($eid){
  $obj = Timesheet::where('employee_id',$eid)->where('status',1)->orderBy('id','desc')->first();
  if($obj){
      return $obj->jobsite->client->company_name;
  }else{
      return '';
  }
}

function getLastUpdatedJobsite($id){
     $obj = Timesheet::where('employee_id',$id)->where('status',1)->orderBy('id','desc')->first();
     if($obj){
         return $obj->jobsite->title;
     }else{
         return '';
     }
}
function getLastUpdatedTimesheet($id){
     $obj = Timesheet::where('employee_id',$id)->where('status',1)->orderBy('id','desc')->first();
     if($obj){
         return $obj->updated_at;
     }else{
         return '';
     }
}

function activity($userid,$message,$type,$employeeid,$supervisorid,$jobsiteid,$timesheetid){
  $activity = new Activity;
  $activity->user_id        = $userid;
  $activity->message        = $message;
  $activity->employee_id    = $employeeid;
  $activity->supervisor_id  = $supervisorid;
  $activity->jobsite_id     = $jobsiteid;
  $activity->type           = $type;
  $activity->timesheet_id   = $timesheetid;
  $activity->save();


}

function getActivity($row){

  $type = $row->type;
  $data = [];

  if($type == EMP_PROFILE){

    $employee = Employee::where('user_id',Auth::id())->first();
    if(isset($employee)){
      $data['url'] = "/employees/myaccount";
      $data['name'] = 'You have';
    }
    else{
      $data['name'] = 'Admin has';
    }

  }

  if($type == EMP_TIMESHEET){

    $employee = Employee::where('user_id',Auth::id())->first();
    $supervisor = Supervisor::where('user_id',Auth::id())->first();
    if(isset($employee)){
      $data['name'] = 'You have';
      $jobsite = Jobsite::where('id',$row->jobsite_id)->first();
      $data['address'] = $jobsite->title.', '.$jobsite->address.' '.$jobsite->suburb.' '.$jobsite->state.' '.$jobsite->country.' '.$jobsite->postcode;
      $clientid = $jobsite->client_id;
      $date1 = explode(' ', $row->message);
      $date = $date1[count($date1)-2];
      $data['url'] = "/employee/jobsites/timesheet/".$clientid."/".$row->jobsite_id."/".$row->employee_id."?date=".$date;
    }

    elseif(isset($supervisor)){
      $employees = Employee::where('id',$row->employee_id)->first();
      $data['name'] = $employees->first_name.''.$employees->last_name.' have';
      $jobsite = Jobsite::where('id',$row->jobsite_id)->first();
      $data['address'] = $jobsite->title.', '.$jobsite->address.' '.$jobsite->suburb.' '.$jobsite->state.' '.$jobsite->country.' '.$jobsite->postcode;
      $clientid = $jobsite->client_id;
      $date1 = explode(' ', $row->message);
      $date = $date1[count($date1)-2];
      $data['url'] = "/employee/jobsites/timesheet/".$clientid."/".$row->jobsite_id."/".$row->employee_id."?date=".$date;
    }

  }

  if($type == EMP_REQ_JOB){

    $employee = employee::where('user_id',Auth::id())->first();
    if(isset($employee)){
      $data['name'] = 'You ';
      $data['url'] = "/employees/jobsites";
    }

  }

  if($type == SOCIAL){

    $employee = Employee::where('user_id',Auth::id())->first();
    if(isset($employee)){
      $data['name'] = 'You have';
      $data['url'] = "/employees/myaccount";
    }

  }

  if($type == SUP_PROFILE){

    $supervisor = Supervisor::where('user_id',Auth::id())->first();
    if(isset($supervisor)){
      $data['name'] = 'You have';
      $data['url'] = "/supervisors/myaccount";
    }
    else{
      $data['name'] = 'Admin has';
    }

  }

  if($type == SUP_REQ_JOB){

    $supervisor = Supervisor::where('user_id',Auth::id())->first();
    if(isset($supervisor)){
      $data['name'] = 'You ';
      $jobsite = Jobsite::where('id',$row->jobsite_id)->first();
      $data['address'] = $jobsite->title.', '.$jobsite->address.' '.$jobsite->suburb.' '.$jobsite->state.' '.$jobsite->country.' '.$jobsite->postcode;
      $data['url'] = "/supervisors/jobsites";
    }
    else{
      $data['name'] = 'Admin has';
    }

  }

  if($type == EMP_REQ_APR){

    $supervisor = Supervisor::where('user_id',Auth::id())->first();
    $employee = employee::where('user_id',Auth::id())->first();
    if(isset($supervisor)){
      $employees = Employee::where('id',$row->employee_id)->first();
      $data['name'] = $employees->first_name.' '.$employees->last_name;
      $jobsite = Jobsite::where('id',$row->jobsite_id)->first();
      $data['address'] = $jobsite->title.', '.$jobsite->address.' '.$jobsite->suburb.' '.$jobsite->state.' '.$jobsite->country.' '.$jobsite->postcode;
      $data['url'] = "/supervisors/jobsites";

    }
    elseif(isset($employee)){
      $data['name'] = 'You ';
      $jobsite = Jobsite::where('id',$row->jobsite_id)->first();
      $data['url'] = "/employees/jobsites";
    }

  }

  if($type == SUP_PRO_ADM){

    $supervisor = Supervisor::where('user_id',Auth::id())->first();
    if(isset($supervisor)){
      $data['name'] = $supervisor->first_name.' '.$supervisor->last_name;
      $data['url'] = "/supervisors/myaccount";
    }
    else{
      $data['name'] = 'Admin has';
    }

  }

  if($type == EMP_TIME_APR){

    $employee = Employee::where('user_id',Auth::id())->first();
    $supervisor = Supervisor::where('user_id',Auth::id())->first();
    if(isset($employee)){
      $employees = Supervisor::where('id',$row->supervisor_id)->first();
      $data['name'] = $employees->first_name.''.$employees->last_name.' have';
      $jobsite = Jobsite::where('id',$row->jobsite_id)->first();
      $data['address'] = $jobsite->title.', '.$jobsite->address.' '.$jobsite->suburb.' '.$jobsite->state.' '.$jobsite->country.' '.$jobsite->postcode;
      $clientid = $jobsite->client_id;
      $date1 = explode(' ', $row->message);
      $date = $date1[count($date1)-2];
      $data['url'] = "/employee/jobsites/timesheet/".$clientid."/".$row->jobsite_id."/".$row->employee_id."?date=".$date;
    }

    elseif(isset($supervisor)){

      $data['name'] = "You have";
      $jobsite = Jobsite::where('id',$row->jobsite_id)->first();
      $data['address'] = $jobsite->title.', '.$jobsite->address.' '.$jobsite->suburb.' '.$jobsite->state.' '.$jobsite->country.' '.$jobsite->postcode;
      $clientid = $jobsite->client_id;
      $date1 = explode(' ', $row->message);
      $date = $date1[count($date1)-2];
      $data['url'] = "/employee/jobsites/timesheet/".$clientid."/".$row->jobsite_id."/".$row->employee_id."?date=".$date;
    }

  }

  return $data;


}
function getName($row){

  $superviosr = Supervisor::where('user_id',$row->user_id)->first();
  $employee = Employee::where('user_id',$row->user_id)->first();
  if(isset($employee)){
    return $employee->first_name." ".$employee->last_name." has";
  }
  elseif (isset($supervisor)) {
    return $superviosr->first_name." ".$supervisor->last_name." has";
  }
  else{
    $user = User::where('id',$row->user_id)->first();
    return $user->name." ";
  }
}

function getUserFriendlyDateTime($date, $format = 'm/d/Y h:i A') {
    return date($format, strtotime($date));
}
