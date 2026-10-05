<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            <li {!! Request::is('aptreneri') ? 'class="active"' : '' !!}><a href="{{ url('/aptreneri') }}"><i class='fa fa-tachometer-alt'></i> <span>{{ trans('admin_message.sidebar.dashboard') }}</span></a></li>
            <li {!! Request::is('aptreneri/terms*') ? 'class="active"' : '' !!}><a href="{{ url('/aptreneri/terms') }}"><i class='fa fa-calendar' aria-hidden="true"></i> <span>{{ trans('admin_message.sidebar.terms') }}</span></a></li>
            <li {!! Request::is('aptreneri/entrances*') ? 'class="active"' : '' !!}><a href="{{ url('/aptreneri/entrances') }}"><i class='fa fa-qrcode' aria-hidden="true"></i> <span> Očitavanja QR-a </span></a></li>

            @if(auth()->user()->id == 13)
            <li {!! Request::is('aptreneri/users*') ? 'class="active"' : '' !!}><a href="{{ url('/aptreneri/users') }}"><i class='fa fa-users'></i> <span>{{ trans('admin_message.sidebar.users') }}</span></a></li>
            @endif
        </ul>
        <!-- /.sidebar-menu -->


    </section>
    <!-- /.sidebar -->
</aside>
