<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;

use App\Repository\Contract\UserInterface as UserInterface;

class DashboardController extends Controller
{
    private $request;
    private $user;

    public function __construct(Request $request, UserInterface $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    public function index()
    {
        return view('dashboard.index');
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
