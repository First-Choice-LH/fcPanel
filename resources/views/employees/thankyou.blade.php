@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Thank You!</h1>
			<hr/>
		</div>
	</div>
</div>
	<div class="row">
		<div class="col-lg-12 text-center">
            <div class="jumbotron">
                <h3>Thank You</h3>
                <p>You have submitted your timesheet for the week {{ $start->format('d/m/Y') }} – {{ $end->format('d/m/Y') }}</p>
                <a class="btn btnbg btn-info" href="{{ route('employees.jobsites') }}">Return to Jobsite list</a>
            </div>            
        </div>
	</div>