<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Item Received Entry')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: #f1f3f5;
            font-size: 13px;
        }

        /* ── TOP NAV ── */
        .app-navbar {
            background: #fff;
            border-bottom: 2px solid #2563eb;
            padding: 0 1rem;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .app-navbar .nav-title {
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .app-navbar .nav-title .badge {
            font-size: 10px;
            font-weight: 500;
            letter-spacing: .03em;
        }

        .app-navbar .nav-actions {
            display: flex;
            gap: 5px;
        }

        /* ── PAGE WRAPPER ── */
        .page-wrap {
            padding: 14px 18px;
        }

        /* ── SECTION CARD ── */
        .section-card {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            background: #fff;
            margin-bottom: 14px;
            overflow: hidden;
        }

        .section-card .section-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 7px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-header-left {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .section-title {
            font-size: 12px;
            font-weight: 600;
            color: #343a40;
            margin: 0;
        }

        .section-badge {
            font-size: 10px;
            font-family: monospace;
            background: #e9ecef;
            color: #6c757d;
            padding: 1px 7px;
            border-radius: 3px;
            border: 1px solid #dee2e6;
        }

        /* ── FIELDS GRID ── */
        .fields-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            padding: 12px 14px;
        }

        .fields-grid .span2 {
            grid-column: span 2;
        }

        .field-label {
            font-size: 10px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: 3px;
            display: block;
        }

        .field-label .req {
            color: #dc3545;
        }

        .form-control,
        .form-select {
            font-size: 12px;
            padding: 5px 8px;
            height: auto;
            border-radius: 4px;
            border: 1px solid #ced4da;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, .15);
        }

        .form-control[readonly] {
            background: #f8f9fa;
            color: #6c757d;
        }

        /* ── GRID TABLE ── */
        .grid-table-wrap {
            padding: 0 14px;
            overflow-x: auto;
        }

        .grid-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin: 0;
        }

        .grid-table thead th {
            background: #f1f3f5;
            padding: 7px 8px;
            font-size: 10px;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: .03em;
        }

        .grid-table tbody tr {
            border-bottom: 1px solid #f1f3f5;
        }

        .grid-table tbody tr:hover {
            background: #f8f9fa;
        }

        .grid-table tbody td {
            padding: 3px 5px;
            vertical-align: middle;
        }

        .grid-table tfoot td {
            background: #f8f9fa;
            border-top: 2px solid #dee2e6;
            padding: 7px 8px;
            font-weight: 600;
            font-size: 12px;
        }

        .td-input {
            width: 100%;
            padding: 3px 7px;
            border: 1px solid #e0e3e7;
            border-radius: 4px;
            font-size: 12px;
            font-family: inherit;
            outline: none;
            background: #fff;
        }

        .td-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, .1);
        }

        .row-no {
            color: #adb5bd;
            font-family: monospace;
            font-size: 10px;
            text-align: center;
            width: 30px;
        }

        .total-val {
            font-family: monospace;
            color: #1d4ed8;
            font-weight: 600;
            font-size: 13px;
        }

        /* ── ADD ROW BUTTON ── */
        .add-row-wrap {
            padding: 7px 14px 10px;
        }

        .add-row-btn {
            width: 100%;
            background: #f0fdf4;
            color: #16a34a;
            border: 1px dashed #86efac;
            border-radius: 5px;
            padding: 5px;
            font-size: 12px;
            cursor: pointer;
            text-align: center;
        }

        .add-row-btn:hover {
            background: #dcfce7;
        }

        /* ── TABLE (index) ── */
        .data-table thead th {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
            background: #f1f3f5;
            color: #495057;
        }

        .data-table tbody td {
            font-size: 12px;
            vertical-align: middle;
            padding: 7px 10px;
        }

        .data-table tbody tr:hover {
            background: #f8f9fa;
        }

        /* ── MONO ── */
        .mono {
            font-family: monospace;
            font-size: 11px;
        }

        /* ── PAGINATION ── */
        .pagination {
            gap: 2px;
        }

        .page-link {
            font-size: 11px;
            padding: 4px 9px;
            color: #2563eb;
            border-color: #dee2e6;
            font-family: monospace;
        }

        .page-item.active .page-link {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .page-item.disabled .page-link {
            color: #adb5bd;
        }

        /* ── SEARCH TOOLBAR ── */
        .toolbar {
            padding: 8px 14px;
            border-bottom: 1px solid #f1f3f5;
            display: flex;
            gap: 7px;
            align-items: center;
        }

        /* ── BTN SIZES ── */
        .btn {
            font-size: 12px;
            font-weight: 500;
        }

        .btn-sm {
            font-size: 11px;
            padding: 3px 9px;
        }

        .btn-xs {
            font-size: 10px;
            padding: 2px 7px;
            line-height: 1.5;
        }

        .btn-app-save {
            background: #16a34a;
            color: #fff;
            border-color: #16a34a;
        }

        .btn-app-save:hover {
            background: #15803d;
            color: #fff;
        }

        .btn-app-delete {
            background: #dc3545;
            color: #fff;
            border-color: #dc3545;
        }

        .btn-app-pocheck {
            background: #f59e0b;
            color: #fff;
            border-color: #f59e0b;
        }

        .btn-app-summary {
            background: #0d6efd;
            color: #fff;
            border-color: #0d6efd;
        }

        .btn-app-exit {
            background: transparent;
            color: #d1d5db;
            border-color: #4b5563;
        }

        .btn-app-exit:hover {
            background: #374151;
            color: #fff;
        }

        /* ── DETAIL FIELD LABEL ── */
        .detail-label {
            background: #f1f5f9;
            padding: 8px 14px;
            font-size: 11px;
            color: #64748b;
        }

        .pagination-wrap {
            padding: 8px 14px;
            border-top: 1px solid #f1f3f5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .page-info {
            font-size: 11px;
            color: #6c757d;
        }


        .table.mono tbody td,
        .table.mono thead th {
            padding-top: 1px !important;
            padding-bottom: 1px !important;
            padding-left: 4px !important;
            padding-right: 4px !important;
            vertical-align: middle !important;
            line-height: 0.8 !important;
            font-size: 14px !important;
            /* Slightly smaller text helps the row shrink */
        }

        /* Minimize the badge size inside the Received No column */
        .table.mono .badge {
            padding: 1px 4px !important;
            font-size: 14px !important;
        }

        /* Ensure the action buttons don't stretch the row height */
        .table.mono .btn-xs {
            padding: 1px 5px !important;
            font-size: 10px !important;
            line-height: 1.2 !important;
        }

        /* Optional: Force a maximum height if padding isn't enough */
        .table.mono tbody tr {
            height: 10px !important;
        }

        /* 🔥 ERP GRID STYLE */
        .td-input {
            width: 100%;
            border: none;
            font-size: 11px;
            padding: 3px 4px;
            background: transparent;
        }

        .td-input:focus {
            outline: none;
            background: #fff;
            border: 1px solid #0d6efd;
        }

        /* TABLE */
        .grid-table td {
            padding: 2px 4px;
            vertical-align: middle;
        }

        .grid-table th {
            font-size: 10px;
            padding: 4px;
        }

        /* LOV */
        .lov-row {
            display: grid;
            grid-template-columns: 120px 1fr 100px;
            padding: 6px 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            font-size: 12px;
        }

        .lov-row:hover {
            background: #f1f3f5;
        }

        .lov-id {
            color: #0d6efd;
            font-weight: 500;
        }

        .lov-qty {
            text-align: right;
            color: #6c757d;
        }

        /* BUTTON SMALL */
        .btn-xs {
            padding: 2px 6px;
            font-size: 10px;
        }

        /* TOTAL STYLE */
        .total-val {
            font-weight: 600;
            font-size: 12px;
        }
    </style>
</head>

<body>
    @include('topbar.sidebar')
    <div class="content-wrapper">
        <nav class="app-navbar">
            <div class="nav-title mb-0 text-primary">
                <i class="bi bi-receipt text-primary"></i>
                @yield('nav-title', 'Item Received Entry')
                @yield('nav-badge')
            </div>
            <div class="nav-actions">
                @yield('nav-actions')
            </div>
        </nav>

        <div class="page-wrap">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show py-2 px-3 mb-3" style="font-size:12px;"
                    role="alert">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show py-2 px-3 mb-3" style="font-size:12px;"
                    role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger py-2 px-3 mb-3" style="font-size:12px;">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
<script src="{{ URL::asset('mainjs/jquery.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('dist/js/adminlte.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/buttons.bootstrap5.min.js') }}"></script>
