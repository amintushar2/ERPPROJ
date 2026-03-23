<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FDL ERP</title>

    <link rel="stylesheet" href="{{ URL::asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins/fontawesome-free/css/all.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    
    <!-- Left -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Center Title -->
    <div class="container-fluid justify-content-center">
        @if (!empty($headeer))
            @foreach($headeer as $h)
                <h4>{{ $h->sub_menu_name }}</h4>
            @endforeach
        @else
            <h4>Dashboard</h4>
        @endif
    </div>

    <!-- Right -->
    <ul class="navbar-nav ml-auto">
        @foreach($data as $d)
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown">
                    {{ $d->employee_name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('auth.logout') }}" class="dropdown-item">
                        Log Out
                    </a>
                </div>
            </li>
        @endforeach
    </ul>

</nav>

<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <div class="sidebar">

        <!-- Logo -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">FDL ERP</a>
            </div>
        </div>

        <!-- Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" data-accordion="false">

                @include('topbar.menu')

                <!-- Static Item -->
                <li class="nav-item">
                    <a href="{{ route('common.gatepass') }}" class="nav-link {{ request()->is('common/gatepass') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Gate Pass</p>
                    </a>
                </li>

            </ul>
        </nav>

    </div>
</aside>