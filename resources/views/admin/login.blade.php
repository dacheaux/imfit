<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Admin - @yield('title', config('app.name', 'Laravel') ) </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{asset('assets-admin/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
     <link rel="stylesheet" href="{{asset('assets-admin/dist/css/AdminLTE.min.css')}}">

    <link rel="stylesheet" href="{{ asset('assets-admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/css/wheater.css') }}">

    <!-- iCheck -->
    <link href="{{ asset('assets-admin/plugins/iCheck/square/blue.css') }}" rel="stylesheet" type="text/css" />

    <!-- Sweetalert -->
    <link rel="stylesheet" href="{{ asset('assets-admin/css/sweetalert.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('/css/sweetalert.css') }}">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/admin') }}"><b>Admin</b> {{ config('app.name', 'Laravel')  }}</a>
            {{--<img src="{{ asset('img/logo.png') }}" alt="cyber-infinty" class="img-thumbnail" style="border: none; background: none;">--}}
        </div><!-- /.login-logo -->

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            {{ trans('admin_message.someproblems') }}<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="login-box-body">
    <p class="login-box-msg"> {{ trans('admin_message.siginsession') }} </p>
    <form action="{{ route('login') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="{{ trans('admin_message.email') }}" name="email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="{{ trans('admin_message.password') }}" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember"> {{ trans('admin_message.remember') }}
                    </label>
                </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('admin_message.buttonsign') }}</button>
            </div><!-- /.col -->
        </div>
    </form>

    {{--@include('auth.partials.social_login')--}}

    {{--<a href="{{ url('/password/reset') }}">{{ trans('admin_message.forgotpassword') }}</a><br>--}}
    {{--<a href="{{ url('/register') }}" class="text-center">{{ trans('admin_message.registermember') }}</a>--}}

</div><!-- /.login-box-body -->

</div><!-- /.login-box -->

    <!-- jQuery 2.2.3 -->
    <script src="{{asset('assets-admin/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="{{asset('assets-admin/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('assets-admin/dist/js/app.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{ asset('assets-admin/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>

    <!-- Sweetalert -->
    <script src="{{asset('assets-admin/js/sweetalert-dev.js')}}"></script>

    @include('admin.partials._flash')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

