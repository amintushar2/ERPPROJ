<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Salary Entry</title>

    {{-- Original assets --}}
    <link rel="stylesheet" href="{{ URL::asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="erpcss/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="erpcss/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="mainjs/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="erpcss/bootstrap.min.css">
    <link rel="stylesheet" href="erpcss/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="erpcss/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="bootstrap_icon/bootstrap-icons.min.css">
    <script src="mainjs/adminlte.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link type="text/css" rel="Stylesheet" href="mainjs/jquery-ui.css" />
    <link href="erpcss/select2.min.css" rel="stylesheet" />
    <link href="erpcss/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ── Design tokens (match sidebar/emplist) ── */
        :root {
            --emp-dark: #1a3a5c;
            --emp-dark2: #2257a0;
            --amber: #f59e0b;
            --body-bg: #f0f4f8;
            --card-bg: #ffffff;
            --border: #cdd8e8;
            --label: #374a5a;
            --input-bg: #fafdff;
            --radius: 4px;
        }

        body {
            background: var(--body-bg) !important;
            font-family: 'Noto Sans', 'Segoe UI', sans-serif;
            font-size: 13px;
        }

        /* ── Select2 fixes ── */
        #ui-datepicker-div {
            display: none;
        }

        .select2-selection__rendered {
            line-height: 28px !important;
        }

        .select2-container .select2-selection--single {
            height: 34px !important;
        }

        .select2-selection__arrow {
            height: 32px !important;
        }

        .select2.select2-container {
            width: 100% !important;
        }

        /* ── Custom utility classes ── */
        .bg-emp-dark {
            background-color: var(--emp-dark) !important;
        }

        .text-amber {
            color: var(--amber) !important;
        }

        .border-amber {
            border-bottom: 2px solid var(--amber) !important;
        }

        .btn-emp-dark {
            background-color: var(--emp-dark);
            border-color: var(--emp-dark);
            color: #fff;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            font-size: 12px;
            border-radius: var(--radius);
            transition: background .15s;
        }

        .btn-emp-dark:hover {
            background-color: var(--emp-dark2);
            border-color: var(--emp-dark2);
            color: #fff;
        }

        /* ── Form labels ── */
        label.col-form-label {
            font-size: 11.5px !important;
            font-weight: 600 !important;
            color: var(--label) !important;
        }

        /* ── Form controls ── */
        .form-control,
        .form-select {
            font-size: 12.5px !important;
            border: 1px solid #bfcfdf !important;
            border-radius: var(--radius) !important;
            background: var(--input-bg) !important;
            color: #1a2a3a !important;
            height: 34px !important;
            padding: 4px 10px !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--emp-dark2) !important;
            box-shadow: 0 0 0 2px rgba(34, 87, 160, .12) !important;
            outline: none;
        }

        /* ── Section card ── */
        .sec-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, .07);
            overflow: hidden;
            margin-bottom: 18px;
        }

        .sec-card-head {
            background: var(--emp-dark);
            border-bottom: 2px solid var(--amber);
            padding: 9px 16px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .sec-card-head span {
            font-family: 'Rajdhani', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #fff;
        }

        .sec-card-head i {
            color: var(--amber);
            font-size: 13px;
        }

        .sec-card-body {
            padding: 18px 20px 10px;
        }

        /* ── Page heading ── */
        .page-heading {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--emp-dark2);
        }

        .page-heading .icon-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 4px;
            background: var(--emp-dark);
        }

        .page-heading h5 {
            font-family: 'Rajdhani', sans-serif;
            font-size: 17px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--emp-dark);
            margin: 0;
            line-height: 1.2;
        }

        .page-heading small {
            font-size: 10px;
            color: #6b7c93;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        /* ── Action bar ── */
        .action-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
            padding: 14px 0 6px;
        }

        .action-bar .btn {
            font-family: 'Rajdhani', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            border-radius: var(--radius);
            padding: 6px 18px;
        }

        /* ── Table ── */
        .emp-table-wrap {
            border-radius: 5px;
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .emp-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .emp-table thead th {
            background: var(--emp-dark) !important;
            color: #fff !important;
            font-family: 'Rajdhani', sans-serif;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 9px 10px;
            border: none !important;
            white-space: nowrap;
            text-align: center;
        }

        .emp-table thead th:first-child {
            text-align: left;
        }

        .emp-table tbody tr:nth-child(even) {
            background: #f2f7fc;
        }

        .emp-table tbody tr:hover {
            background: #e4f0fb !important;
        }

        .emp-table tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #dde8f2 !important;
            border-right: 1px solid #e8f0f8 !important;
            color: #2a3a4a;
            text-align: center;
        }

        .emp-table tbody td:first-child {
            text-align: left;
            font-weight: 600;
            color: var(--emp-dark);
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
</head>

<body>
    @section('title', 'Salary Entry')
    @include('topbar.sidebar')

    <div class="container-fluid">
        <div class="content-wrapper" style="background:#f0f4f8;">
            <div class="container-fluid py-4 px-4">

                {{-- ── Page Header ── --}}
                <div class="page-heading">
                    <div class="icon-badge">
                        <i class="fas fa-money-bill-wave text-amber"></i>
                    </div>
                    <div>
                        <h5>Salary Entry</h5>
                        <small>Payroll Management</small>
                    </div>
                </div>

                {{-- ── Form Card ── --}}
                <form action="" method="" id="salaryForm">
                    <div class="sec-card" style="max-width:680px;">
                        <div class="sec-card-head">
                            <i class="fas fa-sliders-h"></i>
                            <span>Salary Parameters</span>
                        </div>
                        <div class="sec-card-body">

                            {{-- Company Name --}}
                            <div class="mb-3 row align-items-center">
                                <label for="company_idd" class="col-sm-3 col-form-label">Company Name :</label>
                                <div class="col-sm-8">
                                    <select class="form-select" id="company_idd" name="company_name">
                                        @foreach ($compList as $company)
                                            <option value="{{ $company->company_id }}">{{ $company->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Salary Date --}}
                            <div class="mb-3 row align-items-center">
                                <label for="sal_date" class="col-sm-3 col-form-label">Salary Date :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="sal_date" id="sal_date"
                                        placeholder="YYYY-MM-DD" value="{{ old('sal_date') }}">
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="d-grid gap-2 col-sm-8 offset-sm-3 pb-2">
                                <button type="submit" class="btn btn-emp-dark" id="sal_action">
                                    <i class="fas fa-calculator me-1 text-amber"></i> Gross Salary Entry
                                </button>
                            </div>

                        </div>
                    </div>
                </form>

                {{-- ── Salary Data Table ── --}}
                <div class="sec-card">
                    <div class="sec-card-head">
                        <i class="fas fa-table"></i>
                        <span>Salary Records</span>
                    </div>
                    <div class="sec-card-body p-0">
                        <div class="overflow-auto" style="max-width:100%; max-height:2200px;">
                            <table id="sal_table" class="emp-table table table-bordered table-striped"
                                style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Emp No</th>
                                        <th>New Emp ID</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Gross</th>
                                        <th>Basic</th>
                                        <th>Medical</th>
                                        <th>HR</th>
                                        <th>Stamp</th>
                                        <th>Conv'e</th>
                                        <th>Food</th>
                                        <th>Tax</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody id="table_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- ── Action Buttons ── --}}
                <div class="sec-card">
                    <div class="sec-card-body">
                        <div class="action-bar">
                            <button class="btn btn-secondary" type="button">
                                <i class="fas fa-file-invoice-dollar me-1"></i> Gross Entry
                            </button>
                            <button class="btn btn-success" type="submit" id="save_btn">
                                <i class="fas fa-save me-1"></i> Save
                            </button>
                            <button class="btn btn-info text-white" type="button">
                                <i class="fas fa-plus me-1"></i> Add
                            </button>
                            <button class="btn btn-danger" type="button">
                                <i class="fas fa-trash me-1"></i> Delete
                            </button>
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search me-1"></i> Query
                            </button>
                            <button class="btn btn-warning" type="button">
                                <i class="fas fa-sign-out-alt me-1"></i> Exit
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ── Footer ── --}}
    <footer class="main-footer text-center py-2" style="background:#0b1828;border-top:2px solid #f59e0b;">
        <span class="fw-bold text-uppercase"
            style="font-family:'Rajdhani',sans-serif;font-size:12px;letter-spacing:1.5px;color:#f59e0b;">FDL</span>
        <span class="mx-1" style="color:#4a6a8a;">·</span>
        <span class="text-uppercase"
            style="font-family:'Rajdhani',sans-serif;font-size:12px;letter-spacing:1px;color:#94aec4;">Enterprise
            Resource Planning</span>
    </footer>

    {{-- ── Scripts (all original, untouched) ── --}}
    <script src="dtjs/popper.min.js" crossorigin="anonymous"></script>
    <script src="dtjs/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="mainjs/jquery.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('dist/js/adminlte.min.js') }}"></script>
    <script src="mainjs/jquery-ui.js"></script>
    <script src="mainjs/jquery.timepicker.min.js"></script>
    <script src="mainjs/moment.min.js" crossorigin="anonymous"></script>
    <script src="mainjs/jquery.dataTables.min.js"></script>
    <script src="mainjs/moment-duration-format.js"></script>
    <script src="mainjs/select2.min.js"></script>
    <script src="mainjs/sweetalert2.all.min.js"></script>

    {{-- ── All original JS — zero changes ── --}}
    <script>
        $(document).ready(function() {
            $('#company_idd').select2();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#leave').DataTable();
        });
    </script>

    <script>
        $("#sal_date").datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
        });
    </script>

    {{-- <script>
        $(document).ready(function(){
            $(document).on('click','#sal_action',function(e){
                e.preventDefault();

                var companyId = $('#company_idd').val();
                var paydate = $('#sal_date').val();

                // const fd = new FormData(this);

                $.ajax({
                    type: 'GET',
                    url: 'salarydata',
                    data: {
                        'company_id' : companyId,
                        'sal_date' : paydate
                    },
                    success:function(data)
                    {
                        console.log(data);

                        $('#table_data').empty().html(data);
                    },error:function(response){
                        alert('error');
                        console.log(response);
                    }
                });
            });
        });
    </script> --}}

    <script>
        $("#salaryForm").submit(function(e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var companyId = $('#company_idd').val();
            var paydate = $('#sal_date').val();

            $.ajax({
                type: 'GET',
                url: 'savedata',
                data: {
                    'company_id': companyId,
                    'sal_date': paydate
                },
                dataType: 'json',
                complete: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        fetAllFileData();
                    };
                },
                error: function(response) {
                    alert('1st');
                    console.log(response);
                }
            });
        });

        function fetAllFileData() {
            var companyId = $('#company_idd').val();
            $.get("{{ URL::to('showdata') }}" + '/' + companyId, function(data) {
                $('#table_data').empty().html(data);
            });
        }
    </script>

</body>

</html>
