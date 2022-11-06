<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\Contract\JobsiteInterface as JobsiteInterface;
use App\Client;
use App\Job;
use App\Employee;
use DB;

class ApiController extends Controller
{
    private $jobsite;

    public function __construct(JobsiteInterface $jobsite){
        $this->jobsite = $jobsite;
    }

    public function client_jobsites($id=0){
        $jobsites = $this->jobsite->byClientId($id);
        return $jobsites->toJSON();
    }

    public function getClientDetail(Request $request) {
        $client                 = Client::find($request->get('id'));
        $client->last_updated   = getUserFriendlyDateTime($client->updated_at);
        return response()->json($client);
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

        if($request->get('type') == '1') {
            $jobs->whereNotNull('employee_id');
        } else if($request->get('type') == '2') {
            $jobs->whereNull('employee_id');
        }


        $data = [];
        if( $request->get('calendarView') == true ) {
            $jobs->select(DB::raw('COUNT(id) AS events'), DB::raw('CAST(start_time AS DATE) AS start'), DB::raw('CAST(end_time AS DATE) AS end'), 'employee_id');
            $data   = $jobs->groupBy(DB::raw('CAST(start_time AS DATE)'), DB::raw('CAST(end_time AS DATE)'), 'employee_id')->get();
        } else {
            $data   = $jobs->with(['client', 'jobsite', 'position', 'supervisor', 'employee', 'allocator', 'updater'])->get();
        }

        return response()->json( $data );
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
            $transformedData['results'][] = [
                'id'    => $employee->id,
                'text'  => $employee->first_name.' '.$employee->last_name
            ];
        }

        return response()->json( $transformedData );
    }


    public function encryptProject(){

    }
}
