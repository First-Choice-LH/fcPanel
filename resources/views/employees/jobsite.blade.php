@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Employee Jobsite List</h1>
			<hr/>
		</div>
	</div>
    <div class="white_bg_main">
	<div class="row">
		<div class="col-lg-8"></div>
		<div class="col-lg-4 text-right">
			<a href="{{ url('/employees/jobsites/assign/'.$employee_id) }}" class="btn btnbg">Assign New</a>
			<br/><br/>
		</div>
	</div>
		<div class="mytable">
	<div class="row">
		<div class="col-lg-12 table-responsive">
					<table class="table table-hover table-bordered sortable_table">
						<thead class="thead-dark">
					<tr>
						<th scope="col" class="" width="10%">#</th>
						<th scope="col" class="">Title</th>
						<th scope="col" class="">Company</th>
						<th scope="col" class="text-center" width="20%">&nbsp;</th>
					</tr>
				</thead>
			  	<tbody>
			  		@foreach($rows as $row)
			  		<tr>
			  			<td class="">{{ $row->id }}</td>
			  			<td class="">{{ $row->title }}</td>
			  			<td class="">{{ $row->client->company_name }}</td>
			  			<td class="text-center">
		  				
	  						<a class="btn btnbg btn-sm" href="{{ url('/employees/jobsites/unassign/'.$employee_id.'/'.$row->id) }}">Unassign</a>
		  				
							<a class="btn btnbg btn-sm" href="{{ url('/timesheets/employee/'.$row->id.'/'.$employee_id) }}">Timesheet</a>
						</td>
		  			</tr>
		  			@endforeach
			  	</tbody>
		  	</table>
		</div>
	</div>
</div>
</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
   
</script>
@endsection