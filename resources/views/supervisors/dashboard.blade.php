@extends('layouts.dore.app')

@section('content')
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Dashboard</h1>
			<hr>
		</div>
	</div>
    <div class="main_dashboard_page">
	<div class="row">
    <div class="col-lg-4">
            <div class="card d-flex flex-row mb-4">
                <a class="d-flex align-self-center" href="#">
                    <i class="dashicon iconsmind-Business-Man" style="padding:25px 15px;font-size:72px;"></i>
                    <!-- <img alt="Profile" src="{{ asset('images/position.png') }}" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center"> -->
                </a>
                <div class=" d-flex flex-grow-1 min-width-zero">
                    <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                        <div class="min-width-zero">
                            <a href="#">
                                <p class="list-item-heading mb-1 truncate">My Account</p>
                            </a>
                            <p class="mb-2 text-muted text-small">Update Account.</p>
                            <div class="bordertop">
                            <a class="btn btnbg" href="{{ url('supervisors/myaccount') }}">Update</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		 <div class="col-lg-4">
            <div class="card d-flex flex-row mb-4">
                <a class="d-flex align-self-center" href="#">
                    <i class="dashicon iconsmind-Business-Man" style="padding:25px 15px;font-size:72px;"></i>
                </a>
                <div class=" d-flex flex-grow-1 min-width-zero">
                    <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                        <div class="min-width-zero">
                            <a href="#">
                                <p class="list-item-heading mb-1 truncate">Activity</p>
                            </a>
                            <p class="mb-2 text-muted text-small">Show Activity.</p>
                            <div class="bordertop">
                            <a class="btn btnbg" href="{{ route('supervisors.activity') }}">View</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>

        <div class="col-lg-4">
            <div class="card d-flex flex-row mb-4">
                <a class="d-flex align-self-center" href="#">
                    <i class="dashicon simple-icon-map" style="padding:25px 15px;font-size:72px;"></i>
                </a>
                <div class=" d-flex flex-grow-1 min-width-zero">
                    <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                        <div class="min-width-zero">
                            <a href="#">
                                <p class="list-item-heading mb-1 truncate">Jobsite</p>
                            </a>
                            <p class="mb-2 text-muted text-small">Show Jobsite.</p>
                            <div class="bordertop">
                            <a class="btn btnbg" href="{{ route('supervisors.jobsites') }}">View</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


		<!-- <div class="col-lg-4">
            <div class="card d-flex flex-row mb-4">
                <a class="d-flex align-self-center" href="#">
                    <i class="dashicon iconsmind-Stopwatch" style="padding:25px 15px;font-size:72px;"></i>
                     <img alt="Profile" src="{{ asset('images/jobsite.png') }}" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">
                </a>
                <div class=" d-flex flex-grow-1 min-width-zero">
                    <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                        <div class="min-width-zero">
                            <a href="#">
                                <p class="list-item-heading mb-1 truncate">Timesheet</p>
                            </a>
                            <p class="mb-2 text-muted text-small">Show Timesheet.</p>
                            <div class="bordertop">
                            <a class="btn btnbg" href="{{ route('supervisors.timesheets') }}">View</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
		</div> -->
		<div class="col-lg-4">
            <div class="card d-flex flex-row mb-4">
                <a class="d-flex align-self-center" href="#">
                    <i class="dashicon iconsmind-Administrator" style="padding:25px 15px;font-size:72px;"></i>
                    <!-- <img alt="Profile" src="{{ asset('images/position.png') }}" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center"> -->
                </a>
                <div class=" d-flex flex-grow-1 min-width-zero">
                    <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                        <div class="min-width-zero">
                            <a href="#">
                                <p class="list-item-heading mb-1 truncate">Employee</p>
                            </a>
                            <p class="mb-2 text-muted text-small">Show Employee</p>
                            <div class="bordertop">
                            <a class="btn btnbg" href="{{ route('supervisors.employee') }}">View</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection