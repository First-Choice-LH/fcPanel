@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
            <h1>My Account</h1>
			<hr/>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-8 offset-lg-2">			
			
			@if($errors->any())
				<br/>
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
    
			<form role="form" method="post" action="{{ route('supervisors.Update') }}" class="card-body">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{ old('id', (isset($Record_get)) ? $Record_get->id : null) }}"/>
		
                    <div class="card padall30 mrb30">
                        <h4>General Details<hr class="hralignleft"/></h4>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name" aria-describedby="first_name" placeholder="First Name" value="{{ old('first_name', (isset($Record_get)) ? $Record_get->first_name : '') }}" />
                            </div>
                            <div class="col-lg-6">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" aria-describedby="last_name" placeholder="Last Name" value="{{ old('last_name', (isset($Record_get)) ? $Record_get->last_name : '') }}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" aria-describedby="phone" placeholder="Phone" value="{{ old('phone', (isset($Record_get)) ? $Record_get->phone : '') }}" />
                            </div>
                            <div class="col-lg-6">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" aria-describedby="email" placeholder="Email" value="{{ old('email', (isset($Record_get)) ? $Record_get->email : '') }}"/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card padall30 mrb30">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" aria-describedby="password" placeholder="Password" value=""/>
                            </div>
                            <div class="col-lg-6">
                                <label for="password_confirmation">Retype Password</label>
                                <input type="password" class="form-control" name="password_confirmation" aria-describedby="password_confirmation" placeholder="Retype Password" value=""/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 text-right">
                                <button type="submit" class="btn btnbg btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </div>	
			</form>
		</div>
	</div>
</div>
@endsection