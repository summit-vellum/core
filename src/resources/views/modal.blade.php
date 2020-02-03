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

<body class="bg-gray-200 pb-10 font-body">

    <div>

        <div class="px-10">
            @yield('content')
        </div>

    </div>

    <script type="text/javascript" src="{{ asset('js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>

    @stack('scripts')
</body>
</html>
