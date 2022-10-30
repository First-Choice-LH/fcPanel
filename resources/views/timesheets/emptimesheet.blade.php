@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Timesheet List</h1>
			<hr/>
		</div>
	</div>
    <div class="white_bg_main">
    <div class="mytable">
	<div class="row">
		<div class="col-lg-12">
            <div class="table-responsive">
                
                <table class="table table-hover table-bordered sortable_table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="">Employee</th>
                            <th scope="col" class="" data-col="date">Date</th>
                            <th scope="col" class="d-none d-md-table-cell" data-col="start">Start</th>
                            <th scope="col" class="d-none d-md-table-cell" data-col="end">End</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($final as $timesheet)
                        <tr>

                            <td scope="row" class="">{{ $timesheet->employee->first_name }}  {{ $timesheet->employee->last_name }}</td>
                            <td scope="row" class="">{{ $timesheet->date }}</td>
                            <td scope="row" class="">{{ $timesheet->start }}</td>
                            <td scope="row" class="">{{ $timesheet->end }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $final->links() }}
               
            </div>
		</div>
	</div>
</div>
</div>
</div>

@endsection

@section('script')

@endsection