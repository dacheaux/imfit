<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', config('app.name', 'Laravel') .' Admin')</title>
    <link href="{{ asset('img/favicon.ico') }}" rel="shortcut icon"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{!! asset('assets-admin/admin2/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{!! asset('assets-admin/admin2/bower_components/font-awesome/css/font-awesome.min.css') !!}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{!! asset('assets-admin/admin2/bower_components/Ionicons/css/ionicons.min.css') !!}">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{!! asset('assets-admin/admin2/bower_components/fullcalendar/dist/fullcalendar.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets-admin/admin2/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print') !!}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{!! asset('assets-admin/admin2/dist/css/AdminLTE.min.css') !!}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{!! asset('assets-admin/admin2/dist/css/skins/_all-skins.min.css') !!}">

    <!-- Sweetalert -->
    <link rel="stylesheet" href="{{ asset('assets-admin/css/sweetalert.css') }}">
    <!-- Wheater -->
    <link rel="stylesheet" href="{{ asset('assets-admin/css/wheater.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    @yield('style')
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <input type="hidden" id="url">

@include('admin.partials._header')

@include('admin.partials._sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

    @include('admin.partials._bredcrumbs')

    <!-- Main content -->
        <section class="content">

            <div class="col-md-4">
                @include('admin.partials._errors')
            </div>

            <div class="clearfix"></div>

            <!-- Your Page Content Here -->
            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery 3 -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Bootstrap 3.3.7 -->

<script src="{!! asset('assets-admin/admin2/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}"></script>


<!-- jQuery UI 1.11.4 -->
<script src="{!! asset('assets-admin/admin2/bower_components/jquery-ui/jquery-ui.min.js') !!}"></script>
<!-- Slimscroll -->
<script src="{!! asset('assets-admin/admin2/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') !!}"></script>
<!-- FastClick -->
<script src="{!! asset('assets-admin/admin2/bower_components/fastclick/lib/fastclick.js') !!}"></script>
<!-- AdminLTE App -->
<script src="{!! asset('assets-admin/admin2/dist/js/adminlte.min.js') !!}"></script>
<script src="{{asset('assets-admin/dist/js/app.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{!! asset('assets-admin/admin2/dist/js/demo.js') !!}"></script>
<!-- fullCalendar -->
<script src="{!! asset('assets-admin/admin2/bower_components/moment/moment.js') !!}"></script>
<script src="{!! asset('assets-admin/admin2/bower_components/fullcalendar/dist/fullcalendar.min.js') !!}"></script>
<script src="{!! asset('assets-admin/admin2/bower_components/fullcalendar/dist/locale/sr.js') !!}"></script>

<!-- Sweetalert -->
<script src="{{asset('assets-admin/js/sweetalert-dev.js')}}"></script>

@include('admin.partials._flash')

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
@yield('scripts')
<script>
    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        var d = document.getElementById('txt');
        if(d !== null){
            document.getElementById('txt').innerHTML =
                h + ":" + m + ":" + s;
            var t = setTimeout(startTime, 500);
        }
    }
    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }
</script>
</body>
</html>
