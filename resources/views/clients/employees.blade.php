@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Job Site Employee List</h1>
			<hr/>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<table class="table table-hover sortable_table">
				<thead>
					<tr>
						<th scope="col" class="text-center" width="10%">#</th>
						<th scope="col" class="text-center">First Name</th>
						<th scope="col" class="text-center">Last Name</th>
						<th scope="col" class="text-center">Phone</th>
						<th scope="col" class="text-center" width="12%">&nbsp;</th>
					</tr>
				</thead>
			  	<tbody>
			  		@foreach($rows as $row)
			  		<tr>
			  			<td class="text-center">{{ $row->id }}</td>
			  			<td class="text-center">{{ $row->first_name }}</td>
			  			<td class="text-center">{{ $row->last_name }}</td>
			  			<td class="text-center">{{ $row->phone }}</td>
			  			<td class="text-center">
						  <a class="btn btnbg btn-sm btn-info" href="{{ url('/clients/jobsites/employees/timesheet/'.$jobsite_id.'/'.$row->id) }}">Time Sheet</a>
						</td>
		  			</tr>
		  			@endforeach
			  	</tbody>
		  	</table>
		  	{{ $rows->links() }}
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">

</script>
@endsection