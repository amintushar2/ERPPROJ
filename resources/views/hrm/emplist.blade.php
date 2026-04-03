<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        @include('topbar.sidebar')

        <div class="content-wrapper bg-light">
            <div class="container-fluid py-4 px-4">

                {{-- ── Page Header ── --}}
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom border-primary">
                    <div class="d-flex align-items-center gap-2">
                        <span class="d-inline-flex align-items-center justify-content-center rounded bg-emp-dark"
                            style="width:36px;height:36px;">
                            <i class="fas fa-users text-amber"></i>
                        </span>
                        <div>
                            <h5 class="mb-0 fw-bold text-uppercase text-emp-dark lh-sm"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:1.5px;">Employee List</h5>
                            <small class="text-muted text-uppercase" style="font-size:10px;letter-spacing:.5px;">Human
                                Resource Management</small>
                        </div>
                    </div>
                    <a href="{{ route('empnewentry') }}"
                        class="btn btn-emp-dark btn-sm fw-bold text-uppercase text-white d-inline-flex align-items-center gap-2">
                        <i class="fas fa-plus text-amber"></i> Add New Employee
                    </a>
                </div>

                {{-- ── Card ── --}}
                <div class="card border-0 shadow-sm rounded-1 overflow-hidden">

                    <div
                        class="card-header d-flex align-items-center gap-2 py-2 px-3 border-0 border-bottom border-amber bg-emp-dark">
                        <i class="fas fa-table text-amber" style="font-size:13px;"></i>
                        <span class="fw-bold text-white text-uppercase"
                            style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.5px;">Employee
                            Records</span>
                    </div>

                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover align-middle" id="datatab"
                                style="width:100%;font-size:13px;">
                                <thead>
                                    <tr class="bg-emp-dark">
                                        <th class="text-white text-uppercase fw-bold py-2 px-3 border-0"
                                            style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.2px;white-space:nowrap;background:#1a3a5c;">
                                            Emp No</th>
                                        <th class="text-white text-uppercase fw-bold py-2 px-3 border-0"
                                            style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.2px;white-space:nowrap;background:#1a3a5c;">
                                            New Emp No</th>
                                        <th class="text-white text-uppercase fw-bold py-2 px-3 border-0"
                                            style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.2px;white-space:nowrap;background:#1a3a5c;">
                                            Name</th>
                                        <th class="text-white text-uppercase fw-bold py-2 px-3 border-0"
                                            style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.2px;white-space:nowrap;background:#1a3a5c;">
                                            Father Name</th>
                                        <th class="text-white text-uppercase fw-bold py-2 px-3 border-0"
                                            style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.2px;white-space:nowrap;background:#1a3a5c;">
                                            Mother Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($empList as $emp)
                                        <tr>
                                            <td class="px-3 py-2 fw-semibold">{{ $emp->empno }}</td>
                                            <td class="px-3 py-2">{{ $emp->new_empno }}</td>
                                            <td class="px-3 py-2 fw-medium">{{ $emp->empname }}</td>
                                            <td class="px-3 py-2">{{ $emp->father_name }}</td>
                                            <td class="px-3 py-2">{{ $emp->mother_name }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted fst-italic">
                                                <i class="fas fa-inbox d-block mb-2 text-secondary"
                                                    style="font-size:24px;"></i>
                                                No Data Found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>{{-- /card --}}

            </div>
        </div>{{-- /content-wrapper --}}

        {{-- ── Footer ── --}}
        <footer class="main-footer text-center py-2" style="background:#0b1828;border-top:2px solid #f59e0b;">
            <span class="fw-bold text-uppercase"
                style="font-family:'Rajdhani',sans-serif;font-size:12px;letter-spacing:1.5px;color:#f59e0b;">FDL</span>
            <span class="mx-1" style="color:#4a6a8a;">·</span>
            <span class="text-uppercase"
                style="font-family:'Rajdhani',sans-serif;font-size:12px;letter-spacing:1px;color:#94aec4;">Enterprise
                Resource Planning</span>
        </footer>

    </div>{{-- /wrapper --}}

    {{-- ── Scripts (all original, untouched) ── --}}
    <script src="{{ URL::asset('mainjs/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ URL::asset('mainjs/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('mainjs/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('mainjs/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('mainjs/buttons.bootstrap5.min.js') }}"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&display=swap');

        /* ── Custom utility classes ── */
        .bg-emp-dark {
            background-color: #1a3a5c !important;
        }

        .text-emp-dark {
            color: #1a3a5c !important;
        }

        .text-amber {
            color: #f59e0b !important;
        }

        .border-amber {
            border-bottom: 2px solid #f59e0b !important;
        }

        .btn-emp-dark {
            background-color: #1a3a5c;
            border-color: #1a3a5c;
            border-radius: 4px;
            font-family: 'Rajdhani', sans-serif;
            letter-spacing: 1px;
        }

        .btn-emp-dark:hover {
            background-color: #2257a0;
            border-color: #2257a0;
            color: #fff;
        }

        /* ── DataTables UI overrides ── */
        #datatab_wrapper .dataTables_length label,
        #datatab_wrapper .dataTables_filter label,
        #datatab_wrapper .dataTables_info {
            font-size: 12px;
            color: #6b7c93;
        }

        #datatab_wrapper .dataTables_filter input,
        #datatab_wrapper .dataTables_length select {
            border: 1px solid #bfcfdf;
            border-radius: 4px;
            font-size: 12px;
            padding: 4px 8px;
            color: #1a2a3a;
            background: #fafdff;
        }

        #datatab_wrapper .dataTables_filter input:focus {
            border-color: #2257a0;
            box-shadow: 0 0 0 2px rgba(34, 87, 160, .12);
            outline: none;
        }

        #datatab_wrapper .paginate_button {
            font-size: 12px !important;
            border-radius: 3px !important;
            padding: 4px 10px !important;
            margin: 0 2px !important;
            color: #1a3a5c !important;
            border: 1px solid #cdd8e8 !important;
            background: #fff !important;
        }

        #datatab_wrapper .paginate_button:hover {
            background: #1a3a5c !important;
            color: #fff !important;
            border-color: #1a3a5c !important;
        }

        #datatab_wrapper .paginate_button.current,
        #datatab_wrapper .paginate_button.current:hover {
            background: #1a3a5c !important;
            color: #fff !important;
            border-color: #1a3a5c !important;
            font-weight: 700 !important;
        }

        #datatab_wrapper .paginate_button.disabled,
        #datatab_wrapper .paginate_button.disabled:hover {
            color: #bfcfdf !important;
            background: #f6f9fc !important;
            border-color: #e0eaf4 !important;
        }

        /* ── Table rows ── */
        #datatab tbody tr:nth-child(even) {
            background-color: #f2f7fc;
        }

        #datatab tbody tr:hover {
            background-color: #e4f0fb !important;
        }

        #datatab td {
            border-color: #dde8f2;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #f0f4f8;
        }

        ::-webkit-scrollbar-thumb {
            background: #9ab4cc;
            border-radius: 3px;
        }
    </style>

    <script>
        $(function() {
            $('#datatab').DataTable({
                responsive: true,
                lengthChange: true,
                autoWidth: false
            });
        });
    </script>

</body>
