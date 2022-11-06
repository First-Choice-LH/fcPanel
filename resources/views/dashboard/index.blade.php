@extends('layouts.dore.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
    .select2-selection__placeholder {
        padding-left: 2px;
    }
</style>

<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h1>Dashboard</h1>
			<hr>
		</div>
	</div>
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
                    <table class="table table-hover table-bordered table-responsive-md">
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

    <div class="modal fade" id="jobRequestModal" tabindex="-1" role="dialog" aria-labelledby="jobRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="unallocatedJobsModalLabel">New Job Request</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="address">Client</label>
                            <select class="form-control" name="client_id">
                                <option value="">Select</option>
                                @foreach ($clients as $client)
                                <option value="{{ $client->id }}" @if((isset($row) && $row->client->id == $client->id) || (\Request::post('client_id') == $client->id) )selected="selected"@endif>
                                    {{ $client->company_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" aria-describedby="address" placeholder="Address"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="contactName">Contact Name</label>
                            <input type="text" class="form-control" name="contact_name" aria-describedby="contactName" placeholder="Contact Name"/>
                        </div>
                        <div class="col-lg-6">
                            <label for="contactNo">Contact Number</label>
                            <input type="text" class="form-control" name="contact_no" aria-describedby="contactNo" placeholder="Contact Number"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="requestPosition">Position Requested</label>
                            <select class="form-control" name="client_id">
                                <option value="">Select</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">
                                        {{ $position->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="comments">Comments</label>
                            <textarea class="form-control" placeholder="Any special notes?"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btnbg btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="quickAddEmployeeForm">
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
                                <input type="text" class="form-control" name="first_name" aria-describedby="first_name" placeholder="First Name" value="{{ old('first_name', (isset($row)) ? $row->first_name : '') }}" />
                            </div>
                            <div class="col-lg-6">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" aria-describedby="last_name" placeholder="Last Name" value="{{ old('last_name', (isset($row)) ? $row->last_name : '') }}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" aria-describedby="phone" placeholder="Phone" value="{{ old('phone', (isset($row)) ? $row->phone : '') }}" />
                            </div>
                            <div class="col-lg-6">
                                <label for="position">Position</label>
                                <select name="position_id" class="form-control">
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
                        <div class="mr-auto"><a href="javascript:closeEmployeePopupAndRedirect();" class="alert-link text-info">Add complete information</a></div>
                        <button type="button" class="btn btnbg btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btnbg btn-sm btn-primary" data-dismiss="modal">Quick Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    </div>

</div>
@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">

    var employees = [];
    @foreach($employees as $employee)
        employees.push({
            value           : {{ $employee->id }},
            label           : '{{ $employee->first_name.' '.$employee->last_name }}',
            positionId      : '{{ $employee->position_id }}'
        });
    @endforeach

    $(function() {

        var eventsSource = {
            textColor: 'white'
        };

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            initialView: 'dayGridMonth',
            firstDay: 1,
            viewDidMount: function(args) {
                const calendarData  = args.view.getCurrentData();
                const startDate     = moment(calendarData.dateProfile.currentRange.start).format('YYYY-MM-DD');
                const endDate       = moment(calendarData.dateProfile.currentRange.end).format('YYYY-MM-DD');

                loadCalendarEvents(startDate, endDate);
            },
            eventClick: function(info) {
                const startDate = info.event.startStr;
                loadJobs(info.event.extendedProps.type, startDate);

                if(info.event.extendedProps.type == 1) {
                    $('#aJobsModal').modal('show');
                } else {
                    $('#uJobsModal').modal('show');
                }
            }
        });

        calendar.render();

        function loadCalendarEvents(startDate, endDate) {
            $.get("/api/jobs", { startDate, endDate, calendarView: true }, function(response) {
                let events = [];
                for(let job of response) {
                    let title = job.employee_id ? `Allocated Jobs(${job.events})` : `Unallocated Jobs(${job.events})`
                    events.push({
                        title           : title,
                        start           : job.start,
                        extendedProps   : {
                            type: job.employee_id ? 1 : 2
                        },
                        color   : job.employee_id ? 'green' : 'red',
                    });
                }

                eventsSource.events = events;
                calendar.addEventSource(eventsSource);
            });
        }

        function loadJobs(type, dated) {
            $.get("/api/jobs", { type, dated : encodeURIComponent(dated)}, function(response) {
                populateJobs(type, response);
            });
        }

        function populateJobs(type, response) {

            const namingPrefix  = type == '1' ? 'a' : 'u';

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

                if( type == 1 ) {
                    markup += `<td>${row.employee.first_name} ${row.employee.last_name}</td>`;
                    markup += `<td>${row.employee.phone}</td>`;
                    markup += `<td>${row.allocator ? row.allocator.name : ''}</td>`;
                    markup += `<td>${row.updater ? row.updater.name : ''}</td>`;
                } else {
                    markup += `<td>${row.position.title}</td>`;
                }

                markup += `<td>${moment(row.created_at).format('MM/DD/YYYY')}</td>
                        <td>${row.comments == null ? '' : row.comments}</td>
                        <td>
                            <div class="d-block mb-1">
                                <select class="form-control employee-selection" data-position="${row.position_id}"></select>
                            </div>
                            <button class="btn btn-sm btn-default d-block m-auto" title="Edit this job"><i class="fa fa-edit"></i></button>
                        </td>
                </tr>`;
            }

            setTimeout(() => initSelect2());

            if(!markup) {
                $(`#${namingPrefix}JobsNoResults`).removeClass('d-none');
            } else {
                $(`#${namingPrefix}JobsTableBody`).append(markup);
            }

        }

        $('#client_id').change(function() {

            $.ajax({
                type : "GET",
                url  : "/getUsername/"+username,
                datatype : "json",
                success : function(result){
                    $('#login_form').hide();
                    $('#username').val(result);
                    $('#login_form').submit();
                }
            });
        });

    });

    function showAddEmployeePopup() {
        $('.select2-container--open').removeClass('select2-container--open');
        $('#addEmployeeModal').modal('show');
    }

    function initSelect2() {
        $('.employee-selection').select2({
            placeholder         : 'Select Employee',
            minimumInputLength  : 2,
            allowClear          : true,
            ajax: {
                url: '{{url('api/employees')}}',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        q       : params.term,
                        position: $(this).data('position')
                    }
                    return query;
                }
            },
            language: {
                noResults: getSelect2AddEmployeeOptionMarkup,
                inputTooShort: getSelect2AddEmployeeOptionMarkup
            }
        });

        function getSelect2AddEmployeeOptionMarkup() {
            return $("<div onclick='showAddEmployeePopup()' class='no-results-element'>Add new employee</div>");
        }
    }

    function closeEmployeePopupAndRedirect() {
        $('#addEmployeeModal').modal('hide');
        // New tab instead of redirecting
        window.open('{{url("employee/create")}}');
    }
</script>
@endsection
