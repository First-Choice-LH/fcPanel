@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Supervisor List</h1>
			<hr/>
		</div>
	</div>
    <div class="white_bg_main">
	<div class="row">
		<div class="col-lg-8"></div>
		<div class="col-lg-4 text-right">
			<a href="{{ url('/supervisors/create') }}" class="btn btnbg btn-success">Create New</a>
			<br/><br/>
		</div>
	</div>
	<?php $i = 1; ?>
	<div class="mytable">
		<div class="row">
			<div class="col-lg-12 table-responsive">
				<table class="table table-hover table-bordered sortable_table">
					<thead class="thead-dark">
						<tr>
							<th scope="col" class="d-none d-md-table-cell text-center" width="10%">Quick</th>
							<th scope="col" class="d-none d-md-table-cell" data-col="first_name">First Name</th>
							<th scope="col" class="" data-col="last_name">Last Name</th>
							<th scope="col" class="" data-col="phone">Phone</th>
                            <th scope="col" class="">Company Status</th>
							<th scope="col" class="text-center" width="12%">Actions</th>
						</tr>
					</thead>
				  	<tbody>
				  		@foreach($rows as $row)
				  		<tr>
				  			<td class="d-none d-md-table-cell text-center">
								<button class="btn btnbg btn-sm btn-info ml-2 " onclick="viewSupervisorDetails({{ $row->id }})" data-toggle="tooltip" title="View"><i class="fa fa-search-plus"></i></button>
							</td>
				  			<td class="d-none d-md-table-cell">{{ $row->first_name }}</td>
				  			<td class="">{{ $row->last_name }}</td>
				  			<td class="">{{ $row->phone }}</td>
                            <td class="">
                                <?php if($row->status==0){
                                        echo "&#10006;";
                                }
                                else{
                                        echo "Active";
                                }?>
                            </td>
				  			<td class="text-center">
								<a class="btn btnbg btn-sm btn-info" href="{{ url('/supervisors/update/'.$row->id) }}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
								<a class="btn btnbg btn-sm btn-info" href="{{ url('/supervisors/jobsite/'.$row->id) }}" data-toggle="tooltip" title="Sites"><i class="fa fa-building"></i></a>
								<a class="btn btnbg btn-sm btn-info text-white" onclick="showDeletionConfirmation({{ $row->id }})" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
								<!-- <div class="dropdown d-block">
									<button type="button" class="btn btnbg btn-sm dropdown-toggle" data-toggle="dropdown">
									Options
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="{{ url('/supervisors/update/'.$row->id) }}">Edit</a>
										<a class="dropdown-item" href="{{ url('/supervisors/jobsite/'.$row->id) }}">Sites</a>
									</div> -->
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
   
</script>
@endsection