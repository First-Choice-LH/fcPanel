@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Jobsite List</h1>
			<hr/>
		</div>
	</div>
    <div class="white_bg_main">
		<div class="row">
			<div class="col-lg-8"></div>
			<div class="col-lg-4 text-right">
				<a href="{{ url('jobsites/create') }}" class="btn btnbg btn-success">Create New</a>
				<br/><br/>
			</div>
		</div>
		<div class="mytable">
			<div class="row">
				<div class="col-lg-12">
					<table class="table table-hover table-bordered sortable_table">
						<thead class="thead-dark">
							<tr>
								<th scope="col" class="d-none d-md-table-cell" width="10%">#</th>
                                <th scope="col" class="d-none d-md-table-cell" data-col="company_name">Company</th>
								<th scope="col" class="" data-col="address">JOBSITE ADDRESS</th>
                                <th scope="col" class="">Status</th>
								<th scope="col" class="" width="10%">&nbsp;</th>
							</tr>
						</thead>
					  	<tbody>
                          <?php $i=1; ?>
                              @foreach($rows as $row)
                              <tr>
                                  <td class="d-none d-md-table-cell">{{ $i++ }}</td>
                               <td class="d-none d-md-table-cell">{{ $row->company_name }}</td>
                                  <td class="">{{ $row->address }}</td>
                                  
                               <td class="">
                                   <?php if($row->status==0){
                                           echo "&#10006;";
                                   }
                                   else{
                                           echo "Active";
                                   }?>
                               </td>
                                  <td class="text-center"><a class="btn btnbg btn-sm btn-info" href="{{ url('/jobsites/update/'.$row->id) }}">EDIT</a></td>
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