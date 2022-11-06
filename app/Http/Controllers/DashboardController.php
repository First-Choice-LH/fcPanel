<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;

use App\Repository\Contract\UserInterface as UserInterface;
use App\Repository\Contract\ClientInterface as ClientInterface;
use App\Position;
use App\Employee;
use App\Job;

class DashboardController extends Controller
{
    private $request;
    private $user;
    private $client;

    public function __construct(Request $request, UserInterface $user, ClientInterface $client)
    {
        $this->request = $request;
        $this->user = $user;
        $this->client = $client;
    }

    public function index()
    {
        $data['clients']            = $this->client->dropdown();
        $data['positions']          = Position::all();
        $data['employees']          = Employee::all();
        return view('dashboard.index', $data);
    }

    public function change_password()
    {
        if(!Auth::check()){
            return redirect('/logout');
        }

        return view('dashboard.change_password');
    }

    public function post_change_password()
    {
        if(!Auth::check()){
            return redirect('/logout');
        }

        $validator = Validator::make($this->request->all(),[
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        if($validator->fails()){
            return redirect('/changepassword')
                        ->withErrors($validator)
                        ->withInput();
        }

        $user_id = Auth::user()->id;

        $new_user = $this->user->show($user_id);

        $pass = $this->request->input('password');

        if(!empty($pass)){
            $user_row = array();
            $user_row['password'] = Hash::make($pass);
            $this->user->update($user_row, $new_user->id);
        }

        return redirect('/');
    }
}
