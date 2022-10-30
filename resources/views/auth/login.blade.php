@extends('layouts.dore.noauth')

@section('content')
<style type="text/css">
    .social_btn .btnbg::before, .social_btn .btnbg:hover::after{
        display: none;
    }
    .social_btn .btnbg:hover {
        transition: none;
    }
</style>
<div class="row justify-content-center" style="position:relative; top:25%; opacity:0.95;">
    <div class="col-md-5">
        <div class="card logincard">
            <div class="card-body">
                <div class="text-center">
                    <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('dore/img/weblogo.jpg') }}" alt="" width="250px"/></a>
                    <hr/>
                </div>
                @if ($message = Session::get('error'))
                    <div class="clearfix"></div>
                    <div class="alert alert-danger" role="alert" style="">
                        {!! $message !!}
                    </div>
                    <?php Session::forget('error');?>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    <?php Session::forget('success');?>
                @endif

                <form method="POST" action="{{ route('login') }}" id="login_form" aria-label="{{ __('Login') }}">
                    @csrf
                    <div class="form-group row">
                        <!--label for="username" class="col-sm-4 col-form-label text-md-right">{{ __('Username') }}</label-->

                        <div class="col-md-12">
                            <input id="username" type="text" class="form-control form-control_w{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="EMAIL / USERNAME" required autofocus>

                            @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <!--label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label-->

                        <div class="col-md-12">
                            <input id="password" type="password" placeholder="{{ __('PASSWORD') }}" class="form-control form-control_w{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('REMEMBER ME') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('password.request') }}" style="padding-top: 0;padding-right: 0;float: right;">
                                {{ __('FORGOT YOUR PASSWORD?') }}
                            </a>
                        </div>
                    </div>
                    <div class="form-group row desktop_row">
                        <div class="col-md-8 text-left">
                            <a class="btn btnbg btn-primary" href="/employee/create">{{ __('CREATE ACCOUNT') }}</a>
                        </div>
                        
                        <div class="col-md-4 text-right">
                            <button type="submit" id="login_btn" class="btn btnbg btn-primary">
                                {{ __('Login') }}
                            </button>
                        </div>                    
                    </div>
                    <div class="form-group row mobile_row">
                        <div class="col-md-12 text-center" style="margin-bottom: 15px;">
                            <button type="submit" id="login_btn" class="btn btnbg btn-primary">
                                {{ __('Login') }}
                            </button>
                        </div> 
                        <div class="col-md-12 text-center">
                            <a class="btn btnbg btn-primary" href="/employee/create">{{ __('CREATE ACCOUNT') }}</a>
                        </div>                   
                    </div>

                    <div class="form-group row">
                         <div class="col-md-12 text-center">
                            <h3 style="margin: 10px 0;">OR LOGIN WITH</h3>
                         </div>
                    </div>

                    <div class="form-group row">
                       <div class="col-md-12 text-center social_btn">
                           <a href="/login/facebook" class="btn btnbg" style="background: #3B5998; color: white; text-align: center; padding: 10px 15px;">
                               <i class="fab fa-facebook-f" style="font-size: 20px;"></i>
                           </a>
                           <a href="/login/google" class="btn btnbg" style="background: #dd4b39; color: white; text-align: center; padding: 10px;">
                               <i class="fab fa-google" style="font-size: 20px;"></i>
                           </a>
                       </div>
                       
                   </div>
                    

                    <!--div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    </div-->
                </form>
            </div>
        </div>
    </div>
</div>
<!-- <div class="row h-100">
    <div class="col-8 col-md-10 mx-auto my-auto">        
        <div class="row" style="margin:0 auto;">
                <a href="{{ Url('/') }}">
                    <span class="logo-single"></span>
                </a>
                <h6 class="mb-4">Login</h6>
                <form method="post" action="{{ route('login') }}">
                    @csrf
                    <label class="form-group has-float-label">
                        <input id="username" type="text" name="username" class="form-control">
                        <span>Username</span>
                    </label>

                    <label class="form-group has-float-label">
                        <input id="password" type="password" name="password" class="form-control" type="password" placeholder="">
                        <span>Password</span>
                    </label>
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-primary btn-lg btn-shadow" type="submit">LOGIN</button>
                    </div>
                    <div class="d-flex justify-content-between align-items-center" style="margin-top:20px;">                        
                        <a href="{{ route('password.request') }}">I've forgotten my password</a>
                    </div>
                </form>
            </div>
    </div>
</div> -->
<script src="{{ asset('dore/js/vendor/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#login_btn').click(function(e){
            var username = $('#username').val(); 
            if (username.indexOf('@') > -1){
                e.preventDefault();
                $.ajax({
                    type : "GET",
                    url  : "/getUsername/"+username,
                    datatype : "json",
                    success : function(result){
                        $('#login_form').hide();
                        $('#username').val(result);
                        $('#login_form').submit();
                    }
                });
            }
        });
    });
</script>
@endsection
