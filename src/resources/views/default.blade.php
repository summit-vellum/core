<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet"> --}}


    @stack('css')

</head>

<body class="bg-gray-200 pb-10 font-body">
    <!-- <div class="container-fluid"> -->

    <div>
        <header>
            @include('vellum::nav')
        </header>

        <sidebar>
            @include('vellum::sidebar')
        </sidebar>

        <div class="container mx-auto">
            @yield('content')

            <div class="pt-10 text-sm text-gray-400 text-center">
                &copy; 2019 Summit Media Digital.
            </div>
        </div>
    </div>


    @include('vellum::components.modalElement')

	<script type="text/javascript" src="{{ asset('js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>

    @stack('scripts')
</body>
</html>
