@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Activities</h1>
			<hr/>
		</div>
	</div>
    <div class="white_bg_main">
    	<div class="row">
    		<div class="col-lg-12 table-responsive">
    			<table class="table table-hover">
    				<thead class="thead-dark">
    					<tr>
    						<th scope="col" class="text-center" data-col="message">Activity</th>
                            <th scope="col" class="text-center" data-col="message">Jobsite Address</th>
                            <th scope="col" class="text-center" data-col="created_at">Time</th>
                            <th scope="col" class="text-center"></th>
    					</tr>
    				</thead>
    			  	<tbody>
    			  		@foreach($rows as $row)
        			  	<tr>
                            @php ($obj = getActivity($row))
                            <td class="text-center">{{ $obj['name'].' '.$row->message }}</td>
                            <td class="text-center">{{ isset($obj['address']) ? $obj['address'] : '' }}</td>
                            <td scope="col" class="text-center" data-col="created_at">{{ $row->created_at }}</td>
                            <td><a class="btn btnbg" href={{ $obj['url'] }}>VIEW</button></a>
                        </tr>
    		  			@endforeach
    			  	</tbody>
    		  	</table>
                {{ $rows->links() }}
    		</div>
    	</div>
    </div>
</div>
@endsection

