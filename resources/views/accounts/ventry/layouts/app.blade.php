<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Voucher System')</title>
    @vite(['resources/js/app.js'])
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ URL::asset('bootstrap/dist/css/bootstrap.min.css') }}">
    <script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('bootstrap-icons/font/bootstrap-icons.min.css') }}">


    <!-- REQUIRED for Bootstrap JS components -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            background: #e9edf1;
            font-family: Tahoma, Arial, sans-serif;
            font-size: 12px;
        }

        /* KEEP YOUR STYLE */
        .page-card {
            background: #fff;
            border: 1px solid #c7ccd1;
            border-radius: 4px;
            margin-bottom: 12px;
        }

        .page-card-header {
            background: linear-gradient(#f7f9fb, #dde3e8);
            padding: 6px 10px;
            font-weight: 600;
            border-bottom: 1px solid #c4cbd2;

            /* Bootstrap alignment fix */
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-card-body {
            padding: 12px;
        }

        /* Bootstrap consistency */
        .form-control,
        .form-select {
            height: 32px;
            font-size: 13px;
        }

        /* Tables */
        .afm-table {
            width: 100%;
        }

        .afm-table th {
            background: #eef2f6;
            font-weight: 600;
        }

        .afm-table td {
            padding: 4px;
            vertical-align: middle;
        }

        /* Fix responsive overflow */
        .table-responsive {
            overflow-x: auto;
        }

        /* Small buttons consistency */
        .btn-sm {
            padding: 2px 8px;
            font-size: 12px;
        }

        .metric-card {
            background: #fff;
            border: 1px solid #dee2e6;
            border-left: 4px solid transparent;
            /* default */
            border-radius: 4px;
            padding: 10px 12px;
        }

        /* COLOR BORDERS */
        .metric-card.accent-blue {
            border-left-color: #0d6efd;
        }

        .metric-card.accent-orange {
            border-left-color: #fd7e14;
        }

        .metric-card.accent-teal {
            border-left-color: #20c997;
        }

        .metric-card.accent-green {
            border-left-color: #198754;
        }

        /* OPTIONAL: clean text */
        .metric-label {
            font-size: 12px;
            color: #6c757d;
        }

        .metric-val {
            font-size: 18px;
            font-weight: 600;
        }

        .metric-sub {
            font-size: 11px;
            color: #6c757d;
        }

        /* NORMAL TAB */
        .nav-tabs .nav-link {
            font-weight: 500;
            border-radius: 6px;
            margin-right: 4px;
            color: #495057 !important;
        }

        /* ACTIVE TAB */
        .nav-tabs .nav-link.active {
            background-color: #0d6efd !important;
            color: #ffffff !important;
            /* 👈 FIX */
            border-color: #0d6efd !important;
        }

        /* HOVER */
        .nav-tabs .nav-link:hover {
            background-color: #e7f1ff;
            color: #0d6efd !important;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .notice-bar {
            background: #f8f9fa;
            border-left: 3px solid #0d6efd;
            padding: 6px 10px;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .page-card-header h6 {
            font-size: 13px;
        }

        .add-panel {
            background: #fdfdfd;
            border: 1px dashed #d0d7de;
            padding: 10px;
            border-radius: 6px;
        }

        #afm-table tbody tr:hover {
            background: #f1f7ff;
        }

        .badge.bg-success {
            background-color: #198754 !important;
        }

        .badge.bg-danger {
            background-color: #dc3545 !important;
        }

        .badge.bg-warning {
            background-color: #ffc107 !important;
            color: #000
        }

        .modal,
        .modal-dialog,
        .modal-backdrop {
            transition: none !important;
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- KEEP YOUR SIDEBAR --}}
    @include('topbar.sidebar')

    <div class="content-wrapper" style="margin-left: 2vw; padding: 2vw;"> @yield('content')
    </div>

    <!-- Bootstrap JS (required for dropdowns, modals, tabs) -->
    <script src="{{ URL::asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ URL::asset('mainjs/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('mainjs/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('mainjs/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('mainjs/buttons.bootstrap5.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('scripts')

</body>

</html>
