<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('module') - @yield('action')</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('administrator/plugins/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('administrator/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

<!-- custom css -->
<link rel="stylesheet" href="{{ asset('administrator/custom/css/app.css') }}">
<link rel="stylesheet" href="{{ asset('administrator/custom/css/table/custom-table.css') }}">
<link rel="stylesheet" href="{{ asset('administrator/custom/css/side-bar/sidebar.css') }}">



@stack('css')

<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('administrator/dist/css/adminlte.min.css') }}">
