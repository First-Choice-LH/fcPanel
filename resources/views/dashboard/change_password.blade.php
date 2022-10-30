@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Change Password</h1>
			<hr>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-4 card mx-auto">			
			
			@if($errors->any())
				<br/><br/>
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif

            <form role="form" method="post" action="{{ route('savechangepassword') }}" class="card-body">
                @csrf
                <div class="form-group row">				
					<div class="col-lg-12">
						<label for="password">New Password</label>
						<input class="form-control" type="password" name="password" value="{{ old('password') }}"/>
					</div>
					<div class="col-lg-12">							
						<label for="repassword">Retype Password</label>
						<input class="form-control" type="password" name="password_confirmation" value="{{ old('password_confirmation') }}"/>
					</div>	
				</div>	
                <div class="form-group row">
					<div class="col-lg-12 text-center">							
                        <button type="submit" class="btn btnbg fontbtnbig">SEND RESET LINK</button>
					</div>	
				</div>	
            </form>
        </div>
    </div>
</div>
@endsection