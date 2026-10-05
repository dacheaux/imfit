<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/admin') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Admin</b>{{ config('app.name', 'Laravel')  }}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('admin_message.togglenav') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <form action="{!! route('admin.post.doors') !!}" method="POST"
                          onsubmit="return confirm('Da li si siguran?')">
                        <input type="hidden" name="door_id" value="1">
                        <input type="hidden" name="door_state" value="1">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <button class="btn btn-sm  btn-success " style="margin-top: 10px;"
                               type="submit">OTVORI VRATA <i class="fa fa-gears"></i></button>
                    </form>

                </li>
                <li>
                    <form action="{!! route('admin.post.doors') !!}" method="POST"
                          onsubmit="return confirm('Da li si siguran?')">
                        <input type="hidden" name="door_id" value="1">
                        <input type="hidden" name="door_state" value="2">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <button class="btn btn-sm  btn-info " style="margin-top: 10px;"
                                type="submit">OTVORI FRIZ <i class="fa fa-gears"></i></button>
                    </form>

                </li>
                 <li class="dropdown messages-menu">
                    <a href="{{ url('admin/entrances') }}" >
                      <i class="fa fa-qrcode"></i>
                         <span class="label label-danger entrances-count" style="font-size: 14px;" >0</span>
                    </a>
                </li>
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ asset($logedUser->avatar)}}" class="user-image" alt="User Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ $logedUser->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ asset($logedUser->avatar)}}" class="img-circle" alt="User Image" />
                            <p>
                                {{ $logedUser->name }}
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ url('/admin/profile') }}" class="btn btn-default btn-flat">{{ trans('admin_message.profile') }}</a>
                            </div>

                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    {{ trans('admin_message.signout') }}
                                </a>
                                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                 </form>
                             </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
