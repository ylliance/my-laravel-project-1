<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Argon Dashboard') }}</title>
    <!-- Favicon -->
    <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->

    <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

    <link type="text/css" href="{{ asset('argon') }}/vendor/select2/select2.min.css" rel="stylesheet">

    <link type="text/css" href="{{ asset('argon') }}/vendor/daterange/css/daterangepicker.min.css" rel="stylesheet">

    <!-- Argon CSS -->
    {{-- <link type="text/css" href="{{ asset('argon') }}/css/datables.css" rel="stylesheet"> --}}
    <link type="text/css" href="{{ asset('argon') }}/css/ownDatatable.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">

    <!-- Datatabele -->

    <link type="text/css" href="{{ asset('argon') }}/vendor/datatables/b-print.datatables.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/vendor/summernote/summernote.min.css" rel="stylesheet">

    @stack('css')
</head>

<body class="{{ $class ?? '' }}">
    @auth()
    <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
    @include('layouts.navbars.sidebar')
    @endauth

    <div class="main-content">
        @include('layouts.navbars.navbar')
        @yield('content')
    </div>

    @guest()
    @include('layouts.footers.guest')
    @endguest

    <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    @stack('js')

    <!-- Argon JS -->

    {{-- datatable --}}
    <script src="{{ asset('argon') }}/vendor/select2/select2.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('argon') }}/vendor/datatables/b-print.datatables.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/swal2/swal2.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/daterange/js/knockout-3.4.2.js"></script>
    <script src="{{ asset('argon') }}/vendor/daterange/js/moment.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/daterange/js/daterangepicker.min.js"></script>
    <script src="{{ asset('argon') }}/js/custom/custom.js"></script>
    <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
    <script>       
        const Swal_Confirm = Swal.mixin({
            icon: 'question',
            confirmButtonText: 'Yes',
            showCancelButton: true,
        });

        const Toast_info = Swal.mixin({
            toast: true,
            position: 'top-end',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
        });

        const Toast_info_long = Swal.mixin({
            toast: true,
            position: 'top-end',
            timer: 6000,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    </script>
    @auth()
    <script src="{{ asset('argon') }}/js/custom/stats.js"></script>
    @endauth
    @stack('page-script')
</body>

</html>
