@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			@if(!isset($row))
			<h1>Create A Supervisor</h1>
			@else
			<h1>Update Supervisor</h1>
			@endif
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

			<form role="form" method="post" action="{{ route('supervisors.save') }}" class="card-body">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{ old('id', (isset($row)) ? $row->id : null) }}"/>
		
			<div class="card padall30 mrb30">
				<h4>General Details<hr class="hralignleft"/></h4>

				<div class="form-group row">
					<div class="col-lg-6">
						<label for="first_name">First Name</label>
						<input type="text" class="form-control" name="first_name" aria-describedby="first_name" placeholder="First Name" value="{{ old('first_name', (isset($row)) ? $row->first_name : '') }}" />
					</div>
					<div class="col-lg-6">
						<label for="last_name">Last Name</label>
						<input type="text" class="form-control" name="last_name" aria-describedby="last_name" placeholder="Last Name" value="{{ old('last_name', (isset($row)) ? $row->last_name : '') }}"/>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-lg-6">
						<label for="phone">Phone</label>
						<input type="text" class="form-control" name="phone" aria-describedby="phone" placeholder="Phone" value="{{ old('phone', (isset($row)) ? $row->phone : '') }}" />
					</div>
					<div class="col-lg-6">
						<label for="email">Email</label>
						<input type="text" class="form-control" name="email" aria-describedby="email" placeholder="Email" value="{{ old('email', (isset($row)) ? $row->email : '') }}"/>
					</div>
				</div>
			</div>

			<div class="card padall30 mrb30">
				@if(!isset($row))
				<h4>Login Details<hr class="hralignleft"/></h4>
				<div class="form-group row">
					<div class="col-lg-6">
						<label for="username">Username</label>
						<input type="text" class="form-control" name="username" aria-describedby="username" placeholder="Username" value="{{ old('username', '') }}" />
					</div>
					<div class="col-lg-6"></div>
				</div>
				@endif

				<div class="form-group row">
					<div class="col-lg-6">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" aria-describedby="password" placeholder="Password" value=""/>
					</div>
					<div class="col-lg-6">
						<label for="repassword">Retype Password</label>
						<input type="password" class="form-control" name="repassword" aria-describedby="repassword" placeholder="Retype Password" value=""/>
					</div>
				</div>
			</div>
			
			<div class="card padall30 mrb30">
				<h4>Location<hr class="hralignleft"/></h4>
				<div class="form-group row">				
					<div class="col-lg-6">
						<label for="client_id">Company</label>

						<select name="client_id" class="form-control">
							<option value="">Select Company</option>
							@foreach ($clients as $client)
							<option value="{{ $client->id }}" @if(isset($row) && $row->client_id == $client->id)selected="selected"@endif>
								{{ $client->company_name }}
							</option>
							@endforeach
						</select>
					</div>
					<!--div class="col-lg-6">							
						<input type="hidden" name="jobsite_id" value="0"/>
					</div-->	
					<div class="col-lg-6">
						<label for="status">Status</label>
								
						<div class="">				
							<button type="button" onClick="setStatus(this, 'status', 0);"  class="btn @if(isset($row) && $row->status == 0) red-btn btn-selected @else red-invert-btn @endif"><i class="fas fa-times"></i></button>						
							<button type="button" onClick="setStatus(this, 'status', 1);"  class="btn @if(isset($row) && $row->status == 1) green-btn btn-selected @else green-invert-btn @endif"><i class="fas fa-check"></i></button>						
							<input type="hidden" id="status" name="status" value="@if(isset($row)) {{ $row->status }} @else 0 @endif"/>													
						</div>
					</div>
				</div>	

				<div class="form-group row">
					<div class="col-lg-12 text-right">
						<button type="submit" class="btn btnbg btn-success">Save</button>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
<style>
.red-invert-btn {
	background-color: #f6f6f6;
	color: red;
	border-radius: 0;
	font-size: 24px;
	padding: 8px 20px;
}
.red-btn{
    background-color:red;
    color:#f6f6f6;
	border-radius: 0;
	font-size: 24px;
	padding: 8px 20px;
}
.green-invert-btn{
    background-color:#f6f6f6;
    color:#469408;
	border-radius: 0;
	font-size: 24px;
	padding: 8px 20px;
}
.green-btn{
    background-color:#469408;
    color:#f6f6f6;  
	border-radius: 0;
	font-size: 24px;
	padding: 8px 20px;  
}
</style>
<script type="text/javascript">
function setStatus(me, idName, value){
	if(value == 0){
		$(me).parent().find('button:eq(0)').removeClass('red-invert-btn');
		$(me).parent().find('button:eq(0)').addClass('red-btn');

		$(me).parent().find('button:eq(1)').removeClass('green-btn');
		$(me).parent().find('button:eq(1)').addClass('green-invert-btn');
	}
	if(value == 1){
		$(me).parent().find('button:eq(1)').removeClass('green-invert-btn');
		$(me).parent().find('button:eq(1)').addClass('green-btn');

		$(me).parent().find('button:eq(0)').removeClass('red-btn');
		$(me).parent().find('button:eq(0)').addClass('red-invert-btn');
	}
	$(me).parent().find('button').removeClass('btn-selected');
	$(me).addClass('btn-selected');
	$("#"+idName).val(value);
}
</script>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) {
    $("select[name=client_id]").on('change', function(){
        var client_id = $("select[name=client_id]").val();
        var ajax_get_jobsites_url = "{{ url('/api/client_jobsites/') }}/"+client_id;
        
        $.get(ajax_get_jobsites_url, function(response){
            var jsondata = $.parseJSON(response);
            var html = '<option value="">Select Jobsite</option>';
            for(var i=0; i<jsondata.length; i++)
            {
                html += '<option value="'+jsondata[i].id+'">'+jsondata[i].title+'</option>';
            }

            $("select[name=jobsite_id]").html(html);
        });
	})
});
</script>
@endsection