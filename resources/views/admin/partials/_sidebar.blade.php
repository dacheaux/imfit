<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            <li {!! Request::is('admin') ? 'class="active"' : '' !!}><a href="{{ url('/admin') }}"><i class='fa fa-tachometer-alt'></i> <span>{{ trans('admin_message.sidebar.dashboard') }}</span></a></li>
            <li {!! Request::is('admin/workouts*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/workouts') }}"><i class='fa fa-dumbbell'></i> <span>{{ trans('admin_message.sidebar.workouts') }}</span></a></li>
            <li {!! Request::is('admin/plans*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/plans') }}"><i class='fa fa-box'></i> <span>{{ trans('admin_message.sidebar.plans') }}</span></a></li>
            <li {!! Request::is('admin/userplans*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/userplans') }}"><i class='fa fa-boxes'></i> <span>{{ trans('admin_message.sidebar.userplans') }}</span></a></li>
            <li class="dropdown treeview {!! Request::is('admin/accountplans*') || Request::is('admin/accountuserplans*') || Request::is('admin/accounts*') ? 'active' : ''  !!}">

                <a href="#" {!! Request::is('admin/accountplans*') || Request::is('admin/accountuserplans*')  || Request::is('admin/accounts*')  ? 'class="open"' : '' !!}>
                    <i class="fa fa-bank"></i>
                    <span>{{ trans('admin_message.sidebar.accounts') }}</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>

                <ul class="treeview-menu">
                    <li {!! Request::is('admin/accountplans*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/accountplans') }}"><i class='fa fa-box'></i> <span>{{ trans('admin_message.sidebar.accountplans') }}</span></a></li>
                    <li {!! Request::is('admin/accountuserplans*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/accountuserplans') }}"><i class='fa fa-calculator'></i> <span>{{ trans('admin_message.sidebar.accountuserplans') }}</span></a></li>
                    <li {!! Request::is('admin/accounts*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/accounts') }}"><i class='fa fa-bar-chart-o'></i> <span>{{ trans('admin_message.sidebar.accounts') }}</span></a></li>
                </ul>

            </li>

            <li class="dropdown treeview {!! Request::is('admin/categories*') || Request::is('admin/products*') || Request::is('admin/orders*') ? 'active' : ''  !!}">

                <a href="#" {!! Request::is('admin/categories*') || Request::is('admin/products*')  || Request::is('admin/orders*')  ? 'class="open"' : '' !!}>
                    <i class="fa fa-shopping-cart"></i>
                    <span>Shop</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li {!! Request::is('admin/categories*') ? 'class="active"' : '' !!}><a href="{{ url('admin/categories') }}"><i class='fa fa-sitemap'></i> <span>Kategorije</span></a></li>
                    <li {!! Request::is('admin/products*') ? 'class="active"' : '' !!}><a href="{{ url('admin/products') }}"><i class='fa fa-shopping-cart'></i> <span>Proizvodi</span></a></li>
                    <li {!! Request::is('admin/orders*') ? 'class="active"' : '' !!}><a href="{{ url('admin/orders') }}"><i class='fa fa-shopping-basket'></i> <span>Porudžbenice</span></a></li>
                </ul>
            </li>


            <li {!! Request::is('admin/entrances*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/entrances') }}"><i class='fa fa-qrcode'></i> <span>Očitavanje QR</span></a></li>
            <li {!! Request::is('admin/coaches*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/coaches') }}"><i class='fa fa-filter'></i> <span>{{ trans('admin_message.sidebar.coaches') }}</span></a></li>
            {{--<li {!! Request::is('admin/terms*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/terms') }}"><i class='fa fa-calendar' aria-hidden="true"></i> <span>{{ trans('admin_message.sidebar.terms') }}</span></a></li>--}}



            <li class="dropdown treeview {!! Request::is('admin/terms*') ||  Request::is('admin/termpatterns*') ? 'open active' : '' !!}">
                <a href="#" {!! Request::is('admin/terms*') ||  Request::is('admin/termpatterns*') ? 'class="open"' : '' !!}>
                    <i class="fa fa-clock-o"></i>
                    <span>{{ trans('admin_message.sidebar.terms') }}</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li {!! Request::is('admin/terms*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/terms') }}"><i class='fa fa-calendar'></i> <span>{{ trans('admin_message.sidebar.calendar') }}</span></a></li>
                    <li {!! Request::is('admin/termpatterns*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/termpatterns') }}"><i class='fa fa-cog'></i> <span>{{ trans('admin_message.sidebar.termpatterns') }}</span></a></li>
                </ul>
            </li>

            <li {!! Request::is('admin/photos*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/photos') }}"><i class='fa fa-images'></i> <span>{{ trans('admin_message.sidebar.photo') }}</span></a></li>



            <li class="dropdown treeview {!! Request::is('admin/tags*') ||  Request::is('admin/posts*') ? 'open active' : '' !!}">
                <a href="#" {!! Request::is('admin/tags*') ||  Request::is('admin/posts*') ? 'class="open"' : '' !!}>
                  <i class="fa fa-edit"></i>
                    <span>{{ trans('admin_message.sidebar.blog') }}</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                   <li {!! Request::is('admin/posts*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/posts') }}"><i class='fa fa-newspaper'></i> <span>{{ trans('admin_message.sidebar.post') }}</span></a></li>
                   <li {!! Request::is('admin/tags*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/tags') }}"><i class='fa fa-tags'></i> <span>{{ trans('admin_message.sidebar.tags') }}</span></a></li>
               </ul>
            </li>




           <li {!! Request::is('admin/users*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/users') }}"><i class='fa fa-users'></i> <span>{{ trans('admin_message.sidebar.users') }}</span></a></li>
           <li {!! Request::is('admin/contacts*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/contacts') }}"><i class='fa fa-envelope'></i> <span>{{ trans('admin_message.sidebar.contact') }}</span></a></li>
           <li {!! Request::is('admin/globalconf*') ? 'class="active"' : '' !!}><a href="{{ url('/admin/globalconf') }}"><i class='fa fa-cogs'></i> <span>{{ trans('admin_message.sidebar.global') }}</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->

    </section>
    <!-- /.sidebar -->
</aside>
