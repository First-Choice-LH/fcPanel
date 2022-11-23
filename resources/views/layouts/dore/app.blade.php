<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('dore/font/iconsmind/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('dore/font/simple-line-icons/css/simple-line-icons.css') }}" />

    <link rel="stylesheet" href="{{ asset('dore/css/vendor/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dore/css/vendor/fullcalendar.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dore/css/vendor/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dore/css/vendor/datatables.responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dore/css/vendor/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dore/css/vendor/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('dore/css/vendor/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dore/css/vendor/bootstrap-stars.css') }}" />
    <link rel="stylesheet" href="{{ asset('dore/css/vendor/nouislider.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dore/css/vendor/bootstrap-datepicker3.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dore/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('dore/css/dore.light.blue.css') }}" />

    <link rel="stylesheet" href="{{ asset('dore/css/overrided.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.min.css" integrity="sha512-PlmS4kms+fh6ewjUlXryYw0t4gfyUBrab9UB0vqOojV26QKvUT9FqBJTRReoIZ7fO8p0W/U9WFSI4MAdI1Zm+A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800,900|Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>

<body id="app-container" class="menu-default menu-sub-hidden sub-hidden">

    @auth
    <nav class="navbar fixed-top" style="opacity: 1;">
        <a href="#" class="menu-button d-none d-md-block">
            <!--svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                <rect x="0.48" y="0.5" width="7" height="1"></rect>
                <rect x="0.48" y="7.5" width="7" height="1"></rect>
                <rect x="0.48" y="15.5" width="7" height="1"></rect>
            </svg>
            <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                <rect x="1.56" y="0.5" width="16" height="1"></rect>
                <rect x="1.56" y="7.5" width="16" height="1"></rect>
                <rect x="1.56" y="15.5" width="16" height="1"></rect>
            </svg-->
            <i class="fas fa-list-ul" style="font-size: 22px;"></i>
        </a>

        <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                <rect x="0.5" y="0.5" width="25" height="1"></rect>
                <rect x="0.5" y="7.5" width="25" height="1"></rect>
                <rect x="0.5" y="15.5" width="25" height="1"></rect>
            </svg>
        </a>

        <!-- <div class="search" data-search-path="Layouts.Search.html?q=">
            <input placeholder="Search...">
            <span class="search-icon">
                <i class="simple-icon-magnifier"></i>
            </span>
        </div> -->

        <a class="navbar-logo" href="{{ url('/') }}">
            <img src="{{ asset('dore/img/weblogo.jpg') }}" alt="" class="img-fluid d-none d-xs-block"/>
            <img src="{{ asset('dore/img/phonelogo.jpg') }}" alt="" class="img-fluid d-block d-xs-none" width="200%"/>
        </a>

        <div class="ml-auto">
            <div class="header-icons d-inline-block align-middle">

                <!-- <div class="position-relative d-none d-sm-inline-block">
                    <button class="header-icon btn btn-empty" type="button" id="iconMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="simple-icon-grid"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right mt-3  position-absolute" id="iconMenuDropdown">
                        <a href="#" class="icon-menu-item">
                            <i class="iconsmind-Equalizer d-block"></i>
                            <span>Settings</span>
                        </a>

                        <a href="#" class="icon-menu-item">
                            <i class="iconsmind-MaleFemale d-block"></i>
                            <span>Users</span>
                        </a>

                        <a href="#" class="icon-menu-item">
                            <i class="iconsmind-Puzzle d-block"></i>
                            <span>Components</span>
                        </a>

                        <a href="#" class="icon-menu-item">
                            <i class="iconsmind-Bar-Chart d-block"></i>
                            <span>Profits</span>
                        </a>

                        <a href="#" class="icon-menu-item">
                            <i class="iconsmind-File-Chart d-block"></i>
                            <span>Surveys</span>
                        </a>

                        <a href="#" class="icon-menu-item">
                            <i class="iconsmind-Suitcase d-block"></i>
                            <span>Tasks</span>
                        </a>

                    </div>
                </div> -->

                <!-- <div class="position-relative d-inline-block">
                    <button class="header-icon btn btn-empty" type="button" id="notificationButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="simple-icon-bell"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right mt-3 scroll position-absolute ps" id="notificationDropdown">

                        <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                            <a href="#">
                                <img src="dore/img/profile-pic-l-2.jpg" alt="Notification Image" class="img-thumbnail list-thumbnail xsmall border-0 rounded-circle">
                            </a>
                            <div class="pl-3 pr-2">
                                <a href="#">
                                    <p class="font-weight-medium mb-1">Joisse Kaycee just sent a new comment!</p>
                                    <p class="text-muted mb-0 text-small">09.04.2018 - 12:45</p>
                                </a>
                            </div>
                        </div>

                        <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                            <a href="#">
                                <img src="dore/img/notification-thumb.jpg" alt="Notification Image" class="img-thumbnail list-thumbnail xsmall border-0 rounded-circle">
                            </a>
                            <div class="pl-3 pr-2">
                                <a href="#">
                                    <p class="font-weight-medium mb-1">1 item is out of stock!</p>
                                    <p class="text-muted mb-0 text-small">09.04.2018 - 12:45</p>
                                </a>
                            </div>
                        </div>


                        <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                            <a href="#">
                                <img src="dore/img/notification-thumb-2.jpg" alt="Notification Image" class="img-thumbnail list-thumbnail xsmall border-0 rounded-circle">
                            </a>
                            <div class="pl-3 pr-2">
                                <a href="#">
                                    <p class="font-weight-medium mb-1">New order received! It is total $147,20.</p>
                                    <p class="text-muted mb-0 text-small">09.04.2018 - 12:45</p>
                                </a>
                            </div>
                        </div>

                        <div class="d-flex flex-row mb-3 pb-3 ">
                            <a href="#">
                                <img src="dore/img/notification-thumb-3.jpg" alt="Notification Image" class="img-thumbnail list-thumbnail xsmall border-0 rounded-circle">
                            </a>
                            <div class="pl-3 pr-2">
                                <a href="#">
                                    <p class="font-weight-medium mb-1">3 items just added to wish list by a user!</p>
                                    <p class="text-muted mb-0 text-small">09.04.2018 - 12:45</p>
                                </a>
                            </div>
                        </div>

                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                </div> -->


            </div>

            <div class="user d-inline-block desktop-header">
                @inject('metrics', 'App\Http\Controllers\ActivityController')
                <button class="btn btn-empty p-0" type="button">

                    @hasrole('admin')
                        <span class="name">{{ strtoupper(\Auth::user()->username) }}</span>
                    @endhasrole

                    @hasrole('employee')
                       <span class="name">{{ strtoupper($metrics->getEmployeeName()) }}</span>
                    @endhasrole

                    @hasrole('supervisor')
                       <span class="name">{{ strtoupper($metrics->getSupervisorName()) }}</span>
                    @endhasrole

                </button>

                @auth
                    <button class="btn btn-empty p-0" type="button">
                        <a class="dropdown-item logout" href="{{ url('/logout/') }}"><span class="name">SIGN OUT</span></a>
                    </button>
                @endauth
            </div>

            <div class="user d-inline-block mobile-header">
                <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span>
                        <img alt="Profile Picture" src="{{ asset('dore/img/profile-pic-l.jpg') }}" style="border:1px dotted #333;"/>
                    </span>
                </button>

                <div class="dropdown-menu dropdown-menu-right mt-3">
                    <a class="dropdown-item" href="javascript:;">
                        @hasrole('admin')
                            <span class="">{{ strtoupper(\Auth::user()->username) }}</span>
                        @endhasrole

                        @hasrole('employee')
                           <span class="">{{ strtoupper($metrics->getEmployeeName()) }}</span>
                        @endhasrole

                        @hasrole('supervisor')
                           <span class="">{{ strtoupper($metrics->getSupervisorName()) }}</span>
                        @endhasrole
                    </a>

                    @auth
                    <a class="dropdown-item" href="{{ url('/logout/') }}">Sign out</a>
                    @endauth
                </div>
            </div>

        </div>
    </nav>
    @endauth

    @auth
    <div class="sidebar">
        <div class="main-menu">
            <div class="scroll">
                <ul class="list-unstyled">
                    @hasrole('admin')

                    <li class="@if(Request::is('dashboard')) active @endif">
                        <a href="{{ url('/dashboard/') }}">
                            <i class="iconsmind-Shop"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="@if(Request::is('activity')) active @endif">
                       <a href="{{ url('/activity/') }}">
                           <i class="iconsmind-Administrator"></i>
                           <span>Activity</span>
                       </a>
                    </li>

                    <li class="@if(Request::is('timesheets')) active @endif">
                        <a href="{{ url('/timesheets/') }}">
                            <i class="iconsmind-Stopwatch"></i>
                            <span>Timesheets</span>
                        </a>
                    </li>

                    <li class="@if(Request::is('clients')) active @endif @if(Request::is('clients/*')) active @endif">
                        <a href="{{ url('/clients/') }}">
                            <i class="iconsmind-Shop-4"></i>
                            <span>Companies</span>
                        </a>
                    </li>

                    <li class="@if(Request::is('jobsites')) active @endif @if(Request::is('jobsites/*')) active @endif">
                        <a href="{{ url('/jobsites/') }}">
                            <i class="iconsmind-Map"></i>
                            <span>Jobsites</span>
                        </a>
                    </li>

                    <li class="@if(Request::is('supervisors')) active @endif @if(Request::is('supervisors/*')) active @endif">
                        <a href="{{ url('/supervisors/') }}">
                            <i class="iconsmind-Business-Man"></i>
                            <span>Supervisors</span>
                        </a>
                    </li>

                    <li class="@if(Request::is('positions')) active @endif @if(Request::is('positions/*')) active @endif">
                        <a href="{{ url('/positions/') }}">
                            <i class="iconsmind-Map-Marker"></i>
                            <span>Positions</span>
                        </a>
                    </li>

                    <li class="@if(Request::is('employees')) active @endif @if(Request::is('employees/*')) active @endif @if(strpos(Request::fullUrl(), 'employee') !== false) active @endif">
                        <a href="{{ url('/employees/') }}">
                            <i class="iconsmind-Administrator"></i>
                            <span>Employees</span>
                        </a>
                    </li>

                     <li class="@if(Request::is('requests')) active @endif @if(Request::is('requests/*')) active @endif">
                        <a href="{{ url('/requests/') }}">
                            <i class="iconsmind-Administrator"></i>
                            <span>Jobsite Requests</span>
                        </a>
                    </li>

                    @endhasrole

                    @hasrole('employee')

                    <li class="@if(Request::is('employees/dashboard')) active @endif">
                       <a href="{{ url('/employees/dashboard') }}">
                           <i class="iconsmind-Shop"></i>
                           <span>Dashboard</span>
                       </a>
                    </li>
                    <li class="@if(Request::is('employees/myaccount')) active @endif">
                       <a href="{{ url('/employees/myaccount/') }}">
                           <i class="iconsmind-Business-Man"></i>
                           <span>My Account</span>
                       </a>
                    </li>
                   <!-- <li class="@if(Request::is('employees/jobsites')) active @endif @if(strpos(Request::fullUrl(), 'jobsites') !== false) active @endif">-->
                    <li class="@if(strpos(Request::route()->getName(),'employees.jobsites') !== false) active @endif ">
                        <a href="{{ url('/employees/jobsites/') }}">
                            <i class="simple-icon-map"></i>
                            <span>Jobsites</span>
                        </a>
                    </li>
                    <li class="@if(strpos(Request::route()->getName(),'emp.timesheets') !== false) active @endif">
                        <a href="{{ url('/employees/timesheets/') }}">
                            <i class="iconsmind-Stopwatch"></i>
                            <span>Timesheets</span>
                        </a>
                    </li>


                    @endhasrole

                    @hasrole('supervisor')

                    <li class="@if(Request::is('supervisors/dashboard')) active @endif">
                       <a href="{{ url('/supervisors/dashboard') }}">
                           <i class="iconsmind-Shop"></i>
                           <span>Dashboard</span>
                       </a>
                    </li>

                    <!-- <li class="@if(Request::is('supervisors/activity')) active @endif">
                       <a href="{{ url('/supervisors/activity/') }}">
                           <i class="iconsmind-Administrator"></i>
                           <span>Activity</span>
                       </a>
                    </li> -->

                    <li class="@if(Request::is('supervisors/myaccount')) active @endif">
                       <a href="{{ url('/supervisors/myaccount/') }}">
                           <i class="iconsmind-Business-Man"></i>
                           <span>My Account</span>
                       </a>
                   </li>

                    <li class="@if(Request::is('supervisors/jobsites')) active @endif @if(strpos(Request::fullUrl(), 'jobsites') !== false) active @endif">
                        <a href="{{ url('/supervisors/jobsites/') }}">
                            <i class="simple-icon-map"></i>
                            <span>Jobsites</span>
                        </a>
                    </li>
<!--
                    <li class="@if(Request::is('supervisors/timesheets')) active @endif">
                        <a href="{{ url('/supervisors/timesheets/') }}">
                            <i class="iconsmind-Stopwatch"></i>
                            <span>Timesheets</span>
                        </a>
                    </li> -->

                    <li class="@if(Request::is('supervisors/pending/timesheets')) active @endif">
                        <a href="{{ url('/supervisors/pending/timesheets/') }}">
                            <i class="iconsmind-Stopwatch"></i>
                            <span>Pending Timesheets</span>
                        </a>
                    </li>

                    <li class="@if(Request::is('supervisors/employee')) active @endif @if(Request::is('supervisors/timesheets/*')) active @endif">
                       <a href="{{ url('/supervisors/employee/') }}">
                           <i class="iconsmind-Administrator"></i>
                           <span>Employees</span>
                       </a>
                   </li>

                   <!-- <li class="@if(Request::is('activity')) active @endif">
                       <a href="{{ url('/supervisors/activity/') }}">
                           <i class="iconsmind-Administrator"></i>
                           <span>Activity</span>
                       </a>
                    </li>-->

                    @endhasrole
                </ul>
            </div>
        </div>

        <!-- <div class="sub-menu">
            <div class="scroll">

                <ul class="list-unstyled" data-link="admin_dashboard">
                    <li class="active">
                        <a href="{{ url('clients/create') }}">
                            <i class="simple-icon-briefcase"></i> Create Company
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('supervisors/create') }}">
                            <i class="simple-icon-user-follow"></i> Create Supervisor
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('jobsites/create') }}">
                            <i class="simple-icon-map"></i> Create Jobsite
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('positions/create') }}">
                            <i class="simple-icon-location-pin"></i> Create Position
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('employees/create') }}">
                            <i class="simple-icon-user"></i> Create Employee
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('timesheets') }}">
                            <i class="simple-icon-speedometer"></i> View Timesheet
                        </a>
                    </li>
                </ul>

                <ul class="list-unstyled" data-link="admin_clients">

                    <li class="@if(Request::is('clients')) active @endif">
                        <a href="{{ url('/clients/') }}">
                            <i class="simple-icon-list"></i> Company List
                        </a>
                    </li>

                    <li class="@if(Request::is('clients/create')) active @endif">
                        <a href="{{ url('/clients/create') }}">
                            <i class="simple-icon-plus"></i> Create Company
                        </a>
                    </li>

                </ul>

                <ul class="list-unstyled" data-link="admin_jobsites">

                    <li class="@if(Request::is('jobsites')) active @endif">
                        <a href="{{ url('/jobsites/') }}">
                            <i class="simple-icon-list"></i> Jobsite List
                        </a>
                    </li>

                    <li class="@if(Request::is('jobsites/create')) active @endif">
                        <a href="{{ url('/jobsites/create') }}">
                            <i class="simple-icon-plus"></i> Create Jobsite
                        </a>
                    </li>

                </ul>

                <ul class="list-unstyled" data-link="admin_supervisors">

                    <li class="@if(Request::is('supervisors')) active @endif">
                        <a href="{{ url('/supervisors/') }}">
                            <i class="simple-icon-list"></i> Supervisor List
                        </a>
                    </li>

                    <li class="@if(Request::is('supervisors/create')) active @endif">
                        <a href="{{ url('/supervisors/create') }}">
                            <i class="simple-icon-plus"></i> Create Supervisor
                        </a>
                    </li>

                </ul>

                <ul class="list-unstyled" data-link="admin_positions">

                    <li class="@if(Request::is('positions')) active @endif">
                        <a href="{{ url('/positions/') }}">
                            <i class="simple-icon-list"></i> Position List
                        </a>
                    </li>

                    <li class="@if(Request::is('positions/create')) active @endif">
                        <a href="{{ url('/positions/create') }}">
                            <i class="simple-icon-plus"></i> Create Position
                        </a>
                    </li>

                </ul>

                <ul class="list-unstyled" data-link="admin_employees">

                    <li class="@if(Request::is('employees')) active @endif">
                        <a href="{{ url('/employees/') }}">
                            <i class="simple-icon-list"></i> Employee List
                        </a>
                    </li>

                    <li class="@if(Request::is('employees/create')) active @endif">
                        <a href="{{ url('/employees/create') }}">
                            <i class="simple-icon-plus"></i> Create Employee
                        </a>
                    </li>

                </ul>

            </div>
        </div> -->
    </div>
    @endauth

    <main>

        <div class="container-fluid">

            @yield('content')

        </div>

    </main>

    <script src="{{ asset('dore/js/vendor/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('dore/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dore/js/vendor/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('dore/js/vendor/chartjs-plugin-datalabels.js') }}"></script>
    <script src="{{ asset('dore/js/vendor/moment.min.js') }}"></script>
    <script src="{{ asset('dore/js/vendor/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('dore/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('dore/js/vendor/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dore/js/vendor/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('dore/js/vendor/progressbar.min.js') }}"></script>
    <script src="{{ asset('dore/js/vendor/jquery.barrating.min.js') }}"></script>
    <script src="{{ asset('dore/js/vendor/select2.full.js') }}"></script>
    <script src="{{ asset('dore/js/vendor/nouislider.min.js') }}"></script>
    <script src="{{ asset('dore/js/vendor/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('dore/js/vendor/Sortable.js') }}"></script>
    <script src="{{ asset('dore/js/vendor/mousetrap.min.js') }}"></script>
    <script src="{{ asset('dore/js/dore.script.js') }}"></script>
    <script src="{{ asset('dore/js/scripts.single.theme.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


     @yield('script')

     @include('layouts.dore.scripts')
</body>

</html>
