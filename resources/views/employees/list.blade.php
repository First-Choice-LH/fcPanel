@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Employee List</h1>
			<hr/>
		</div>
	</div>
    <div class="white_bg_main">

    	<div class="row">
    		<div class="col-lg-4 form-group">
                <input class="form-control" type="text" id="employee" value="{{ app('request')->input('employee') }}">
            </div>
            <div class="col-lg-2 form-group text-center">
                <button type="button" class="btn btnbg btnbig search">Search</button>
            </div>
            <div class="col-lg-3"></div>
    		<div class="col-lg-3 form-group text-center">
    			<a href="{{ url('/employees/create') }}" class="btn btnbg btnbig">Create New</a>
    		</div>
    	</div>

	<?php $i = 1; ?>
	<div class="mytable">
	<div class="row">
		<div class="col-lg-12 table-responsive">
			<table class="table table-hover table-bordered sortable_table">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="d-none d-md-table-cell d-lg-table-cell" width="10%">#</th>
						<th scope="col" class="d-none d-md-table-cell d-lg-table-cell" data-col="first_name">First Name</th>
						<th scope="col" class="" data-col="last_name">Last Name</th>
						<th scope="col" class="" data-col="phone">Phone</th>
						<th scope="col" class="text-center" width="12%">&nbsp;</th>
					</tr>
				</thead>
			  	<tbody>
			  		@foreach($rows as $row)
			  		<tr>
			  			<td class="d-none d-md-table-cell d-lg-table-cell">{{ $i++ }}</td>
			  			<td class="d-none d-md-table-cell d-lg-table-cell">{{ $row->first_name }}</td>
			  			<td class="">{{ $row->last_name }}</td>
			  			<td class="">{{ $row->phone }}</td>
			  			<td class="text-center">
							<div class="dropdown d-block">
								<button type="button" class="btn btnbg btn-sm dropdown-toggle" data-toggle="dropdown">
								Options
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="{{ url('/employees/update/'.$row->id) }}">Edit</a>
									<a class="dropdown-item" href="{{ url('/employees/jobsite/'.$row->id) }}">Sites</a>
								</div>
							</div>
						</td>
		  			</tr>
		  			@endforeach
			  	</tbody>
		  	</table>
		  	{{ $rows->appends(request()->except('page'))->links() }}
		</div>
	</div>
	</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $('.search').click(function(){
        var employee = $('#employee').val();
        var url = "{{ url('/employees/') }}";
        url = url+"?employee="+employee;
        document.location = url;
    });
</script>
@endsection