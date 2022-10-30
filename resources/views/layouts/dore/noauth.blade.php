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
    
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous"> 
</head>

<body class="background">
    <div class="fixed-background login_bg" style="opacity: 1;"></div>
    <main style="opacity:1;">
        
        <div class="container">
            
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
</body>

</html>