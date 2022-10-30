@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			@if(!isset($row))
			<h1>Create A Job Site</h1>
			@else
			<h1>Update Job Site</h1>
			@endif
			<hr/>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-8 offset-lg-2">	
	<div class="card">
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

			<form role="form" method="post" action="{{ route('jobsites.save') }}" class="card-body">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{ old('id', (isset($row)) ? $row->id : null) }}"/>

				<div class="form-group row">
					<div class="col-lg-6">
						<label for="title">Project Name</label>
						<input type="text" class="form-control" name="title" aria-describedby="title" placeholder="Project Name" value="{{ old('title', (isset($row)) ? $row->title : '') }}" />
					</div>
					<div class="col-lg-6">
						<label for="client_id">Client</label>
						<select class="form-control" name="client_id">
							<option value="">Select Client</option>
							@foreach ($clients as $client)
							<option value="{{ $client->id }}" @if((isset($row) && $row->client->id == $client->id) || (\Request::post('client_id') == $client->id) )selected="selected"@endif>
								{{ $client->company_name }}
							</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-lg-6">
						<label for="address">Address</label>
						<input type="text" class="form-control" name="address" aria-describedby="address" placeholder="Address" value="{{ old('address', (isset($row)) ? $row->address : '') }}" />
					</div>
					<div class="col-lg-6">
						<label for="suburb">Suburb</label>
						<input type="text" class="form-control" name="suburb" aria-describedby="suburb" placeholder="Suburb" value="{{ old('suburb', (isset($row)) ? $row->suburb : '') }}" />
					</div>
				</div>

				<div class="form-group row">
					<div class="col-lg-4">
						<label for="state">State</label>
						<input type="text" class="form-control" name="state" aria-describedby="state" placeholder="State" value="{{ old('state', (isset($row)) ? $row->state : '') }}" />
					</div>
					<div class="col-lg-4">
						<label for="postcode">Post Code</label>
						<input type="text" class="form-control" name="postcode" aria-describedby="postcode" placeholder="Post code" value="{{ old('postcode', (isset($row)) ? $row->postcode : '') }}" />
					</div>
					<div class="col-lg-4">
						<label for="country">Country</label>
						<input type="text" class="form-control" name="country" aria-describedby="country" placeholder="Country" value="{{ old('country', (isset($row)) ? $row->country : '') }}" />
					</div>
				</div>

				<div class="form-group row">
					<div class="col-lg-6">
						<label for="status">Status</label>
						
						<div class="">					
							<button type="button" onClick="setStatus(this, 'status', 0);"  class="btn @if(isset($row) && $row->status == 0) red-btn btn-selected @else red-invert-btn @endif"><i class="fas fa-times"></i></button>						
							<button type="button" onClick="setStatus(this, 'status', 1);"  class="btn @if(isset($row) && $row->status == 1) green-btn btn-selected @else green-invert-btn @endif"><i class="fas fa-check"></i></button>						
							<input type="hidden" id="status" name="status" value="@if(isset($row)) {{ $row->status }} @else 0 @endif"/>														
						</div>
					</div>
					<div class="col-lg-6">
					</div>
				</div>

				<div class="form-group row">
					<div class="col-lg-12 text-right">
						<button type="submit" class="btn btnbg btn-success">Save</button>
					</div>
				</div>
			</form>
			</div>
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
@endsection