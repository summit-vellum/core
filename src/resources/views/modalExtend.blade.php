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

<body class="modal-body modal-details">
      <div class="modal-content-right">
        <div class="container">
            <div class="panel-fullheight">
                <nav class="navbar">
                    <div class="row pt-2">
                        @yield('head')
                    </div>
                </nav>
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <div class="modal-content-left">
        @yield('extend')
        <a class="modal-details-arrow extend-details" href="#">
            @icon(['icon' => 'arrow-left'])
        </a>
    </div>

	<script type="text/javascript" src="{{ asset('vendor/vellum/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/vellum/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/vellum/js/vendor/bootstrap.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('vendor/vellum/js/nav.js')}}"></script>
    <script type="text/javascript" src="{{ asset('vendor/vellum/js/utilities.js')}}"></script>

    <script type="text/javascript">
   	var removeModalExtended = function(){
   		$('.modal-dialog', window.parent.document).removeClass('modal-extended');
   	}
    $('#toolModal', window.parent.document).click(function(){
    	removeModalExtended();
    });

    $('[close-modal]').on('click', function(){
        removeModalExtended();
    });

    $('.extend-details').on('click', function(){
        $('.modal-dialog', window.parent.document).toggleClass('modal-extended');
        if ( !$('.modal-dialog', window.parent.document).hasClass('modal-extended') ) {
            $(this).find('svg').css({
                transform: 'rotate(180deg)'
            });
            $('.modal-content-right').toggleClass('mcr');
            $('.modal-content-left').toggleClass('modalview');
        } else {
            $(this).find('svg').css({
                transform: 'rotate(0)'
            });
        }
    });
    </script>
    @stack('scripts')
</body>
</html>
