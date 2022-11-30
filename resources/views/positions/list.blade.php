@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Position List</h1>
			<hr/>
		</div>
	</div>
    <div class="white_bg_main">
		<div class="row">
			<div class="col-lg-8"></div>
			<div class="col-lg-4 text-right">
				<a href="{{ url('positions/create') }}" class="btn btnbg btn-success">Create New</a>
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
								<th scope="col" class="d-none d-md-table-cell d-lg-table-cell" width="10%">#</th>
								<th scope="col" class="" data-col="title">Position</th>
								<th scope="col" class="text-center" width="10%">Actions</th>
							</tr>
						</thead>
					  	<tbody>
					  		@foreach($rows as $row)
					  		<tr>
					  			<td class="d-none d-md-table-cell d-lg-table-cell">{{ $i++ }}</td>
					  			<td class="">{{ $row->title }}</td>
					  			<td class="text-center"><a class="btn btnbg btn-sm btn-info" href="{{ url('/positions/update/'.$row->id) }}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a></td>
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