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
        @if(isset($rows) && count($rows)>0)
    	<div class="row">
    		<div class="col-lg-12 table-responsive">
    			<table class="table table-hover sortable_table ">
    				<thead class="thead-dark">
    					<tr>
    						<th scope="col" class="text-center" width="10%">#</th>
    						<th scope="col" class="text-center" data-col="title">Title</th>
    						<th scope="col" class="text-center">Company</th>
    						<th scope="col" class="text-center" width="15%">&nbsp;</th>
    					</tr>
    				</thead>
    			  	<tbody>
    			  		@foreach($rows as $row)
                         <tr>
                             <td class="text-center">{{ $row['id'] }}</td>
                             <td class="text-center">{{ $row['title'] }}</td>
                             <td class="text-center">{{ $row['company_name'] }}</td>
                             <td class="text-center">
                               <a class="btn btnbg btn-sm btn-success" href="{{ url('/supervisors/jobsites/employees/'.$row['client_id'].'/'.$row['id']) }}">Employees</a>
                           </td>
                         </tr>
                         @endforeach
    			  	</tbody>
    		  	</table>
                   {{ $rows->appends(request()->except('page'))->links() }}
    		</div>
    	</div>
        @else
        <div class="row">
            <div class="col-md-12">
                <h3>{{'There are no jobsites or companies assigned to your account yet.'}}</h3>
            </div>
                <div class="col-md-4"><a class="btn btnbg btn-primary" href="/supervisors/jobsites/request">{{ __('REQUEST JOBSITE') }}</a></div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
   
</script>
@endsection