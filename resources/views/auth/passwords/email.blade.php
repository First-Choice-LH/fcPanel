@extends('layouts.dore.app')

@section('content')
    <style type="text/css">
        .btnbg-left.btnbg:hover {
            padding-left: 26px;
            padding-right: 14px;
        }
        .btnbg-left.btnbg::after{
            background-image: url(http://timesheets.firstchoicelabour.com.au/dore/img/left-arrow.png);
            width: 18px;
            left: -20px;
        }
        .btnbg-left.btnbg:hover::after {
            left: 4px;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <h1>{{ __('Reset Password') }}</h1>
        </div>
    </div>    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    

                    <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                        @csrf

                        <p style="font-size: 16px;font-family:'Montserrat', sans-serif;">
                            If you’ve forgotten the email or username you used to sign up with, please <a href="https://www.firstchoicelabour.com.au/contact/"><strong>contact us.</strong></a>
                        </p><br>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('EMAIL / USERNAME') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-4 ">
                                <a href="{{ url('/') }}" class="btn btn-info btnbg btnbg-left">GO BACK</a>
                                <button type="submit" class="btn btn-primary btnbg" id="reset_btn">
                                    {{ __('SEND RESET LINK') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$('#reset_btn').click(function(e){
    var email = $("#email").val();
    if (email.indexOf('@') > -1){
        
    }else{
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "/getUserEmail/"+email,        
            datatype: "JSON",
            success: function (response) {
                $('.card-body').hide();
                $('#email').val(response);
                $('#reset_form').submit();

            },
        });
    }
});
</script>
@endsection
