<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repository\Contract\JobsiteInterface as JobsiteInterface;
use App\Repository\Contract\EmployeeInterface as EmployeeInterface;
use App\Client;
use App\Job;
use App\Employee;
use App\ClientDocument;
use App\Jobsite;
use App\ClientPositionRate;
use App\Supervisor;
use App\ClientNote;
use App\EmployeeNote;
use App\EmployeePosition;
use DB;
use Auth;

class ApiController extends Controller
{
    private $jobsite;
    private $employee;

    public function __construct(JobsiteInterface $jobsite, EmployeeInterface $employee){
        $this->jobsite  = $jobsite;
        $this->employee = $employee;
    }

    public function client_jobsites($id=0){
        $jobsites = $this->jobsite->byClientId($id);
        return $jobsites->toJSON();
    }

    public function getClientDetail(Request $request) {
        $client                 = Client::with('jobsites', 'supervisors.jobsites', 'documents.docType')->find($request->get('id'));
        $positionRates          = ClientPositionRate::where('client_id', $request->get('id'))->with('position')->get();

        $client->position_rates = $positionRates;

        $notes                  = ClientNote::where('client_id', $request->get('id'))->with('userInfo')->get();
        $formattedNotes         = [];

        foreach($notes as $note) {
            $formattedNotes[]   = [
                'id'        => $note->id,
                'note'      => $note->note,
                'user'      => $note->userInfo->name,
                'created_at'=> getUserFriendlyDateTime($note->created_at),
            ];
        }

        $client->notes          = $formattedNotes;

        $client->last_updated   = getUserFriendlyDateTime($client->updated_at);
        return response()->json($client);
    }

    public function removeClient(Request $request) {
        // DB::beginTransaction();
        Client::find($request->get('clientId'))->delete();
        // ClientDocument::where('client_id', $request->get('clientId'));
        return response()->json('Company record deleted succcessfully!');
    }

    public function updateClientNotes(Request $request) {

        $validator = Validator::make($request->all(), [
            'clientId'      => 'required',
            'notes'         => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        Client::find($request->get('clientId'))->update(['notes' => $request->get('notes')]);

        return response()->json('Company notes updated successfully!');
    }

    public function getJobs(Request $request) {

        $jobs           = Job::where([]);

        if($request->get('dated')) {
            $dated      = urldecode($request->get('dated'));
            $jobs->whereDate('start_time', $dated);
        }

        if($request->get('startDate') && $request->get('endDate')) {
            $jobs->where(function($query) use($request) {
                $endDate            = $request->get('endDate') ? $request->get('endDate') : date("Y-m-t", strtotime($request->get('endDate')));

                $query->whereBetween('start_time', [$request->get('startDate'), $endDate]);
                $query->whereBetween('end_time', [$request->get('startDate'), $endDate]);
            });
        }

        if($request->get('status') != '') {
            $jobs->where('status', $request->get('status'));
        }


        $data = [];
        if( $request->get('calendarView') == true ) {
            $jobs->select(DB::raw('COUNT(id) AS events'), DB::raw('CAST(start_time AS DATE) AS start'), DB::raw('CAST(end_time AS DATE) AS end'), 'status');
            $data   = $jobs->groupBy(DB::raw('CAST(start_time AS DATE)'), DB::raw('CAST(end_time AS DATE)'), 'status')->get();
        } else {
            $data   = $jobs->with(['client', 'jobsite', 'position', 'supervisor', 'employee', 'allocator', 'updater'])->get();
        }

        return response()->json( $data );
    }

    public function getJobDetail(Request $request) {
        $job                    = Job::find($request->get('id'));
        // $job->updated_at        = getUserFriendlyDateTime($job->updated_at);
        return response()->json($job);
    }

    public function getJobsites(Request $request) {
        $jobsites    = Jobsite::where('client_id', $request->get('clientId'))->get();
        return response()->json( $jobsites );
    }

    public function getSupervisors(Request $request) {
        $supervisorIds     = [];
        if($request->get('jobsiteId')) {
            $supervisorRelations   = DB::table('jobsite_supervisor')->where('jobsite_id', $request->get('jobsiteId'))->get();
            foreach($supervisorRelations as $relation) {
                $supervisorIds[]    = $relation->supervisor_id;
            }

            $supervisors    = Supervisor::find($supervisorIds);

        } else{
            $supervisors    = Supervisor::all();
        }

        return response()->json( $supervisors );
    }

    public function createJob(Request $request) {

        $validator = Validator::make($request->all(), [
            'client_id'     => 'required',
            'jobsite_id'    => 'required',
            'supervisor_id'    => 'required',
            'start_date'    => 'required',
            'position_id'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $jobData                = $request->only('client_id', 'jobsite_id', 'supervisor_id', 'position_id', 'comments');


        $jobData['start_time']  = $request->get('start_date');
        $jobData['end_time']    = $request->get('start_date');

        Job::create($jobData);
        return response()->json( $jobData );
    }

    function getEmployees(Request $request) {

        $conditions         = [];
        $data               = [];
        $transformedData    = ["results" => []];

        $employees      = Employee::select('id', 'first_name', 'last_name', 'position_id');

        if( $request->get('position') ) {
            $employees->where('position_id', $request->get('position'));
        }

        if( $request->get('q') ) {
            $employees->where(function($query) use($request) {
                $query->where('first_name', 'like', $request->get('q') . '%');
                $query->orWhere('last_name', 'like', $request->get('q'). '%');
                $query->orWhere('phone', $request->get('q'));
            });
        }

        $data   = $employees->get();

        // transform data for jquery autocomplete
        foreach($data as $employee) {
            $dataRow        = [
                'id'    => $employee->id,
                'text'  => $employee->first_name.' '.$employee->last_name
            ];
            // Need to return job id with employees when searched against a job (to handle job assignment from frontend)
            if( $request->get('job') ) {
                $dataRow['jobId']   = $request->get('job');
            }

            $transformedData['results'][] = $dataRow;
        }

        return response()->json( $transformedData );
    }


    public function removeClientDocument(Request $request) {

        $document = ClientDocument::where([
            'id'        => $request->get('docId'),
            'client_id' => $request->get('clientId')
        ])->first();

        $isDeleted      = false;

        if($document) {
            $isDeleted = $document->delete();

            if($isDeleted) @unlink(public_path('/dore/client/'.$document->doc_name));
        }

        return response()->json($isDeleted);
    }

    public function getEmployeeDetail(Request $request) {
        $employee                       = Employee::with('jobsites', 'documents')->find($request->get('id'));
        $employeePositions              = EmployeePosition::where('employee_id', $request->get('id'))->with('position')->get();

        $employee->employee_positions   = $employeePositions;

        $notes                          = EmployeeNote::where('employee_id', $request->get('id'))->with('userInfo')->get();
        $formattedNotes                 = [];
        foreach($notes as $note) {
            $formattedNotes[]   = [
                'id'        => $note->id,
                'note'      => $note->note,
                'user'      => $note->userInfo->name,
                'created_at'=> getUserFriendlyDateTime($note->created_at),
            ];
        }

        $employee->notes                = $formattedNotes;
        $employee->last_updated         = getUserFriendlyDateTime($employee->updated_at);
        return response()->json($employee);
    }

    public function addEmployee(Request $request) {

        $validator = Validator::make($request->all(), [
            'first_name'    => 'required',
            'phone'         => 'required',
            'position_id'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $employeeData   = $request->only('first_name', 'last_name', 'phone', 'position_id');
        DB::beginTransaction();

        $employee = $this->employee->create($employeeData);
        $message = "created by Admin";
        $type = EMP_PROFILE;
        activity(1, $message, $type, $employee->id, NULL, NULL, NULL);

        DB::commit();
        return response()->json('Employee added successfully');
    }

    public function assignJobToEmployee(Request $request) {
        if(!$request->get('empId')) {
            return response()->json('Employee information is missing from the request');
        } else if(!$request->get('jobId')) {
            return response()->json('Job information is missing from the request');
        }

        $updated = Job::find( $request->get('jobId') )->update([
            'employee_id'   => $request->get('empId'),
            'status'        => '1'
        ]);

        return response()->json($updated);
    }
}
