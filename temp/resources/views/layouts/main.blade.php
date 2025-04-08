<!DOCTYPE html>
<html lang="en">
@include('parts.head')
<body class="hold-transition sidebar-mini layout-fixed wrapper-in">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{asset($asset_theme.'dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60"
             width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li>
                <br/>
            </li>

            {{--            <!-- Messages Dropdown Menu -->--}}
            {{--            <li class="nav-item dropdown">--}}
            {{--                <a class="nav-link" data-toggle="dropdown" href="#">--}}
            {{--                    <i class="far fa-comments"></i>--}}
            {{--                    <span class="badge badge-danger navbar-badge">3</span>--}}
            {{--                </a>--}}
            {{--                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
            {{--                    <a href="#" class="dropdown-item">--}}
            {{--                        <!-- Message Start -->--}}
            {{--                        <div class="media">--}}
            {{--                            <img src="{{asset($asset_theme.'dist/img/user1-128x128.jpg')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">--}}
            {{--                            <div class="media-body">--}}
            {{--                                <h3 class="dropdown-item-title">--}}
            {{--                                    Brad Diesel--}}
            {{--                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>--}}
            {{--                                </h3>--}}
            {{--                                <p class="text-sm">Call me whenever you can...</p>--}}
            {{--                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                        <!-- Message End -->--}}
            {{--                    </a>--}}
            {{--                    <div class="dropdown-divider"></div>--}}
            {{--                    <a href="#" class="dropdown-item">--}}
            {{--                        <!-- Message Start -->--}}
            {{--                        <div class="media">--}}
            {{--                            <img src="{{asset($asset_theme.'dist/img/user8-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">--}}
            {{--                            <div class="media-body">--}}
            {{--                                <h3 class="dropdown-item-title">--}}
            {{--                                    John Pierce--}}
            {{--                                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>--}}
            {{--                                </h3>--}}
            {{--                                <p class="text-sm">I got your message bro</p>--}}
            {{--                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                        <!-- Message End -->--}}
            {{--                    </a>--}}
            {{--                    <div class="dropdown-divider"></div>--}}
            {{--                    <a href="#" class="dropdown-item">--}}
            {{--                        <!-- Message Start -->--}}
            {{--                        <div class="media">--}}
            {{--                            <img src="{{asset($asset_theme.'dist/img/user3-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">--}}
            {{--                            <div class="media-body">--}}
            {{--                                <h3 class="dropdown-item-title">--}}
            {{--                                    Nora Silvester--}}
            {{--                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>--}}
            {{--                                </h3>--}}
            {{--                                <p class="text-sm">The subject goes here</p>--}}
            {{--                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                        <!-- Message End -->--}}
            {{--                    </a>--}}
            {{--                    <div class="dropdown-divider"></div>--}}
            {{--                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>--}}
            {{--                </div>--}}
            {{--            </li>--}}
                        <!-- Notifications Dropdown Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link" data-toggle="dropdown" href="#">
                                {{__('messages.profile')}}
                                <i class="right fas fa-angle-down"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                <a href="{{url('/'.app()->getLocale().'/site/logout')}}" class="dropdown-item">
                                    {{__('messages.exit')}}
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>
                            </div>
                        </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{url('')}}" class="brand-link">
            <img src="{{asset($asset_theme.'dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">SYSTEM</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{asset($asset_theme.'dist/img/user.png')}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a class="d-block">{{$user['name_'.app()->getLocale()]}}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->


            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    @if(isset($user['username']))
                    <li class="nav-item">
                        <a href="{{url('/'.app()->getLocale().'/cabinet/list/'.$user['username'])}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                {{__('messages.'.$user['username'])}}
                                <span class="right badge badge-danger">New</span>
                            </p>
                        </a>
                    </li>
                    @endif

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper wrapper-in">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2024 -  Разработано в «OOO QQM-IT SOLUTION»</strong>
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0</strong>
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@include('parts.footer_scripts')

@include('parts.bottom')


</body>
</html>
