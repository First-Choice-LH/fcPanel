<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Socialite;
use Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function username(){
        return 'username';
    }
    public function getUsername(Request $request){
       $obj = User::where('email',$request['email'])->first();
       if($obj){
           return response()->json($obj->username);
        }else{
           return response()->json($request['email']);
        }
   }
   public function getUserEmail(Request $request){
       $obj = User::where('username',$request['username'])->first();
       if($obj){
           return response()->json($obj->email);
        }else{
           return '';
        }
   }
    public function socialLogin($social){
        return Socialite::driver($social)->redirect();
    }
  
    public function handleProviderCallback($social){
        try{
            $userSocial = Socialite::driver($social)->user();
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['username', $e->getMessage()]);
        }
        
        Log::debug('Social callback');
        Log::debug($userSocial->getEmail());

        if($userSocial->getEmail() == ''){
            \Session::put('error', "We don't have enough permission to access your email address.");
            return redirect('/login');
        }

        $user = User::where(['email' => $userSocial->getEmail()])->first();
        if($user){
            Auth::login($user);
            return redirect('/');
        }else{
            $user  = [
                'social' => $social,
                'name' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'username' => $userSocial->getId(),
                'password' => '',
            ];
            return redirect($social.'/account?name='.$user['name'].'&email='.$user['email'].'&username='.$user['username'].'&password='.$user['password']);
        }
    }
    public function authenticated(Request $request, $user){
        if ($user->status == 0) {
            auth()->logout();
            return back()->with('error', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        return redirect()->intended($this->redirectPath());
    }
}
