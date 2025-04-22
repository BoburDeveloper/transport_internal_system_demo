<!DOCTYPE html>
<html lang="en">
@include('parts.head')
<body class="hold-transition sidebar-mini layout-fixed wrapper-in">
<style>
    .wrapper-in{
        background-image:url({{asset('/img/bg3.png')}});

    }
</style>

<script type="text/javascript">
    
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var lang_url = '{{url('/'.app()->getLocale())}}';

</script>

<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{asset('img/icon.png')}}" alt="AdminLTELogo" height="60"
             width="60">
        <span>{{__('messages.system_title')}}</span>
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link pushmenu" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            @if(isset($page_document) and $page_document==DOCUMENT)
                <li>
                    <button class="btn btn-default mt-1" onclick="printDiv('document-card')" > <i class="fa fa-print"></i> </button>
                </li>
            @endif
          <!-- Languages bar-->
                    <li class="nav-item dropdown">
                    @php 
                    $lang = app()->getLocale();
                    @endphp
                            <a class="nav-link" data-toggle="dropdown" href="#">
                                {{mb_strtoupper($lang, 'UTF-8')}}
                                <i class="right fas fa-angle-down"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                @php
                                    $all_languages = config('app.locales');
                                    $current_lang_index = array_search($lang, $all_languages);
                                    unset($all_languages[$current_lang_index]);
                                    $current_url = \Request::getRequestUri();
                                @endphp
                                @foreach($all_languages as $key => $value)
                                @php
                                    $second_current_url = strtr($current_url, [$lang=>$value]);
                                @endphp
                                <a href="{{$second_current_url}}" class="dropdown-item">
                                    {{mb_strtoupper($value, 'UTF-8')}}
                                </a>
                                @endforeach
                            </div>
                        </li>

                        <!-- Profile exit menu -->
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
            <img src="{{asset('img/icon.png')}}" alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{__('messages.system_title')}}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar layout-sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex sidebar-user-panel">
                <div class="image">
                    <i class="fas fa-user-alt fa-lg user-icon"></i>
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
                        <a href="{{url('/'.app()->getLocale().'/cabinet/list/'.$user['role_name'])}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                @if(isset($user['post_name_'.app()->getLocale()]))
                                    {{$user['post_name_'.app()->getLocale()]}}
                                @else
                                    {{__('messages.role_label'.$user['role_id'])}}
                                @endif
                                
                               
                                <span class="right badge badge-danger">New</span>
                            </p>
                        </a>
                    </li>
                    @endif

                </ul>
            </nav>
            
            <div class="form-inline mt-3">
                <form action="{{url('/'.app()->getLocale().'/cabinet/list/'.$user['role_name'])}}" method="get">
                @php
                    $column = 'govnumber';
                @endphp
                <div class="input-group">
                    <input class="form-control form-control-sidebar" name="filter[{{$column}}]" type="search" placeholder="{{__('messages.'.$column)}}" value="{{isset($filter[$column]) ? $filter[$column] : null}}" required>
                    <div class="input-group-append">
                        <button class="btn btn-sidebar" type="submit">
                        <i class="fas fa-search fa-fw"></i>
                        </button>
                        @if(isset($filter[$column]))
                            <a href="{{url('/'.app()->getLocale().'/cabinet/list/'.$user['role_name'])}}" class="btn btn-sidebar clear-btn"><b>X</b></a>
                        @endif
                    </div>
                </div>
                </form>
            </div>

        <nav class="mt-3">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-header line-top">
                       
                    </li>
                    @if(in_array($user['role_name'], [DISPATCHER, DIRECTOR]))
                    <li class="nav-item">
                        <a href="{{url('/'.app()->getLocale().'/settings/routes')}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            {{__('messages.routes')}}
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>

            <div class="sidebar-copyright">
                <h2 class="sidebar-title">{{__('messages.system_description')}}</h2>
                <div class="technic-support">
                    <p>{{__('messages.contacts_for_questions')}}: </p> <a href="https://t.me/+oWooOHOr3IM2OGEy" class="mt-4">Telegram support</a>
                </div>

            </div>
            <div class="clearfix"></div>
            <!-- /.sidebar-menu -->
            @include('layouts.version')
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper wrapper-in">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      @include('layouts.copyright')
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
