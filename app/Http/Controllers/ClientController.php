<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Repository\Contract\UserInterface as UserInterface;
use App\Repository\Contract\ClientInterface as ClientInterface;
use App\Repository\Contract\JobsiteInterface as JobsiteInterface;
use App\Repository\Contract\EmployeeInterface as EmployeeInterface;
use App\Repository\Contract\TimesheetInterface as TimesheetInterface;
use App\Http\Requests\ClientRequest as ClientRequest;
use Illuminate\Support\Facades\Validator;
use App\Client;
use App\ClientDocType;
use App\ClientDocument;
use App\ClientPositionRate;
use App\ClientNote;
use App\Position;
use Carbon\Carbon;

class ClientController extends Controller
{
    //
    private $request;
	private $user;
    private $client;
    private $employee;
    private $jobsite;
    private $timesheet;

    public function __construct(Request $request, ClientInterface $client,
        UserInterface $user, JobsiteInterface $jobsite,
        EmployeeInterface $employee, TimesheetInterface $timesheet)
    {
        $this->middleware('auth');

        $this->request = $request;
    	$this->user = $user;
        $this->client = $client;
        $this->employee = $employee;
        $this->jobsite = $jobsite;
        $this->timesheet = $timesheet;

    }

    public function index(Request $request)
    {
        if(isset($request['orderby']) && isset($request['sortby'])){
            $data['rows'] = client::orderBy($request['orderby'], $request['sortby'])->paginate(15);
        }
        else{
            $data['rows'] = client::paginate(15);
        }
        return view('clients.list',$data);
    }

    public function create()
    {
        $data['documentTypes']  = ClientDocType::all();

        $positions              = Position::where('status', 1)->get();
        $data['positions']      = [];
        foreach($positions as $position) {
            $data['positions'][] = [
                'id'            => $position->id,
                'label'         => $position->title
            ];
        }

        $data['positions']      = json_encode($data['positions']);
        $data['positionRates']  = json_encode([]);
        return view('clients.create', $data);
    }

    public function update($id)
    {
        $data = [];
        $data['documentTypes']  = ClientDocType::all();
        $data['row']            = $this->client->show($id);
        $data['documents']      = ClientDocument::where('client_id',$id)->get();
        $positions              = Position::where('status', 1)->get();
        $data['positions']      = [];
        foreach($positions as $position) {
            $data['positions'][] = [
                'id'            => $position->id,
                'label'         => $position->title
            ];
        }

        $data['positions']      = json_encode($data['positions']);

        $data['positionRates']  = ClientPositionRate::where('client_id', $id)->with('position')->get()->toArray();
        $data['notes']          = ClientNote::where('client_id', $id)->with('userInfo')->orderBy('created_at', 'DESC')->get();

        $data['positionRates']  = json_encode($data['positionRates']);

        return view('clients.create', $data);
    }

    public function save(ClientRequest $request)
    {
        $id = $request->input('id');

        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'office_address' => 'required',
            'state' => 'required',
            'country' => 'required',
            'email' => 'required|email|unique:clients'. ($id ? (',email,'.$id) : '')
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $fields = [
            'company_name',
            'company_abn',
            'office_address',
            'suburb',
            'state',
            'country',
            'postcode',
            'office_phone',
            'email',
            'accounts_contact',
            'accounts_email',
            'accounts_phone',
            'status'
        ];

        $client_row                     = $request->only($fields);

        $rateFields     = $request->only('position_id', 'charge_rate');


        // $client_row['document']         = $documentName;

        $client_row['user_id'] = $id;//$new_user->id;

        if($id == null){
            $client = $this->client->create($client_row);
            $id     = $client->id;
        }else{
            $this->client->update($client_row, $id);
        }

        // Delete previous entries, add new ones
        ClientPositionRate::where('client_id', $id)->delete();

        foreach($rateFields['position_id'] as $index => $value) {
            if(!$value) continue;

            ClientPositionRate::create([
                'client_id'     => $id,
                'position_id'   => $value,
                'rate'          => $rateFields['charge_rate'][$index]
            ]);
        }

        // Save note if any
        if( $request->get('notes') ) {
            ClientNote::create([
                'client_id'     => $id,
                'note'          => $request->get('notes'),
                'added_by'      => Auth::user()->id
            ]);
        }

        $existingDocuments = ClientDocument::where('client_id', $id)->pluck('id')->toArray();

        if(isset($request['document_file'])) {
            foreach($request['document_file'] as $key => $document) {

                if(isset($request['document_id'][$key])){
                    $doc = ClientDocument::find($request['document_id'][$key]);
                    if (($key2 = array_search($request['document_id'][$key], $existingDocuments)) !== false) {
                        unset($existingDocuments[$key2]);
                    }
                }else{
                    $doc = new ClientDocument;
                }

                $file = $request['document_file'][$key];

                if($file) {
                    $fileName = strtotime(Carbon::now()).'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('/dore/client'), $fileName);

                    if(!empty($doc->doc_name) && file_exists(public_path('/dore/client/'.$doc->doc_name)) ) {
                        unlink(public_path('/dore/client/'.$doc->doc_name));
                    }
                }else{
                    $fileName = isset($doc->doc_name) ? $doc->doc_name : '';
                }

                $doc->client_id     = $id;
                $doc->doc_type_id   = $request['doc_type_id'][$key];
                $doc->other_type    = $request['type_other'][$key];
                $doc->doc_name      = $fileName;
                $doc->save();
            }
        }


        /*end*/

        return redirect('/clients/');
    }

    public function jobsites()
    {
        $client = $this->client->getClientId(Auth::id());
        $client_id = $client->id;

        $data = [];
        $data['client_id'] = $client_id;

        $data['rows'] = $this->client->paginateByClient($client_id);

        return view('clients.jobsites', $data);
    }

    public function employees($jobsite_id=0)
    {
        $client = $this->client->getClientId(Auth::id());
        $client_id = $client->id;

        $data = [];
        $data['client_id'] = $client_id;
        $data['jobsite_id'] = $jobsite_id;

        $data['rows'] = $this->client->paginateByJobsite($client_id, $jobsite_id);

        return view('clients.employees', $data);
    }

    public function timesheet($jobsite_id=0,$employee_id=0)
    {
        $client = $this->client->getClientId(Auth::id());
        $client_id = $client->id;

        $data = [];

        $data['client_id'] = $client_id;
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

        $data['previousWeek'] = url('/clients/jobsites/employees/timesheet/'.$jobsite_id.'/'.$employee_id.'/?date='.$previousWeek->format("Y-m-d"));
        $data['nextWeek'] = url('/clients/jobsites/employees/timesheet/'.$jobsite_id.'/'.$employee_id.'/?date='.$nextWeek->format("Y-m-d"));

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

        return view('clients.timesheet', $data);
    }

    public function timesheet_save()
    {
        $client = $this->client->getClientId(Auth::id());
        $client_id = $client->id;

        $employee_id = $this->request->input('employee_id');
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
            $row['break'] = (bool) $break[$i];
            $row['status'] = $status[$i];

            if($id == null)
            {
                $this->timesheet->create($row);
            }else{
                $this->timesheet->update($row,$id);
            }
        }

        return redirect('/clients/jobsites/employees/'.$jobsite_id);

    }
}
