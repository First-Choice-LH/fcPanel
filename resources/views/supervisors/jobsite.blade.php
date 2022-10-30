@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Supervisor Jobsite List</h1>
			<hr/>
		</div>
	</div>
    <div class="white_bg_main">
		<div class="row">
			<div class="col-lg-8"></div>
			<div class="col-lg-4 text-right">
				<a href="{{ url('/supervisors/jobsites/assign/'.$supervisor_id) }}" class="btn btnbg btn-success">Assign New</a>
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
			  						<a class="btn btnbg btn-sm btn-success" href="{{ url('/supervisors/jobsites/unassign/'.$supervisor_id.'/'.$row->id) }}">Unassign</a>
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