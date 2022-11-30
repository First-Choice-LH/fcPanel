@extends('layouts.dore.app')

@section('content')

<style>
    #calendar {
        max-width: 80%;
        margin: auto;
    }
    .modal.show .modal-dialog{
        max-width: 90% !important;
    }
    .fc td:first-of-type, .fc th:first-of-type {
        border-bottom: unset;
        border: 1px solid #ccc;
    }
    ul.ui-autocomplete {
        z-index: 1050;
    }
    .no-results-element{
        cursor: pointer;
    }
    .select2-results__message:has(.no-results-element:hover){
        background: #eee;
    }
    .select2-selection__placeholder, .select2-selection__rendered {
        padding-left: 2px !important;
    }
    .select2-selection__clear {
        margin-right: 9px;
    }
    .select2-container .select2-selection--single {
        height: 54px;
        padding-left: 5px;
        padding-top: 12px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 12px;
    }
</style>

<!-- <div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Calendar</h1>
			<hr>
		</div>
	</div> -->
    <div class="main_dashboard_page">
	{{-- <div class="row">
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
	</div> --}}

    <div id='calendar'></div>

    <div class="modal fade" id="aJobsModal" tabindex="-1" role="dialog" aria-labelledby="aJobsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="aJobsModalLabel">Allocated Jobs</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-bordered table-responsive-sm">
                    <thead>
                        <tr>
                            <th class="d-none d-md-table-cell" width="10%">Client</th>
                            <th class="d-none d-md-table-cell" width="10%">Jobsite</th>
                            <th width="8%">Contact Name</th>
                            <th width="8%">Contact Number</th>
                            <th width="8%">Employee</th>
                            <th width="6%">Employee Number</th>
                            <th width="8%">Allocated By</th>
                            <th width="8%">Edited By</th>
                            <th width="6%">Time Entered</th>
                            <th width="5%">Comments</th>
                            <th width="5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="aJobsTableBody">
                        <tr id="aJobsLoading">
                            <td colspan="11" class="alert alert-warning text-center"><i class="fa fa-2x fa-spinner fa-pulse"></i></td>
                        </tr>
                        <tr class="d-none" id="aJobsNoResults">
                            <td colspan="11" class="text-center"><em>No result found</em></td>
                        </tr>
                        <tr class="allocated-jobs-data d-none">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btnbg btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uJobsModal" role="dialog" aria-labelledby="uJobsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-danger" id="uJobsModalLabel">Unallocated Jobs</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-bordered table-responsive-md text-center">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Jobsite</th>
                                <th>Contact Name</th>
                                <th>Contact Number</th>
                                <th>Position Requested</th>
                                <th>Time Entered</th>
                                <th>Comments</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="uJobsTableBody">
                            <tr id="uJobsLoading">
                                <td colspan="10" class="alert alert-warning text-center">
                                    <i class="fa fa-2x fa-spinner fa-pulse"></i>
                                </td>
                            </tr>
                            <tr class="d-none" id="uJobsNoResults">
                                <td colspan="10"><em>No result found</em></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btnbg btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="requestJobModal" tabindex="-1" role="dialog" aria-labelledby="requestJobModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="jobRequestForm">
                    <input type="hidden" id="startDate" name="start_date" />
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Job On <span id="requestJobDateContainer"></span></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="clientId">Client</label>
                                <select class="form-control select2 client-dropdown" name="client_id" id="clientId">
                                    <option value="">-Select-</option>
                                    @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" @if((isset($row) && $row->client->id == $client->id) || (\Request::post('client_id') == $client->id) )selected="selected"@endif>
                                        {{ $client->company_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="jobsiteId">Job Site</label>
                                <select class="form-control jobsite-dropdown" name="jobsite_id" id="jobsiteId">
                                    <option value="">-Select Job Site-</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="supervisorId">Supervisor</label>
                                <select class="form-control supervisor-dropdown" name="supervisor_id" id="supervisorId">
                                    <option value="">-Select Supervisor-</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="requestPosition">Position Requested</label>
                                <select class="form-control select2" name="position_id">
                                    <option value="">Select</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">
                                            {{ $position->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="comments">Comments</label>
                                <textarea class="form-control" placeholder="Any special notes?"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btnbg btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btnbg btn-sm btn-primary">Add Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editJobModal" tabindex="-1" role="dialog" aria-labelledby="editJobModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="jobRequestForm">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Job</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Client</label>
                                <select class="form-control select2 client-dropdown" name="client_id">
                                    <option value="">-Select-</option>
                                    @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" @if((isset($row) && $row->client->id == $client->id) || (\Request::post('client_id') == $client->id) )selected="selected"@endif>
                                        {{ $client->company_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Job Site</label>
                                <select class="form-control jobsite-dropdown" name="jobsite_id" id="jobsiteId">
                                    <option value="">-Select Job Site-</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="address">Supervisor</label>
                                <select class="form-control supervisor-dropdown" name="supervisor_id">
                                    <option value="">-Select Supervisor-</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="position_id">Position Requested</label>
                                <select class="form-control select2 position-dropdown" name="position_id">
                                    <option value="">Select</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">
                                            {{ $position->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="comments">Comments</label>
                                <textarea class="form-control comments-field" placeholder="Any special notes?"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btnbg btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btnbg btn-sm btn-primary">Add Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="quickAddEmployeeForm">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title" id="addEmployeeModalLabel"><i class="fa fa-user" aria-hidden="true"></i> Quick Add Employee</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="emp_first_name" placeholder="First Name" value="{{ old('first_name', (isset($row)) ? $row->first_name : '') }}" />
                            </div>
                            <div class="col-lg-6">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="emp_last_name" placeholder="Last Name" value="{{ old('last_name', (isset($row)) ? $row->last_name : '') }}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" id="emp_phone" placeholder="Phone" value="{{ old('phone', (isset($row)) ? $row->phone : '') }}" />
                            </div>
                            <div class="col-lg-6">
                                <label for="position">Position</label>
                                <select name="position_id" id="emp_position_id" class="form-control">
                                    <option value="">Select Position</option>
                                    @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">
                                        {{ $position->title }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="mr-auto"><a href="javascript:closeEmployeePopupAndRedirect();" title="Open employee form in new tab" class="alert-link text-info">Add complete information</a></div>
                        <button type="button" class="btn btnbg btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btnbg btn-sm btn-primary">Quick Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    </div>

</div>
@endsection

@section('script')

<script type="text/javascript">

    var employees = [];
    @foreach($employees as $employee)
        employees.push({
            value           : {{ $employee->id }},
            label           : '{{ $employee->first_name.' '.$employee->last_name }}',
            positionId      : '{{ $employee->position_id }}'
        });
    @endforeach

    var calendar;
    $(function() {
        var eventsSource = {
            textColor: 'white'
        };

        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            initialView: 'dayGridMonth',
            firstDay: 1,
            allowClear: true,
            eventSources: loadCalendarEvents,
            eventClick: function(info) {
                const startDate = info.event.startStr;
                loadJobs(info.event.extendedProps.status, startDate);

                if(info.event.extendedProps.status == 1) {
                    $('#aJobsModal').modal('show');
                } else {
                    $('#uJobsModal').modal('show');
                }
            },
            dateClick: function(info) {
                showAddJobModal(info.dateStr);
            }
        });

        calendar.render();

        function loadCalendarEvents(info, resolve, reject) {

            const startDate     = moment(info.start).format('YYYY-MM-DD');
            const endDate       = moment(info.end).format('YYYY-MM-DD');

            $.get(`${BASE_URL}/api/jobs`, { startDate, endDate, calendarView: true }, function(response) {
                let events = [];
                for(let job of response) {
                    let title = job.status == 1 ? `Allocated Jobs(${job.events})` : `Unallocated Jobs(${job.events})`
                    events.push({
                        title           : title,
                        start           : job.start,
                        extendedProps   : {
                            status: job.status
                        },
                        color   : job.status == 1 ? 'green' : 'red',
                    });
                }

                resolve(events);
            });
        }

        function loadJobs(status, dated) {
            $.get(`${BASE_URL}/api/jobs`, { status, dated : encodeURIComponent(dated)}, function(response) {
                populateJobs(status, response);
            });
        }

        function populateJobs(status, response) {

            const namingPrefix  = status == '1' ? 'a' : 'u';

            var tableBody = document.getElementById(`${namingPrefix}JobsTableBody`);
            // Remove all rows after first two (loading and no results)
            while (tableBody.childNodes.length > 2) {
                tableBody.removeChild(tableBody.lastChild);
            }

            $(`#${namingPrefix}JobsLoading`).hide();

            let markup  = '';
            for(let row of response) {

                markup += `<tr>
                    <td>${row.client.company_name}</td>
                    <td>${row.jobsite.title}</td>
                    <td>${row.supervisor.first_name} ${row.supervisor.last_name}</td>
                    <td>${row.supervisor.phone}</td>`;

                if( status == 1 ) {
                    markup += `<td>${row.employee.first_name} ${row.employee.last_name}</td>`;
                    markup += `<td>${row.employee.phone}</td>`;
                    markup += `<td>${row.allocator ? row.allocator.name : ''}</td>`;
                    markup += `<td>${row.updater ? row.updater.name : ''}</td>`;
                } else {
                    markup += `<td>${row.position.title}</td>`;
                }

                markup += `<td>${moment(row.created_at).format('MM/DD/YYYY')}</td>
                        <td>${row.comments == null ? '' : row.comments}</td>
                        <td>`;

                if( status == 0 ) {
                    markup  += `<div class="d-block mb-1">
                                <select class="form-control employee-selection" data-job="${row.id}" data-position="${row.position_id}"></select>
                            </div>`;
                }

                markup += `<button class="btn btn-sm btn-default d-block m-auto" data-toggle="tooltip" title="Edit Job" onclick="showEditJobModal(${row.id})"><i class="fa fa-edit"></i></button>
                        </td>
                </tr>`;
            }

            setTimeout(() => initEmployeeSearchSelect2());

            if(!markup) {
                $(`#${namingPrefix}JobsNoResults`).removeClass('d-none');
            } else {
                $(`#${namingPrefix}JobsTableBody`).append(markup);
            }

        }

        $('.client-dropdown').change(function() {
            getJobsites($(this).val());
        });

        // $('.jobsite-dropdown').change(function() {
        //     getSupervisors($(this).val())
        // });

        $('#quickAddEmployeeForm').submit(function(e) {
            e.preventDefault();
            $.post(`${BASE_URL}/api/employee`, $(this).serialize(), function(response) {
                if(Array.isArray(response)) {
                    response.reverse();
                    for(let err of response) {
                        $.notify(err);
                    }
                } else {
                    $.notify(response, "success");
                    $('#addEmployeeModal').modal('hide');
                    calendar.refetchEvents();
                }
            });
        });

        $('#jobRequestForm').submit(function(e) {
            e.preventDefault();
            $.post(`${BASE_URL}/api/job`, $(this).serialize(), function(response) {
                if(Array.isArray(response)) {
                    response.reverse();
                    for(let err of response) {
                        $.notify(err);
                    }
                } else {
                    $.notify(response, "success");
                    $('#requestJobModal').modal('hide');
                    calendar.refetchEvents();
                }
            });
        });

    });

    function showAddJobModal(dateString) {
        $('#requestJobDateContainer').text(moment(dateString).format('DD/MM/YYYY'));
        const addJobDate  = moment(dateString).format('YYYY-MM-DD');
        $('#startDate').val(addJobDate);
        $('#requestJobModal').modal('show');
        $('#requestJobModal .select2').select2({
            dropdownParent: $('#requestJobModal')
        });
    }

    function getJobsites(clientId, jobsiteId = null, supervisorId = null) {
        $.get(`${BASE_URL}/api/jobsites`, { clientId }, function(jobsites){
            let optionsMarkup = '<option>-Select Job Site-</option>';
            for(let job of jobsites) {
                optionsMarkup   += `<option value="${job.id}" ${jobsiteId==job.id ? 'selected' : ''}>${job.title} - ${job.address}</option>`;
            }
            $('.jobsite-dropdown').html(optionsMarkup);
            getSupervisors(jobsiteId, supervisorId);
        });
    }

    function getSupervisors(jobsiteId, supervisorId = null) {
        $.get(`${BASE_URL}/api/supervisors`, { jobsiteId }, function(supervisors){
            let optionsMarkup = '<option>-Select Supervisor-</option>';
            for(let person of supervisors) {
                optionsMarkup   += `<option value="${person.id}" ${supervisorId == person.id ? 'selected' : ''}>${person.first_name} ${person.last_name}</option>`;
            }
            $('.supervisor-dropdown').html(optionsMarkup);
        });
    }

    function showEditJobModal(id) {
        return false; // feature in progress/draft, remove return when resume working on it
        $('#editJobModal').modal('show');
        $.get(`${BASE_URL}/api/job`, { id }, function(response) {
            // $('#editJobModal .jobsite-dropdown').val();
            $('#editJobModal .client-dropdown').val(response.client_id);
            getJobsites(response.client_id, response.jobsite_id, response.supervisor_id);
            $('#editJobModal .position-dropdown').val(response.position_id);
            $('#editJobModal .comments-field').val(response.comments);
            $('#editJobModal .select2').select2({
                dropdownParent: $('#editJobModal')
            });
        });

    }

    function showAddEmployeePopup() {
        $(".employee-selection").select2("close");
        $('#addEmployeeModal').modal('show');
    }

    function initEmployeeSearchSelect2() {
        $('.employee-selection').select2({
            placeholder         : 'Select Employee',
            minimumInputLength  : 2,
            allowClear          : true,
            ajax: {
                url: `${BASE_URL}/api/employees`,
                dataType: 'json',
                data: function (params) {
                    var query = {
                        q       : params.term,
                        position: $(this).data('position'),
                        job     : $(this).data('job'),
                    }
                    return query;
                }
            },
            language: {
                noResults: getSelect2AddEmployeeOptionMarkup,
                inputTooShort: getSelect2AddEmployeeOptionMarkup
            }
        }).on("select2:selecting", function(e) {
            const selectedEmp   = e.params.args.data;
            $.post(`${BASE_URL}/api/employee/job`, {empId : selectedEmp.id, jobId: selectedEmp.jobId}, function(response) {
                if( response == true) {
                    $.notify('Employee has been assigned with the job successfully', "success");
                    $(e.currentTarget).parents('tr').firstName().remove();
                    calendar.refetchEvents()
                } else if(response) {
                    $.notify(response);
                }
            });
        });


        function getSelect2AddEmployeeOptionMarkup() {
            return $("<div onclick='showAddEmployeePopup()' class='no-results-element'>Add new employee</div>");
        }
    }

    function closeEmployeePopupAndRedirect() {
        $('#addEmployeeModal').modal('hide');
        // New tab instead of redirecting
        window.open(`${BASE_URL}/employee/create`);
    }

</script>
@endsection
