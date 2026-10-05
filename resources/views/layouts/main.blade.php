<!DOCTYPE html>
<!--[if IE 8]> <html lang="sr" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="sr" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="sr">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="Robots" content="index, follow"/>
    <meta name="viewport" content="width=device-width, initial-scale= 1.0, user-scalable=no">
    <title>@yield('title','') I'M Fit - Fitness Centar - Šabac</title>
    <meta name="description" content="@yield('meta-desc', 'Fitness Centar Šabac - Personalni treninzi, Grupni treninzi, XBody (ems), Power plate, Teretana')">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Open Graph -->
    <meta content="website" property="og:type" />
    <meta property="og:title" content="@yield('og-title', 'I\'M Fit - Fitness Centar - Šabac' )">
    <meta property="og:type" content="product">
    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:description" content="@yield('og-description', 'Fitness Centar Šabac - Personalni treninzi, Grupni treninzi, XBody (ems), Power plate, Teretana')">
    <meta property="og:image" content="@yield('og-image', asset('img/fb-share.jpg'))">
    <meta property="og:image:type" content="image/jpg">
    <meta property="og:image:width" content="500">
    <meta property="og:image:height" content="300">

	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Place favicon.ico in the root directory -->
    {{--<link rel="apple-touch-icon" sizes="57x57" href="{{  asset('fav/apple-icon-57x57.png') }}">--}}
    {{--<link rel="apple-touch-icon" sizes="60x60" href="{{  asset('fav/apple-icon-60x60.png') }}">--}}
    {{--<link rel="apple-touch-icon" sizes="72x72" href="{{  asset('fav/apple-icon-72x72.png') }}">--}}
    {{--<link rel="apple-touch-icon" sizes="76x76" href="{{  asset('fav/apple-icon-76x76.png') }}">--}}
    {{--<link rel="apple-touch-icon" sizes="114x114" href="{{  asset('fav/apple-icon-114x114.png') }}">--}}
    {{--<link rel="apple-touch-icon" sizes="120x120" href="{{  asset('fav/apple-icon-120x120.png') }}">--}}
    {{--<link rel="apple-touch-icon" sizes="144x144" href="{{  asset('fav/apple-icon-144x144.png') }}">--}}
    {{--<link rel="apple-touch-icon" sizes="152x152" href="{{  asset('fav/apple-icon-152x152.png') }}">--}}
    {{--<link rel="apple-touch-icon" sizes="180x180" href="{{  asset('fav/apple-icon-180x180.png') }}">--}}
    {{--<link rel="icon" type="image/png" sizes="192x192"  href="{{  asset('fav/android-icon-192x192.png') }}">--}}
    {{--<link rel="icon" type="image/png" sizes="32x32" href="{{  asset('fav/favicon-32x32.png') }}">--}}
    {{--<link rel="icon" type="image/png" sizes="96x96" href="{{  asset('fav/favicon-96x96.png') }}">--}}
    {{--<link rel="icon" type="image/png" sizes="16x16" href="{{  asset('fav/favicon-16x16.png') }}">--}}
    {{--<link rel="manifest" href="{{  asset('fav/manifest.json') }}">--}}

    <!-- Theme color-->
    <meta name="msapplication-TileColor" content="#bebfc3">
    {{--<meta name="msapplication-TileImage" content="{{ asset('fav/ms-icon-144x144.png') }}">--}}
    <meta name="theme-color" content="#212731">

    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/preloader.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
   	@yield('styles')
</head>
<body>
<!-- preloader start -->
<div id="preloader">
	<div id="status"><img src="{{ asset('assets/images/logo.png') }}" alt="preloader"></div>
</div>

@include('partials.header')


     @yield('content')


@include('partials.footer')

<!-- js files start -->
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script src="{{ asset('assets/js/tether.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/appear.count.to.js') }}"></script>
<script src="{{ asset('assets/js/count.to.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script>

    $(document).on('click', '.ff_share ul > li > a', function(e){

        var verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
            horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);

        var popup = window.open($(this).prop('href'), 'social',
            'width='+popupSize.width+',height='+popupSize.height+
            ',left='+verticalPos+',top='+horisontalPos+
            ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

        if (popup) {
            popup.focus();
            e.preventDefault();
        }

    });
</script>
    @yield('scripts')
</body>
</html>



