<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'First Choice') }}</title>
    <script
      src="https://code.jquery.com/jquery-2.2.4.min.js"
      integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
      crossorigin="anonymous"></script>
    <!-- Scripts -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('vendor/bootswatch/simplex/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    @auth
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}" style="background:url({{ asset('images/logo.jpg') }}) no-repeat !important; width:150px;">&nbsp;</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
       
        <div class="collapse navbar-collapse" id="navbarColor03">
          <ul class="navbar-nav mr-auto">            
            <!-- <li class="nav-item active">
              <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
            </li> -->
            @hasrole('admin')
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/dashboard/') }}">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/timesheets/') }}">Timesheets</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/clients/') }}">Companies</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/jobsites/') }}">Jobsites</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/supervisors/') }}">Supervisors</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/positions/') }}">Positions</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/employees/') }}">Employees</a>
            </li>
            @endhasrole
            @hasrole('employee')
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/employees/jobsites/') }}">Jobsites</a>
            </li>
            @endhasrole
            @hasrole('supervisor')
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/supervisors/jobsites/') }}">Jobsites</a>
            </li>
            @endhasrole
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/logout/') }}">Logout</a>
            </li>
            <!-- @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/login/') }}">Login</a>
            </li>
            @endguest -->
          </ul>
        </div>
      </div>
    </nav>
    @endauth

    <div class="container" style="margin-top:100px;">
        @yield('content')
    </div>
</body>
</html>
