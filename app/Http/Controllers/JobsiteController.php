<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\Contract\JobsiteInterface as JobsiteInterface;
use App\Repository\Contract\ClientInterface as ClientInterface;
use App\Http\Requests\JobsiteRequest as JobsiteRequest;
use App\Repository\Contract\EmployeeInterface as EmployeeInterface;
use App\Repository\Contract\SupervisorInterface as SupervisorInterface;

use App\RequestJobsite;
use App\Activity;
use App\Jobsite;
use App\Supervisor;
use App\Employee;
use DB;
class JobsiteController extends Controller
{
    //
	private $jobsite;
    private $client;
    private $employee;
    private $supervisor;

    public function __construct(JobsiteInterface $jobsite, ClientInterface $client, EmployeeInterface $employee, SupervisorInterface $supervisor)
    {
        $this->jobsite = $jobsite;
        $this->client = $client;
        $this->supervisor = $supervisor;
        $this->employee = $employee;
    }

    public function index(Request $request){

        if(isset($request['orderby']) && isset($request['sortby'])){

            $data['rows'] = DB::table('jobsites')
                               ->join('clients', 'clients.id', 'jobsites.client_id')
                               ->select('clients.company_name', 'jobsites.id','jobsites.address','jobsites.status')
                               ->orderBy($request['orderby'], $request['sortby'])
                               ->paginate(10);
        }
        else{

            $data['rows'] = DB::table('jobsites')
                           ->join('clients', 'clients.id', 'jobsites.client_id')
                           ->select('clients.company_name', 'jobsites.id','jobsites.address','jobsites.status')
                           ->paginate(10);
       }
       return view('jobsites.list',$data);
    }

    public function create()
    {
        $data = [];
        $data['clients'] = $this->client->dropdown();

        return view('jobsites.create', $data);
    }

    public function update($id)
    {
        $data = [];
        $data['clients'] = $this->client->dropdown();
        $data['row'] = $this->jobsite->show($id);
        
        return view('jobsites.create', $data);
    }

    public function save(JobsiteRequest $request)
    {
        $id = $request->input('id');

        $fields = [
            'client_id',
            'title',
            'address',
            'suburb',
            'state',
            'country',
            'postcode',
            'status'
        ];

        if($id == null){
            $this->jobsite->create($request->only($fields));
        }else{
            $this->jobsite->update($request->only($fields),$id);
        }

        return redirect('/jobsites/');
    }

        public function pendingRequest(Request $request)
       {
           if(isset($request['orderby']) && isset($request['sortby'])){

              $data['rows'] = DB::table('request_jobsite')
              ->join('users', 'users.id', 'request_jobsite.user_id')
              ->join('positions', 'positions.id', 'request_jobsite.position_id')
              ->select('users.username', 'request_jobsite.*','positions.title')
              ->orderBy($request['orderby'], $request['sortby'])
              ->paginate(10);
          }
          else{
           $data['rows'] = DB::table('request_jobsite')
           ->join('users', 'users.id', 'request_jobsite.user_id')
           ->join('positions', 'positions.id', 'request_jobsite.position_id')
           ->select('users.username', 'request_jobsite.*','positions.title')
           ->paginate(10);

          }
           return view('dashboard.pendingRequest',$data);
       }

    public function approveRequest(Request $request){

        if($request->action == 1){

            $approve = RequestJobsite::where('id',$request->id)->first();
            $approve->status = 1;
            $approve->save();

            $user_id = $approve->user_id;
            $supervisor = $this->supervisor->getSupervisorId($user_id);
            if($supervisor){
                $this->supervisor->attach($supervisor->id, $approve->jobsite_id);
            }
            
            $employee = $this->employee->getEmployeeId($user_id);
            if($employee){
                $this->employee->attach($employee->id, $approve->jobsite_id);
            }

            $userid = $approve->user_id;
            $message = " have been assigned to a jobsite for ".$approve->jobsite->title;
            $type = SUP_REQ_JOB;
            $supervisorid = Supervisor::where('user_id',$userid)->value('id');
            activity($userid,$message,$type,NULL,$supervisorid,NULL,NULL);

            sendEmail($approve->user_id,EMP_JOBSITE_APPR);
       }else{
            $approve = RequestJobsite::where('id',$request->id)->first();
            $userid = $approve->user_id;
            $supervisor = $this->supervisor->getSupervisorId($userid);
            $employee = $this->employee->getEmployeeId($userid);
            if($supervisor){
              $userid = $approve->user_id;  
              $message = " been declined to a jobsite request";
              $type = SUP_REQ_JOB;
              $supervisorid = Supervisor::where('user_id',$userid)->value('id');
              activity($userid,$message,$type,NULL,$supervisorid,NULL,NULL);
              $approve->delete();
            }
            if($employee){
              $userid = $approve->user_id;  
              $message = " been declined to a jobsite ";
              $type = EMP_REQ_APR;
              $employeeid = Employee::where('user_id',$userid)->value('id');
              activity($userid,$message,$type,$employeeid,NULL,NULL,NULL);
              $approve->delete();
            }

       }
       return redirect()->action('JobsiteController@pendingRequest');

   }
}
