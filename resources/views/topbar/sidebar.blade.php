<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FDL ERP</title>

    <link rel="stylesheet" href="{{URL::asset('dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('plugins/fontawesome-free/css/all.min.css')}}">
    <style>

    .main-sidebar {
        background-color: #633974;
        position: relative;
        color: white;

    }

    .sidebar-light-pink .nav-sidebar>.nav-item>.nav-link.active {
        background-color: #e83e8c;
        color: #fff;

    }
    aside  {
  width: 100px;
  overflow: auto;
}
    </style>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="graph1">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light ">
            <!-- Left navbar links -->
            <ul class="navbar-nav navbar-collapse">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button" data-enable-remember="true"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <div class="container-fluid justify-content-center">
                @if (!$headeer==null)
                @foreach($headeer as $headeer)
                <h4 >
                    {{$headeer->sub_menu_name}}
                </h4>
                @endforeach
                @else
                <h4 class="">DD</h4>
                @endif
            </div>
            <!-- Right navbar links -->
            <div class="dropdown">





                <ul class="navbar-nav ml-auto">

                    <!-- Messages Dropdown Menu -->

                    <div class="dropdown show">


                        @foreach($data as $ddata)

                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            {{$ddata->employee_name}}
                        </a>
                        @endforeach
                        <li class="nav-item dropdown">

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a href="{{ route('auth.logout')}}" class="dropdown-item dropdown-footer">Log Out</a>
                            </div>

                        </li>


                </ul>
            </div>
        </nav>
        <!-- /.navbar -->



        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary text-white elevation-4 position-fixed ">
            <!-- Brand Logo -->
            <!-- Sidebar -->
            <div class="sidebar ">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="#" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">FDL ERP</a>
                    </div>
                </div>



                <!-- Sidebar Menu -->
                <nav class="mt-2  overflow-auto vh-100">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-treeview" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        @include('topbar.menu')
                        <li class="nav-item d-sm-inline-block has-treeview menu-close" style="font-size:14px; color:white;">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Report
                                    <span class="right badge badge-danger">New</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item d-sm-inline-block has-treeview menu-close" style="font-size:14px; color:white;">
                            <a href="{{ route('common.gatepass')}}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>GATE PASS
                                    <span class="right badge badge-danger">New</span>
                                </p>
                            </a>
                            
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- 
  Content Wrapper. Contains page content -->


</body>

</html>