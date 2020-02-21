<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Arimo:400,400i,700,700i" />

    <!-- Styles -->
    <!-- Quill css -->
    <link href="{{ asset('vendor/vellum/css/desktop.css') }}" rel="stylesheet">

    @stack('css')
</head>

<body class="modal-body">
    <div class="panel panel-default panel-fullheight">
    	<div class="panel-heading clearfix navbar-fixed-top">
            @yield('head')
    	</div>
   		<div class="panel-body mt-7">
	        <div class="px-3 panel-fullheight">
	            @yield('content')
	        </div>
      	</div>
    </div>

	<script type="text/javascript" src="{{ asset('vendor/vellum/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/vellum/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/vellum/js/vendor/bootstrap.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('vendor/vellum/js/nav.js')}}"></script>
    <script type="text/javascript" src="{{ asset('vendor/vellum/js/utilities.js')}}"></script>
    @stack('scripts')
</body>
</html>
