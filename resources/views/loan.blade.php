<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee Loan Entry</title>

    {{-- Original assets --}}
    <link rel="stylesheet" href="{{ URL::asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"
        integrity="sha512-KBeR1NhClUySj9xBB0+KRqYLPkM6VvXiiWaSz/8LCQNdRpUm38SWUrj0ccNDNSkwCD9qPA4KobLliG26yPppJA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=Noto+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">

    <style>
        /* ── Design tokens ── */
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
            --input-h: 32px;
        }

        body {
            background: var(--body-bg) !important;
            font-family: 'Noto Sans', 'Segoe UI', sans-serif;
            font-size: 13px;
        }

        /* ── Custom utilities ── */
        .bg-emp-dark {
            background-color: var(--emp-dark) !important;
        }

        .text-amber {
            color: var(--amber) !important;
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
        }

        .btn-emp-dark:hover {
            background-color: var(--emp-dark2);
            border-color: var(--emp-dark2);
            color: #fff;
        }

        /* ── Section card ── */
        .sec-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, .07);
            margin-bottom: 18px;
            overflow: hidden;
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
            padding: 16px 20px 10px;
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
            height: var(--input-h) !important;
            padding: 3px 9px !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--emp-dark2) !important;
            box-shadow: 0 0 0 2px rgba(34, 87, 160, .12) !important;
            outline: none;
        }

        .form-control[readonly] {
            background: #edf3f9 !important;
            color: #5a7a9a !important;
        }

        /* ── Action bar ── */
        .action-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
            padding: 12px 0 6px;
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

        /* ── Installment table ── */
        .install-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .install-table thead th {
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

        .install-table tbody tr:nth-child(even) {
            background: #f2f7fc;
        }

        .install-table tbody tr:hover {
            background: #e4f0fb !important;
        }

        .install-table tbody td {
            padding: 5px 7px;
            border-bottom: 1px solid #dde8f2 !important;
            border-right: 1px solid #e8f0f8 !important;
            text-align: center;
        }

        .install-table .form-control {
            height: 28px !important;
            font-size: 11.5px !important;
            padding: 2px 6px !important;
        }

        /* ── Divider ── */
        hr.sec-hr {
            border: none;
            border-top: 1.5px dashed #d0dceb;
            margin: 10px 0;
        }

        /* row spacing */
        .row.p-1 {
            padding: 4px 0 !important;
        }

        .mb-3 {
            margin-bottom: 10px !important;
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
    @section('title', 'Page Title')
    @include('topbar.sidebar')

    <div class="container-fluid">
        <div class="content-wrapper" style="background:#f0f4f8;">
            <div class="container-fluid py-4 px-4">

                {{-- ── Page Header ── --}}
                <div class="page-heading">
                    <div class="icon-badge">
                        <i class="fas fa-hand-holding-usd text-amber"></i>
                    </div>
                    <div>
                        <h5>Employee Loan Entry</h5>
                        <small>Loan & Installment Management</small>
                    </div>
                </div>

                {{-- ── Main Form ── --}}
                <div class="row">
                    <form id="insert_form">
                        @csrf

                        {{-- Employee & Loan Info --}}
                        <div class="sec-card">
                            <div class="sec-card-head">
                                <i class="fas fa-user-tie"></i>
                                <span>Employee Information</span>
                            </div>
                            <div class="sec-card-body">

                                <div class="row">
                                    {{-- Company Name --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="company_no" class="col-sm-4 col-form-label">Company Name
                                                :</label>
                                            <div class="col-sm-7">
                                                <select class="form-select" name="company_no" id="company_no"
                                                    aria-label="Default select example">
                                                    <option selected>Select One</option>
                                                    @foreach ($getCompany as $getCompany)
                                                        <option value="{{ $getCompany->company_id }}">
                                                            {{ $getCompany->company_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Loan App No --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="loan_app_name" class="col-sm-4 col-form-label">Loan App No
                                                :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="loan_app_name"
                                                    name="loan_app_name" value="{{ old('loan_app_no') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- EMP NO --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="emp_no" class="col-sm-4 col-form-label">EMP NO :</label>
                                            <div class="col-sm-7">
                                                <input type="text" list="empno_list" class="form-control"
                                                    id="emp_no" name="emp_no" value="{{ old('empno') }}">
                                                <datalist id="empno_list"></datalist>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Employee Name --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="emp_name" class="col-sm-4 col-form-label">Employee Name
                                                :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="emp_name"
                                                    name="emp_name" value="{{ old('emp_name') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Department --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="dept_no" class="col-sm-4 col-form-label">Department :</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="dept_no" id="dept_no"
                                                    value="{{ old('dept_no') }}" readonly>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="dept_name"
                                                    id="dept_name" value="{{ old('dept_name') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Designation --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="designation" class="col-sm-4 col-form-label">Designation
                                                :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="designation"
                                                    id="designation" value="{{ old('designation') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Joining Date --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="joining_date" class="col-sm-4 col-form-label">Joining Date
                                                :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="joining_date"
                                                    id="joining_date" value="{{ old('joining_date') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Section --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="section_no" class="col-sm-4 col-form-label">Section :</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="section_no"
                                                    id="section_no" value="{{ old('section_no') }}" readonly>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control w-50" name="section_name"
                                                    id="section_name" value="{{ old('section_name') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Gross Amount --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="gross_amount" class="col-sm-4 col-form-label">Gross Amount
                                                :</label>
                                            <div class="col-sm-7">
                                                <input type="number" class="form-control" name="gross_amount"
                                                    id="gross_amount" value="{{ old('gross_amount') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Loan Approved Date --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="loan_approved_date" class="col-sm-4 col-form-label">Loan
                                                Approved Date :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="loan_approved_date"
                                                    id="loan_approved_date" value="{{ old('loan_approved_date') }}"
                                                    placeholder="YYYY-MM-DD">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Loan Parameters --}}
                        <div class="sec-card">
                            <div class="sec-card-head">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span>Loan Parameters</span>
                            </div>
                            <div class="sec-card-body">

                                <div class="row">
                                    {{-- Application Date --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="application_date" class="col-sm-4 col-form-label">Application
                                                Date :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="application_date"
                                                    id="application_date" value="{{ old('application_date') }}"
                                                    placeholder="YYYY-MM-DD">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- New Install Date --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="new_instt_date" class="col-sm-4 col-form-label">New Install
                                                Date :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="new_instt_date"
                                                    id="new_instt_date" value="{{ old('new_instt_date') }}"
                                                    placeholder="YYYY-MM-DD">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- First Install Date --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="first_install_date" class="col-sm-4 col-form-label">First
                                                Install Date :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="first_install_date"
                                                    id="first_install_date" value="{{ old('first_install_date') }}"
                                                    placeholder="YYYY-MM-DD">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Sanction Amount --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="sanction_amount" class="col-sm-4 col-form-label">Sanction
                                                Amount :</label>
                                            <div class="col-sm-7">
                                                <input type="number" class="form-control" name="sanction_amount"
                                                    id="sanction_amount" value="{{ old('sanction_amount') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Installment Size --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="installment_size" class="col-sm-4 col-form-label">Installment
                                                Size :</label>
                                            <div class="col-sm-7">
                                                <input type="number" class="form-control" name="installment_size"
                                                    id="installment_size" value="{{ old('installment_size') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Period --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="period" class="col-sm-4 col-form-label">Period :</label>
                                            <div class="col-sm-7">
                                                <input type="number" class="form-control" name="period"
                                                    id="period" value="{{ old('period') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- New Period --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="new_period" class="col-sm-4 col-form-label">New Period
                                                :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="new_period"
                                                    id="new_period" value="{{ old('new_period') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Pre Loan Amount --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="pre_loan_amount" class="col-sm-4 col-form-label">Pre Loan
                                                Amount :</label>
                                            <div class="col-sm-7">
                                                <input type="number" class="form-control" name="pre_loan_amount"
                                                    id="pre_loan_amount" value="{{ old('pre_loan_amount') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Pre Balance Amount --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="pre_balance_amount" class="col-sm-4 col-form-label">Pre
                                                Balance Amount :</label>
                                            <div class="col-sm-7">
                                                <input type="number" class="form-control" name="pre_balance_amount"
                                                    id="pre_balance_amount" value="{{ old('pre_balance_amount') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Reference Name --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="ref_name" class="col-sm-4 col-form-label">Reference Name
                                                :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="ref_name"
                                                    id="ref_name" value="{{ old('ref_name') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Ref Des Name --}}
                                    <div class="col-md-6">
                                        <div class="row p-1">
                                            <label for="ref_des_name" class="col-sm-4 col-form-label">Ref Des Name
                                                :</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="ref_des_name"
                                                    id="ref_des_name" value="{{ old('ref_des_name') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Session alerts --}}
                        @if (Session::get('delet'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ Session::get('delet') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if (Session::get('deletef'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ Session::get('deletef') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        {{-- Save / Cancel --}}
                        <div class="action-bar mb-3">
                            <button class="btn btn-success" type="submit" id="insert_btn">
                                <i class="fas fa-save me-1"></i> Save
                            </button>
                            <button class="btn btn-danger" type="button">
                                <i class="fas fa-times me-1"></i> Cancel
                            </button>
                        </div>

                    </form>
                </div>

                {{-- ── Installment Schedule Table ── --}}
                <div class="sec-card">
                    <div class="sec-card-head">
                        <i class="fas fa-table"></i>
                        <span>Installment Schedule</span>
                    </div>
                    <div class="sec-card-body p-0">
                        <div class="overflow-auto" style="max-width:100%; max-height:2200px;">
                            <form action="" name="add_item" id="add_item" class="form-inline">
                                <table class="install-table table table-striped table-sm table-center align-middle"
                                    id="maintb">
                                    <thead>
                                        <tr>
                                            <th>Install No</th>
                                            <th>PBBOM</th>
                                            <th>Install Amount</th>
                                            <th>Install Date</th>
                                            <th>PBEOM</th>
                                            <th>Pay Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </form>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('dist/js/adminlte.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/moment-duration-format@2.3.2/lib/moment-duration-format.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    {{-- ── All original JS — zero changes ── --}}
    <script>
        $(function() {
            $("#joining_date").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true
            });
            $("#first_install_date").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true
            });
            $("#application_date").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true
            });
            $("#loan_approved_date").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true
            });
        });
    </script>

    <script>
        $(function() {
            $("#period").on('keyup', function() {
                var sanctionAmount = parseInt($('#sanction_amount').val());
                var period = parseInt($('#period').val());
                var installmentsize = sanctionAmount / period;
                console.log(installmentsize);
                console.log(period);
                console.log(sanctionAmount);
                $('#installment_size').val(installmentsize);
            });

            function storer2() {
                var loanAppNo = $('#loan_app_name').val();
                var totalamount = (parseInt($('#sanction_amount').val()));
                var firdtInsDat = $('#first_install_date').val();
                var installmonth = (parseInt($('#period').val()));
                var installAmount = totalamount / installmonth;
                var ball = totalamount - installAmount;
                $('#maintb tr:last').after(
                    '<tr><td><input type="text" class="form-control col-sm-6" id="loanAppNo" name="loanAppNo[]" value="' +
                    loanAppNo + '" hidden=""><input type="text" class="form-control col-sm-6"data-id="' +
                    loanAppNo +
                    '" id="install_no" name="install_no[]" value="1"></td><td><input type="text" class="form-control col-sm-6" id="pbbom" name="pbbom[]" value="' +
                    totalamount +
                    '"></td><td id="installamounttd"> <input type="text" class="form-control col-sm-6" id="installAmount" name="installAmount[]" value="' +
                    installAmount +
                    '"></td><td > <input type="text" class="form-control col-sm-6" id="firdtInsDate" name="firdtInsDate[]" value="' +
                    firdtInsDat +
                    '"></td><td><input type="text" class="form-control col-sm-6" id="pbeom" name="pbeom[]" value="' +
                    ball + '"></td><td>' + 'Deu' + '</td><td>' +
                    'Deu' + '</td><td>' + 'Deu' + '</td></tr>');
                var erty = parseInt($('table:first tr').find('#pbeom').last().text());
                if (!erty == '0') {
                    for (let i = 1; i < installmonth; i++) {
                        var pbbom = parseInt($('table:first tr').find('#pbeom').last().text());
                        var installamounttd = parseInt($('table:first tr').find('#installamounttd').last().text());
                        var installDate = $('table:first tr').find('#firdtInsDate').last().text();
                        var newDate = moment(firdtInsDat, "YYYY-MM-DD").add(i, 'months').format('YYYY-MM-DD');
                        var pbeom = pbbom - installAmount;
                        var ttER = i + 1;
                        $('#maintb tr:last').after(
                            '<tr ><td> <input type="text" class="form-control col-sm-6" id="loanAppNo" name="loanAppNo[]"  value="' +
                            loanAppNo +
                            '"hidden=""><input type="text" class="form-control col-sm-6" id="install_no" name="install_no[]" value="' +
                            ttER +
                            '"> </td><td name="balance"> <input type="text" class="form-control col-sm-6" id="pbbom" name="pbbom[]" value="' +
                            pbbom +
                            '"></td><td id="installamounttd"> <input type="text" class="form-control col-sm-6" id="installAmount" name="installAmount[]" value="' +
                            installAmount +
                            '"></td><td> <input type="text" class="form-control col-sm-6" id="firdtInsDate" name="firdtInsDate[]" value="' +
                            newDate +
                            '"></td><td><input type="text" class="form-control col-sm-6" id="pbeom" name="pbeom[]" value="' +
                            pbeom + '"></td><td>' + 'Deu' + '</td><td>' + 'Deu' + '</td><td>' +
                            '<button class="btn btn-success" type="check" id="check">Click</button>' +
                            '</td></tr>');
                        $(this).prop("disabled", true);
                    }
                }
                console.log(pbbom);
                console.log('ddd' + newDate + 'EE' + firdtInsDat);
            }
        });
    </script>

    <script>
        $('input, select').on('keydown', function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
            }
        });

        $('#company_no').on('change', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var comId = $('#company_no').val();
            $.ajax({
                type: 'GET',
                url: 'getemp/' + comId,
                contentType: false,
                processData: false,
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    var res = response.data;
                    var html = '';
                    var htmldata = res.map(function(item) {
                        html += '<option value=' + item.empno + '>';
                        console.log(item);
                    });
                    $("#empno_list").empty();
                    $("#empno_list").append(html);
                },
                error: function(response) {}
            });
        });

        $(document).on('keyup', '#emp_no', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var empno = $('#emp_no').val();
            var comId = $('#company_no').val();
            var data = {
                empno: empno,
                comId: comId
            };
            console.log(data);
            $.ajax({
                type: 'GET',
                url: '/getempdet',
                data: data,
                success: function(data) {
                    console.log(data);
                    $.each(data, function(key, deptList) {
                        if (data) {
                            $.each(data, function(key, getEmpList) {
                                console.log(getEmpList);
                                $('#joining_date').val(getEmpList.joining_date);
                                $('#emp_name').val(getEmpList.emp_name);
                                $('#designation').val(getEmpList.des_name);
                                $('#dept_name').val(getEmpList.dept_name);
                                $('#dept_no').val(getEmpList.dept_no);
                                $('#section_name').val(getEmpList.section_name);
                                $('#section_no').val(getEmpList.section_no);
                                $('#gross_amount').val(getEmpList.gross);
                            });
                        }
                    });
                }
            });
        });

        $("#insert_form").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const fd = new FormData(this);
            console.log(fd);
            $.ajax({
                type: 'POST',
                url: 'loansave',
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                complete: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        console.log(response.responseJSON.loan_nooo);
                        var loanId = response.responseJSON.loan_nooo;
                        var date = response.responseJSON.jDate;
                        $('#loan_app_name').val(loanId);
                        generateInstallments();
                        loandata();
                    }
                },
                error: function(response) {
                    alert('dd');
                    console.log(response);
                }
            });
        });

        function loandata() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var arrData = $('#add_item').serializeArray();
            console.log(typeof(arrData));
            console.log(arrData);
            console.log($(this).serializeArray());
            $.ajax({
                url: 'loandtsave',
                method: "GET",
                data: $('#add_item').serialize(),
                type: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        Swal.fire('Added!', 'Loan Added Successfully!', 'success');
                    }
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }




        function generateInstallments() {

            const loanAppNo = $('#loan_app_name').val();
            const totalAmount = parseFloat($('#sanction_amount').val());
            const firstDate = $('#first_install_date').val();
            const totalMonths = parseInt($('#period').val());

            if (!loanAppNo || !totalAmount || !firstDate || !totalMonths) {
                alert("Please fill all required fields");
                return;
            }

            const baseDate = moment(firstDate, "YYYY-MM-DD");

            // 🔥 KEY FIX: detect if first date is end of month
            const isEndOfMonth = baseDate.date() === baseDate.daysInMonth();

            const installmentAmount = parseFloat((totalAmount / totalMonths).toFixed(2));
            let balance = totalAmount;

            $('#maintb tbody').empty();

            for (let i = 0; i < totalMonths; i++) {

                let currentDate;

                if (isEndOfMonth) {
                    // ✅ Always last day of month
                    currentDate = baseDate.clone()
                        .add(i, 'months')
                        .endOf('month')
                        .format('YYYY-MM-DD');
                } else {
                    // ✅ Keep same day safely
                    const target = baseDate.clone().add(i, 'months');
                    const safeDay = Math.min(baseDate.date(), target.daysInMonth());

                    currentDate = target.date(safeDay).format('YYYY-MM-DD');
                }

                let pbbom = balance;
                let currentInstallment = installmentAmount;

                if (i === totalMonths - 1) {
                    currentInstallment = balance;
                }

                let pbeom = parseFloat((pbbom - currentInstallment).toFixed(2));

                $('#maintb tbody').append(`
            <tr>
                <td>
                    <input type="hidden" name="loanAppNo[]" value="${loanAppNo}">
                    <input type="text" class="form-control" name="install_no[]" value="${i + 1}">
                </td>

                <td>
                    <input type="text" class="form-control" name="pbbom[]" value="${pbbom}">
                </td>

                <td>
                    <input type="text" class="form-control" name="installAmount[]" value="${currentInstallment}">
                </td>

                <td>
                    <input type="text" class="form-control" name="firdtInsDate[]" value="${currentDate}">
                </td>

                <td>
                    <input type="text" class="form-control" name="pbeomr[]" value="${pbeom}">
                </td>

                <td>
                    <input type="date" class="form-control" name="payDate[]">
                </td>

                <td>
                    <input type="text" class="form-control" name="status[]" value="Due">
                </td>
            </tr>
        `);

                balance = pbeom;
            }
        }

        function storer() {
            var loanAppNo = $('#loan_app_name').val();
            var totalamount = (parseInt($('#sanction_amount').val()));
            var firdtInsDat = $('#first_install_date').val();
            var baseDate = moment(firdtInsDat, "YYYY-MM-DD");

            var installmonth = (parseInt($('#period').val()));
            var installAmount = totalamount / installmonth;
            var ball = totalamount - installAmount;
            $('#maintb tr:last').after(
                '<tr><td><input type="text" class="form-control col-sm-6" id="loanAppNo" name="loanAppNo[]" value="' +
                loanAppNo + '" hidden=""><input type="text" class="form-control col-sm-6"data-id="' +
                loanAppNo +
                '" id="install_no" name="install_no[]" value="1"></td><td><input type="text" class="form-control col-sm-6" id="pbbom" name="pbbom[]" value="' +
                totalamount +
                '"></td><td id="installamounttd"> <input type="text" class="form-control col-sm-6" id="installAmount" name="installAmount[]" value="' +
                installAmount +
                '"></td><td > <input type="text" class="form-control col-sm-6" id="firdtInsDate" name="firdtInsDate[]" value="' +
                firdtInsDat +
                '"></td><td  id="pbeom"><input type="text" class="form-control col-sm-6 inputField" id="pbeomr" name="pbeomr[]" value="' +
                ball + '"></td><td>' + ' ' +
                '</td><td><input type="text" class="form-control col-sm-6 inputField" id="status" name="status[]" value="' +
                'Deu' + '"></td></tr>');
            var erty = parseInt($('table#maintb tr:last input[id=pbeomr]').val());
            console.log(erty);
            if (!erty == '0') {
                for (let i = 1; i < installmonth; i++) {
                    var pbbom = parseInt($('table#maintb tr:last input[id=pbeomr]').val());
                    var installamounttd = parseInt($('table:first tr').find('#installamounttd').last().text());
                    var installDate = $('table:first tr').find('#firdtInsDate').last().text();


                    var newDate = baseDate.clone().add(i, 'months').format('YYYY-MM-DD');
                    var pbeom = pbbom - installAmount;
                    var ttER = i + 1;
                    $('#maintb tr:last').after(
                        '<tr ><td> <input type="text" class="form-control col-sm-6" id="loanAppNo" name="loanAppNo[]"  value="' +
                        loanAppNo +
                        '"hidden=""><input type="text" class="form-control col-sm-6" id="install_no" name="install_no[]" value="' +
                        ttER +
                        '"> </td><td name="balance"> <input type="text" class="form-control col-sm-6" id="pbbom" name="pbbom[]" value="' +
                        pbbom +
                        '"></td><td id="installamounttd"> <input type="text" class="form-control col-sm-6" id="installAmount" name="installAmount[]" value="' +
                        installAmount +
                        '"></td><td> <input type="text" class="form-control col-sm-6" id="firdtInsDate" name="firdtInsDate[]" value="' +
                        newDate +
                        '"></td><td id="pbeom" name="pbeom"><input type="text" class="form-control col-sm-6 inputField" id="pbeomr" name="pbeomr[]" value="' +
                        pbeom + '"></td><td>' + ' ' +
                        '</td><td><input type="text" class="form-control col-sm-6 inputField" id="status" name="status[]" value="' +
                        'Deu' +
                        '"></td></tr>');
                    $(this).prop("disabled", true);
                }
            }
            console.log(pbbom);
            console.log('ddd' + newDate + 'EE' + firdtInsDat);
        }



        function updateStatus() {

            const today = moment().startOf('day');

            $('#maintb tbody tr').each(function() {

                let installDate = $(this).find('input[name="firdtInsDate[]"]').val();
                let payDate = $(this).find('input[name="payDate[]"]').val();
                let statusField = $(this).find('input[name="status[]"]');

                if (payDate) {
                    // ✅ Paid
                    statusField.val('Paid');
                    statusField.css('background-color', '#28a745'); // green
                    statusField.css('color', '#fff');

                } else {
                    let dueDate = moment(installDate, "YYYY-MM-DD");

                    if (today.isAfter(dueDate)) {
                        // 🔴 Overdue
                        statusField.val('Overdue');
                        statusField.css('background-color', '#dc3545'); // red
                        statusField.css('color', '#fff');
                    } else {
                        // 🟡 Due
                        statusField.val('Due');
                        statusField.css('background-color', '#ffc107'); // yellow
                        statusField.css('color', '#000');
                    }
                }

            });
        }
        $(document).on('change', 'input[name="payDate[]"]', function() {
            updateStatus();
        });
    </script>

</body>

</html>
