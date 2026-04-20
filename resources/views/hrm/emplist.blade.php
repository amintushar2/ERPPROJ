<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">

    <div class="wrapper">

        {{-- ── Sidebar (carries $data, $menu, $submenu, $submenu2, $headeer
                 shared automatically by BaseController) ── --}}
        @include('topbar.sidebar')

        <div class="content-wrapper bg-light">
            <div class="container-fluid py-4 px-4">

                {{-- ── Flash messages ── --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show py-2 mb-3" role="alert"
                        style="font-size:13px;border-left:4px solid #198754;">
                        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('fail'))
                    <div class="alert alert-danger alert-dismissible fade show py-2 mb-3" role="alert"
                        style="font-size:13px;border-left:4px solid #dc3545;">
                        <i class="fas fa-exclamation-circle me-1"></i> {{ session('fail') }}
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- ── Page Header ── --}}
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2"
                    style="border-bottom:2px solid #f59e0b;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="d-inline-flex align-items-center justify-content-center rounded"
                            style="width:36px;height:36px;background:#0b1828;">
                            <i class="fas fa-users" style="color:#f59e0b;"></i>
                        </span>
                        <div>
                            <h5 class="mb-0 fw-bold text-uppercase lh-sm"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:1.5px;color:#0b1828;">
                                Employee List
                            </h5>
                            <small class="text-muted text-uppercase" style="font-size:10px;letter-spacing:.5px;">
                                Human Resource Management
                            </small>
                        </div>
                    </div>
                    <a href="{{ route('empnewentry') }}"
                        class="btn btn-sm fw-bold text-uppercase text-white d-inline-flex align-items-center gap-2"
                        style="background:#1a3a5c;border-color:#1a3a5c;border-radius:4px;
                              font-family:'Rajdhani',sans-serif;letter-spacing:1px;">
                        <i class="fas fa-plus" style="color:#f59e0b;"></i> Add New Employee
                    </a>
                </div>

                {{-- ── Card ── --}}
                <div class="card border-0 shadow-sm rounded-1 overflow-hidden">

                    <div class="card-header d-flex align-items-center gap-2 py-2 px-3 border-0"
                        style="background:#1a3a5c;border-bottom:2px solid #f59e0b;">
                        <i class="fas fa-table" style="color:#f59e0b;font-size:13px;"></i>
                        <span class="fw-bold text-white text-uppercase"
                            style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.5px;">
                            Employee Records
                        </span>
                        <span class="ms-auto badge" style="background:#f59e0b;color:#0b1828;font-size:11px;">
                            {{ $empList->count() }} Total
                        </span>
                    </div>

                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover align-middle" id="datatab"
                                style="width:100%;font-size:13px;">
                                <thead>
                                    <tr>
                                        <th
                                            style="background:#1a3a5c;color:#fff;font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.2px;">
                                            #</th>
                                        <th
                                            style="background:#1a3a5c;color:#fff;font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.2px;white-space:nowrap;">
                                            Emp No</th>
                                        <th
                                            style="background:#1a3a5c;color:#fff;font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.2px;white-space:nowrap;">
                                            New Emp No</th>
                                        <th
                                            style="background:#1a3a5c;color:#fff;font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.2px;">
                                            Name</th>
                                        <th
                                            style="background:#1a3a5c;color:#fff;font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.2px;white-space:nowrap;">
                                            Father Name</th>
                                        <th
                                            style="background:#1a3a5c;color:#fff;font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.2px;white-space:nowrap;">
                                            Mother Name</th>
                                        <th
                                            style="background:#1a3a5c;color:#fff;font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.2px;text-align:center;">
                                            Sex</th>
                                        <th
                                            style="background:#1a3a5c;color:#fff;font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.2px;text-align:center;">
                                            Status</th>
                                        <th
                                            style="background:#1a3a5c;color:#fff;font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:1.2px;text-align:center;white-space:nowrap;">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($empList as $i => $emp)
                                        <tr>
                                            <td class="px-3 py-2 text-muted" style="font-size:11px;">{{ $i + 1 }}
                                            </td>
                                            <td class="px-3 py-2 fw-semibold">{{ $emp->empno }}</td>
                                            <td class="px-3 py-2">{{ $emp->new_empno }}</td>
                                            <td class="px-3 py-2 fw-medium">{{ $emp->empname }}</td>
                                            <td class="px-3 py-2">{{ $emp->father_name }}</td>
                                            <td class="px-3 py-2">{{ $emp->mother_name }}</td>
                                            <td class="px-3 py-2 text-center">
                                                @php $sex = strtolower($emp->sex ?? ''); @endphp
                                                @if ($sex == 'male' || $sex == 'm')
                                                    <span class="badge"
                                                        style="background:#dbeafe;color:#1e40af;font-size:10px;">
                                                        <i class="fas fa-mars me-1"></i>Male
                                                    </span>
                                                @elseif($sex == 'female' || $sex == 'f')
                                                    <span class="badge"
                                                        style="background:#fce7f3;color:#9d174d;font-size:10px;">
                                                        <i class="fas fa-venus me-1"></i>Female
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary"
                                                        style="font-size:10px;">{{ $emp->sex }}</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 text-center">
                                                @if (strtolower($emp->status ?? '') == 'active')
                                                    <span class="badge"
                                                        style="background:#dcfce7;color:#166534;font-size:10px;">
                                                        <i class="fas fa-circle me-1" style="font-size:7px;"></i>Active
                                                    </span>
                                                @else
                                                    <span class="badge"
                                                        style="background:#fee2e2;color:#991b1b;font-size:10px;">
                                                        <i class="fas fa-circle me-1"
                                                            style="font-size:7px;"></i>{{ $emp->status ?? 'N/A' }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 text-center" style="white-space:nowrap;">
                                                <a href="{{ route('empedit', $emp->empno) }}" class="btn btn-sm me-1"
                                                    style="background:#1a3a5c;color:#f59e0b;border:none;
                                                          border-radius:4px;padding:3px 10px;font-size:11px;"
                                                    title="Edit Employee">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </a>
                                                <a href="{{ route('empedit', $emp->empno) }}" class="btn btn-sm"
                                                    style="background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;
                                                          border-radius:4px;padding:3px 10px;font-size:11px;"
                                                    title="View Details">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5 text-muted fst-italic">
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

        <footer class="main-footer text-center py-2" style="background:#0b1828;border-top:2px solid #f59e0b;">
            <span class="fw-bold text-uppercase"
                style="font-family:'Rajdhani',sans-serif;font-size:12px;letter-spacing:1.5px;color:#f59e0b;">FDL</span>
            <span class="mx-1" style="color:#4a6a8a;">·</span>
            <span class="text-uppercase"
                style="font-family:'Rajdhani',sans-serif;font-size:12px;letter-spacing:1px;color:#94aec4;">
                Enterprise Resource Planning
            </span>
        </footer>

    </div>{{-- /wrapper --}}

    <script src="{{ URL::asset('mainjs/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ URL::asset('mainjs/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('mainjs/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('mainjs/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('mainjs/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('mainjs/lov_helper.js') }}"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&display=swap');

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
            border-color: #1a3a5c;
            box-shadow: 0 0 0 2px rgba(26, 58, 92, .12);
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

        #datatab tbody tr:nth-child(even) {
            background-color: #f2f7fc;
        }

        #datatab tbody tr:hover {
            background-color: #e4f0fb !important;
        }

        #datatab td {
            border-color: #dde8f2;
        }

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
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    targets: [0, 8]
                }],
                order: [
                    [1, 'asc']
                ]
            });
        });
    </script>

</body>
