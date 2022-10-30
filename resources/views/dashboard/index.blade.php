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
                    <i class="dashicon iconsmind-Shop-4" style="padding:25px 15px;font-size:72px;"></i>
                    <!-- <img alt="Profile" src="{{ asset('images/company.png') }}" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center"> -->
                </a>
                <div class="d-flex flex-grow-1 min-width-zero">
                    <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                        <div class="min-width-zero">
                            <a href="#">
                                <p class="list-item-heading mb-1 truncate">Company</p>
                            </a>
                            <p class="mb-2 text-muted text-small">Create a new company.</p>
                            <div class="bordertop">
                            <a class="btn btnbg" href="{{ route('clients.create') }}">Create</a>
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
                    <!-- <img alt="Profile" src="{{ asset('images/supervisor.png') }}" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center"> -->
                </a>
                <div class=" d-flex flex-grow-1 min-width-zero">
                    <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                        <div class="min-width-zero">
                            <a href="#">
                                <p class="list-item-heading mb-1 truncate">Supervisor</p>
                            </a>
                            <p class="mb-2 text-muted text-small">Create a new supervisor user.</p>
                            <div class="bordertop">
                            <a class="btn btnbg" href="{{ route('supervisors.create') }}">Create</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-lg-4">
            <div class="card d-flex flex-row mb-4">
                <a class="d-flex align-self-center" href="#">
                    <i class="dashicon iconsmind-Map" style="padding:25px 15px;font-size:72px;"></i>
                    <!-- <img alt="Profile" src="{{ asset('images/jobsite.png') }}" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center"> -->
                </a>
                <div class=" d-flex flex-grow-1 min-width-zero">
                    <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                        <div class="min-width-zero">
                            <a href="#">
                                <p class="list-item-heading mb-1 truncate">Job Site</p>
                            </a>
                            <p class="mb-2 text-muted text-small">Create a new job site.</p>
                            <div class="bordertop">
                            <a class="btn btnbg" href="{{ route('jobsites.create') }}">Create</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-lg-4">
            <div class="card d-flex flex-row mb-4">
                <a class="d-flex align-self-center" href="#">
                    <i class="dashicon iconsmind-Map-Marker" style="padding:25px 15px;font-size:72px;"></i>
                    <!-- <img alt="Profile" src="{{ asset('images/position.png') }}" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center"> -->
                </a>
                <div class=" d-flex flex-grow-1 min-width-zero">
                    <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                        <div class="min-width-zero">
                            <a href="#">
                                <p class="list-item-heading mb-1 truncate">Job Position</p>
                            </a>
                            <p class="mb-2 text-muted text-small">Create a new job position.</p>
                            <div class="bordertop">
                            <a class="btn btnbg" href="{{ route('positions.create') }}">Create</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-lg-4">
            <div class="card d-flex flex-row mb-4">
                <a class="d-flex align-self-center" href="#">
                    <i class="dashicon iconsmind-Administrator" style="padding:25px 15px;font-size:72px;"></i>
                    <!-- <img alt="Profile" src="{{ asset('images/employee.png') }}" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center"> -->
                </a>
                <div class=" d-flex flex-grow-1 min-width-zero">
                    <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                        <div class="min-width-zero">
                            <a href="#">
                                <p class="list-item-heading mb-1 truncate">Employee</p>
                            </a>
                            <p class="mb-2 text-muted text-small">Create a new emplpoyee user.</p>
                            <div class="bordertop">
                            <a class="btn btnbg" href="{{ route('employees.create') }}">Create</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-lg-4">
            <div class="card d-flex flex-row mb-4">
                <a class="d-flex align-self-center" href="#">
                    <i class="dashicon iconsmind-Stopwatch" style="padding:25px 15px;font-size:72px;"></i>
                    <!-- <img alt="Profile" src="{{ asset('images/timesheet.png') }}" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center"> -->
                </a>
                <div class=" d-flex flex-grow-1 min-width-zero">
                    <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                        <div class="min-width-zero">
                            <a href="#">
                                <p class="list-item-heading mb-1 truncate">Timesheet</p>
                            </a>
                            <p class="mb-2 text-muted text-small">View user timesheet.</p>
                            <div class="bordertop">
                            <a class="btn btnbg" href="{{ route('timesheets') }}">View</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
    </div>
</div>
@endsection