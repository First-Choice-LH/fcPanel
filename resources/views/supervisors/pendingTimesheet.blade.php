@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
            <h1>Pending Timehseet Request</h1>
			<hr/>
		</div>
	</div>
	<div class="white_bg_main">
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
			<table class="table table-hover table-bordered sortable_table">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="" width="10%">#</th>
						<th scope="col" class="" data-col="first_name">Employee</th>
						<th scope="col" class="" data-col="date">Date</th>
						<th scope="col" class="text-center" width="15%">Status</th>
						<th scope="col" class="text-center" width="15%">&nbsp;</th>
					</tr>
				</thead>
			  	<tbody>
				  <?php $i = 1; 
				if(count($rows)>0){?>
				  @foreach($rows as $row)
				  
                        <tr>
                            <td scope="row" class="d-none d-md-table-cell"><?php echo $i++; ?></td>
                            <td scope="row" class="">{{ $row['first_name'] }}&nbsp;&nbsp;{{ $row['last_name'] }}</td>
                            <td scope="row" class="">{{ $date }}</td>
								@if($row['status'] == 0)
									<td scope="row" class="text-center">Pending</td>
									
								@else
									<td scope="row" class="text-center">Approved</td>
								@endif
							
							<td class="text-center">
								<form method="POST" action="{{ url('/') }}">
										{{ csrf_field() }}
										<a href="/employee/jobsites/timesheet/{{ $row['client_id'] }}/{{ $row['jobsite_id'] }}/{{ $row['emp_id'] }}?date={{ $start }}" target="_blank" class="btn btnbg btnbig">View</a>
								</form>
							</td>
							
                        </tr>
                    @endforeach
                    <?php
                    }else{
                        
                        echo "<tr> <td colspan='5'><center><b>No Record Found</b></center></td></tr>";
                    }
                    ?>
				</tbody>
			</table>
			      {{ $rows->appends(request()->except('page'))->links() }}
			</div>
		</div>
	</div>	
</div>
@endsection