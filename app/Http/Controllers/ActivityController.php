<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Activity;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Repository\Contract\UserInterface as UserInterface;
use App\Repository\Contract\EmployeeInterface as EmployeeInterface;
use App\Repository\Contract\SupervisorInterface as SupervisorInterface;

class ActivityController extends Controller
{
    private $request;
    private $user;
    private $employee;
    private $supervisor;

    public function __construct(Request $request, UserInterface $user, EmployeeInterface $employee, SupervisorInterface $supervisor)
    {
        $this->request = $request;
        $this->user = $user;
        $this->supervisor = $supervisor;
        $this->employee = $employee;
    }

    public function index()
    {
        $user = Activity::orderBy('id','desc')->paginate(15);
        return view('dashboard.activity',array('user'=>$user));
    }
    public function getEmployeeName(){
       $data = $this->employee->getEmployeeId(Auth::id());
        if($data){
            return $data->first_name.' '.$data->last_name;
        }else{
            return 'Hello user';
        }
    }
    public function getSupervisorName(){
        $data = $this->supervisor->getSupervisorId(Auth::id());      
        return $data->first_name.' '.$data->last_name;
    }
    public function test(Request $request)
    {
       
        
        /*$users = Activity::all();
        foreach ($users as $user) {
            $u = User::find($user->user_id);
            if(!$u){
                $user->delete();
            }
        }
        exit;*/

        try {
            Mail::raw('Hi, welcome user!', function ($message) {
                $message->to('hashcrypthash@gmail.com')
                        //->from('mail@firstchoicelabour.com.au', 'Firstchoice')
                        ->subject('test');
            });
        }catch (Exception $ex) {
            return "We've got errors!";
        }

        if (Mail::failures()) {
            echo "fail";
        }else{
            echo "ss";
        }

        
    }

    

    

    
}
