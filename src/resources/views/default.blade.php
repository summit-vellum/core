<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('vendor/vellum/js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Arimo:400,400i,700,700i" />

    <!-- Styles -->
    <!-- Quill css -->
    <link href="{{ asset('vendor/vellum/css/desktop.css') }}" rel="stylesheet">

    <!-- Vellum css -->
    <!-- <link href="{{ asset('vendor/vellum/css/app.css') }}" rel="stylesheet"> -->
    {{-- <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet"> --}}

    <!-- <link href="{{ asset('vendor/html/css/bootstrap.min.css') }}" rel="stylesheet"> -->


    @stack('css')

</head>

<body>
    <!-- <div class="container-fluid"> -->

    <div>
        <header>
            @include(template('nav'))
        </header>

        <!-- <sidebar>
            @include('vellum::sidebar')
        </sidebar> -->

            @yield('content')
        </div>
    </div>


    @include(template('components.modalElement'))

	<script type="text/javascript" src="{{ asset('vendor/vellum/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/vellum/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/vellum/js/vendor/bootstrap.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('vendor/vellum/js/nav.js')}}"></script>
    <script type="text/javascript" src="{{ asset('vendor/vellum/js/utilities.js')}}"></script>
    @stack('scripts')

    <!-- pusher -->
    @if(isset($site['pusher']['allow']))
    @include(template('pusherNotif', [], 'vellum'), [])
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script type="text/javascript">
    	var pusher = '';
    		pusherTimeout = '{{ $site["pusher"]["timeout"] }}';
    </script>
	<script type="text/javascript" src="{{ asset('js/pusher-main.js') }}"></script>
	<script type="text/javascript">initPusher('{{ env('PUSHER_APP_KEY') }}', '{{ env('PUSHER_APP_CLUSTER') }}', true);</script>
	<script type="text/javascript" src="{{ asset('vendor/post/js/pusher/post-published.js') }}"></script>
	@endif
</body>
</html>
