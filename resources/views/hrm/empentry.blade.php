<!doctype html>
<html lang="en">
<head>
    <title>Employee Information</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Original assets --}}
    <link rel="stylesheet" href="{{URL::asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="erpcss/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="erpcss/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="mainjs/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="erpcss/bootstrap.min.css">
    <link rel="stylesheet" href="erpcss/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="erpcss/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="bootstrap_icon/bootstrap-icons.min.css">
    <script src="mainjs/adminlte.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="erpcss/select2.min.css" rel="stylesheet" />
    <link type="text/css" rel="Stylesheet" href="mainjs/jquery-ui.css" />
    <link href="erpcss/sweetalert2.min.css" rel="stylesheet">

    <style>
        @font-face {
            font-family: SutonnyMJ;
            src: url('/fonts/SutonnyMJ.ttf');
            src: url('/fonts/SutonnyMJ.eot');
            src: url('/fonts/SutonnyMJ.eot?#iefix') format('embedded-opentype'),
                 url('/fonts/SutonnyMJ.ttf') format('truetype'),
                 url('/fonts/SutonnyMJ.svg#FortFoundry') format('svg');
        }
        #b_name, #depent_name_bangla, #relation_bn, #address_bn, #dep_name_bn { font-family: 'SutonnyMJ' !important; }
        .select2.select2-container { width: 100% !important; }
        #ui-datepicker-div { display: none; }
        @media only screen and (max-width: 600px)  { html { font-size: .7rem; } }
        @media only screen and (min-width: 992px)  { html { font-size: .5rem; } }
        @media only screen and (min-width: 1366px) { html { font-size: .8rem; } .select2-container .select2-selection--single { height: 34px !important; } }
        @media only screen and (min-width: 1440px) { html { font-size: 1rem; }  .select2-container .select2-selection--single { height: 37px !important; } }

        /* ── Design Variables ── */
        :root {
            --primary:     #1a3a5c;
            --primary-lt:  #2257a0;
            --accent:      #1e7e34;
            --danger:      #c0392b;
            --tab-bar:     #1a3a5c;
            --card-head:   #1a3a5c;
            --body-bg:     #f0f4f8;
            --card-bg:     #ffffff;
            --border:      #cdd8e8;
            --label-color: #374a5a;
            --input-bg:    #fafdff;
            --radius:      5px;
            --input-h:     32px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            background: var(--body-bg);
            color: #222;
            margin: 0; padding: 0;
        }

        /* ── Tab Navigation Bar ── */
        .emp-tabbar {
            background: var(--tab-bar);
            display: flex; flex-wrap: wrap;
            padding: 0 8px;
            border-bottom: 3px solid #0c1f35;
            position: sticky; top: 0; z-index: 999;
            box-shadow: 0 2px 6px rgba(0,0,0,.35);
        }
        .emp-tabbar .nav-link {
            color: #a8c8e8 !important;
            font-size: 11.5px; font-weight: 600;
            letter-spacing: .3px; text-transform: uppercase;
            padding: 10px 12px;
            border: none; border-bottom: 3px solid transparent;
            border-radius: 0; margin-bottom: -3px;
            display: inline-flex; align-items: center; gap: 4px;
            transition: all .15s; background: none;
            cursor: pointer;
        }
        .emp-tabbar .nav-link:hover  { color: #fff !important; background: rgba(255,255,255,.08); }
        .emp-tabbar .nav-link.active { color: #fff !important; border-bottom-color: #4fc3f7; background: rgba(255,255,255,.1); }
        .emp-tabbar .nav-link i { font-size: 13px; }

        /* ── Tab Content ── */
        .tab-content { padding: 18px 20px; }

        /* ── Section Card ── */
        .sec-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
            margin-bottom: 16px;
        }
        .sec-card-head {
            background: var(--card-head);
            color: #fff;
            padding: 8px 16px;
            border-radius: var(--radius) var(--radius) 0 0;
            font-size: 11px; font-weight: 700;
            letter-spacing: .6px; text-transform: uppercase;
            display: flex; align-items: center; gap: 6px;
        }
        .sec-card-head i { font-size: 13px; opacity: .85; }
        .sec-card-body { padding: 14px 16px 6px; }

        /* ── Page heading ── */
        .page-heading {
            font-size: 16px; font-weight: 700; color: var(--primary);
            margin-bottom: 14px; padding-bottom: 7px;
            border-bottom: 2px solid var(--primary-lt);
            display: flex; align-items: center; gap: 7px;
        }
        .page-heading i { color: var(--primary-lt); font-size: 18px; }

        /* ── Sub-section title ── */
        .sub-title {
            font-size: 11.5px; font-weight: 700; color: var(--primary-lt);
            letter-spacing: .5px; text-transform: uppercase;
            padding: 10px 0 6px; margin-top: 4px;
            border-bottom: 1.5px solid #dde7f2;
            display: flex; align-items: center; gap: 5px;
        }

        /* ── Form labels ── */
        label.col-form-label {
            font-size: 11px !important;
            font-weight: 600 !important;
            color: var(--label-color) !important;
            padding-top: 6px;
        }

        /* ── Form controls ── */
        .form-control, .form-select, .select2-selection {
            height: var(--input-h) !important;
            font-size: 12.5px !important;
            border: 1px solid #bfcfdf !important;
            border-radius: 4px !important;
            background: var(--input-bg) !important;
            color: #1a2a3a !important;
            padding: 3px 8px !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-lt) !important;
            box-shadow: 0 0 0 2px rgba(34,87,160,.15) !important;
            background: #fff !important;
            outline: none;
        }
        textarea.form-control { height: auto !important; min-height: 56px !important; resize: vertical; padding: 5px 8px !important; }

        /* ── Buttons ── */
        .btn { font-size: 12px !important; font-weight: 600 !important; padding: 6px 20px !important; border-radius: 4px !important; letter-spacing: .3px; }
        .btn-success  { background: var(--accent) !important; border-color: var(--accent) !important; }
        .btn-success:hover { filter: brightness(1.1); }
        .btn-primary  { background: #1565c0 !important; border-color: #1565c0 !important; }
        .btn-danger   { background: transparent !important; color: var(--danger) !important; border: 1.5px solid var(--danger) !important; }
        .btn-danger:hover { background: #ffeaea !important; }
        .btn-white    { background: var(--primary) !important; color: #fff !important; border: none !important; }
        .btn-white:hover { background: var(--primary-lt) !important; }
        .btn-secondary { background: #546e7a !important; border-color: #546e7a !important; }

        /* ── Action bar ── */
        .action-bar { text-align: center; padding: 10px 0 14px; display: flex; justify-content: center; gap: 10px; }

        /* ── EmpID lookup bar ── */
        .empid-bar {
            background: #e6eff8;
            border: 1px solid #b8d0ea;
            border-radius: var(--radius);
            padding: 10px 16px;
            margin-bottom: 16px;
            display: flex; align-items: flex-end; flex-wrap: wrap; gap: 14px;
        }
        .empid-bar > div { display: flex; flex-direction: column; }
        .empid-bar label { font-size: 11px; font-weight: 700; color: var(--primary); margin-bottom: 3px; }
        .empid-bar .input-group { width: 240px; }

        /* ── Data tables ── */
        .table-wrap { overflow-x: auto; border-radius: var(--radius); border: 1px solid var(--border); margin-top: 16px; }
        .emp-table { width: 100%; border-collapse: collapse; font-size: 12px; }
        .emp-table thead th {
            background: var(--primary); color: #fff;
            padding: 9px 11px; font-size: 10.5px; font-weight: 700;
            letter-spacing: .4px; text-transform: uppercase;
            border: none; white-space: nowrap;
        }
        .emp-table tbody tr:nth-child(even) { background: #f2f7fc; }
        .emp-table tbody td { padding: 7px 11px; border-bottom: 1px solid #dde8f2; color: #2a3a4a; }
        .emp-table tbody tr:hover { background: #e4f0fb; }
        .emp-table tbody tr:last-child td { border-bottom: none; }

        /* ── Image preview ── */
        .img-box {
            border: 1.5px dashed #a0bcd8; border-radius: 4px;
            overflow: hidden; display: inline-flex;
            align-items: center; justify-content: center;
            background: #f3f8fd;
        }

        /* ── Radio group ── */
        .form-check-inline label { font-size: 12.5px; }

        /* divider */
        hr.sec-hr { border: none; border-top: 1.5px dashed #d0dceb; margin: 12px 0; }

        /* row spacing */
        .row.p-1 { padding: 4px 0 !important; }
        .mb-3 { margin-bottom: 10px !important; }
        .mb-5 { margin-bottom: 14px !important; }
        .p-5  { padding: 18px !important; }
        .p-3  { padding: 10px !important; }
        .p-6  { padding: 14px !important; }

        /* scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #eef2f8; }
        ::-webkit-scrollbar-thumb { background: #9ab4cc; border-radius: 3px; }
    </style>
</head>

<body>
    @section('title', 'Employee Information')
    @include('topbar.sidebar')

    <div class="container-fluid">
        <div class="content-wrapper">
            <main>

                {{-- ══════════════════════════════════════════
                     TAB NAVIGATION BAR
                ══════════════════════════════════════════ --}}
                <nav>
                    <div class="emp-tabbar nav" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="per-tab"     data-bs-toggle="pill" data-bs-target="#per"     type="button" role="tab" aria-controls="per"     aria-selected="true">
                            <i class="bi bi-person"></i> Personal Info
                        </button>
                        <button class="nav-link" id="off-tab"     data-bs-toggle="pill" data-bs-target="#off"     type="button" role="tab" aria-controls="off"     aria-selected="false">
                            <i class="bi bi-briefcase"></i> Official Info
                        </button>
                        <button class="nav-link" id="add-tab"     data-bs-toggle="pill" data-bs-target="#add"     type="button" role="tab" aria-controls="add"     aria-selected="false">
                            <i class="bi bi-geo-alt"></i> Location
                        </button>
                        <button class="nav-link" id="academi-tab" data-bs-toggle="pill" data-bs-target="#academi" type="button" role="tab" aria-controls="academi" aria-selected="false">
                            <i class="bi bi-mortarboard"></i> Education
                        </button>
                        <button class="nav-link" id="course-tab"  data-bs-toggle="pill" data-bs-target="#course"  type="button" role="tab" aria-controls="course"  aria-selected="false">
                            <i class="bi bi-journal-bookmark"></i> Short Course
                        </button>
                        <button class="nav-link" id="train-tab"   data-bs-toggle="pill" data-bs-target="#train"   type="button" role="tab" aria-controls="train"   aria-selected="false">
                            <i class="bi bi-award"></i> Training
                        </button>
                        <button class="nav-link" id="exp-tab"     data-bs-toggle="pill" data-bs-target="#exp"     type="button" role="tab" aria-controls="exp"     aria-selected="false">
                            <i class="bi bi-buildings"></i> Experience
                        </button>
                        <button class="nav-link" id="nomi-tab"    data-bs-toggle="pill" data-bs-target="#nomi"    type="button" role="tab" aria-controls="nomi"    aria-selected="false">
                            <i class="bi bi-people"></i> Nominee
                        </button>
                        <button class="nav-link" id="job-tab"     data-bs-toggle="pill" data-bs-target="#job"     type="button" role="tab" aria-controls="job"     aria-selected="false">
                            <i class="bi bi-clock-history"></i> Job History
                        </button>
                    </div>
                </nav>

                {{-- ══════════════════════════════════════════
                     TAB CONTENT
                ══════════════════════════════════════════ --}}
                <div class="tab-content" id="nav-tabContent">

                    {{-- ─────────────────────────────────────
                         TAB 1 : PERSONAL INFORMATION
                    ───────────────────────────────────── --}}
                    <div class="tab-pane fade show active" id="per" role="tabpanel" aria-labelledby="per-tab" tabindex="1">
                        <input type="text" name="updateorsave" id="updateorsave" value="{{old('updateorsave')}}" tabindex="1" hidden>

                        <form id="emppersonalSave2">
                            @csrf
                            <div class="page-heading"><i class="bi bi-person-lines-fill"></i> Personal Information</div>

                            {{-- Error list --}}
                            <div id="error-list"><ul></ul></div>

                            {{-- EmpID + Card No --}}
                            <div class="empid-bar">
                                <div>
                                    <label>Employee ID</label>
                                    <div class="input-group">
                                        <input list="empno_list" type="text" class="form-control" name="empno" id="empno"
                                            value="{{old('empno')}}" placeholder="Employee ID" tabindex="1" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" id="findemp" type="button"><i class="bi bi-search"></i></button>
                                        </div>
                                        <span class="text-danger" id="massege"></span>
                                        <datalist id="empno_list"></datalist>
                                    </div>
                                </div>
                                <div>
                                    <label>Proximity Card No</label>
                                    <input type="text" class="form-control" name="card_no" id="card_no" value="{{old('card_no')}}" placeholder="Card No" style="width:180px;">
                                </div>
                                <div>
                                    <label>Company</label>
                                    <select class="form-select" id="comapnylist" name="company_id" style="width:220px;">
                                        <option selected value="">Select Company</option>
                                        @foreach($companyList as $comapnyLists)
                                        <option value="{{$comapnyLists->company_id}}">{{$comapnyLists->company_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Name Details --}}
                            <div class="sec-card">
                                <div class="sec-card-head"><i class="bi bi-person"></i> Name Details</div>
                                <div class="sec-card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="first_name" class="col-sm-4 col-form-label">First Name :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="{{old('first_name')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="last_name" class="col-sm-4 col-form-label">Last Name :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="{{old('last_name')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="middle_name" class="col-sm-4 col-form-label">Middle Name :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Middle Name" value="{{old('middle_name')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="b_name" class="col-sm-4 col-form-label">Name (Bangla) :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="b_name" id="b_name" value="{{old('b_name')}}" placeholder="বাংলা নাম">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="father_name" class="col-sm-4 col-form-label">Father's Name :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="father_name" id="father_name" placeholder="Father's Name" value="{{old('father_name')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="mother_name" class="col-sm-4 col-form-label">Mother's Name :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="Mother's Name" value="{{old('mother_name')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="husband_name" class="col-sm-4 col-form-label">Spouse Name :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="husband_name" id="husband_name" placeholder="Spouse Name" value="{{old('husband_name')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Demographics --}}
                            <div class="sec-card">
                                <div class="sec-card-head"><i class="bi bi-calendar2-person"></i> Demographics</div>
                                <div class="sec-card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="dob" class="col-sm-4 col-form-label">Date of Birth :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="dob" id="dob" value="{{old('dob')}}" placeholder="Date of Birth">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="as_on" class="col-sm-4 col-form-label">As On :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="as_on" id="as_on_date" value="{{old('as_on')}}" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="ageDet" class="col-sm-4 col-form-label">Age :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="ageDet" id="ageDet" value="{{old('age')}}" placeholder="Age">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="row p-1">
                                                <label for="sex" class="col-sm-4 col-form-label">Gender :</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select" id="sex" name="sex">
                                                        <option value="0">Select Gender</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Male">Male</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row p-1">
                                                <label for="marial_status" class="col-sm-4 col-form-label">Marital Status :</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select" id="marial_status" name="marial_status">
                                                        <option value="0">Select</option>
                                                        <option value="Single">Single</option>
                                                        <option value="Married">Married</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row p-1">
                                                <label for="religion_id" class="col-sm-4 col-form-label">Religion :</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select" name="religion_id" id="religion_id">
                                                        @foreach($religion as $religion)
                                                        <option value="{{$religion->religion_id}}">{{$religion->religion_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row p-1">
                                                <label for="blood_group" class="col-sm-4 col-form-label">Blood Group :</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select" name="blood_group" id="blood_group">
                                                        <option value="">Select Blood Group</option>
                                                        <option value="A (+) ve">A (+) ve</option>
                                                        <option value="A (-) ve">A (-) ve</option>
                                                        <option value="B (+) ve">B (+) ve</option>
                                                        <option value="B (-) ve">B (-) ve</option>
                                                        <option value="AB (+) ve">AB (+) ve</option>
                                                        <option value="AB (-) ve">AB (-) ve</option>
                                                        <option value="O (+) ve">O (+) ve</option>
                                                        <option value="O (-) ve">O (-) ve</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="nationality_desc" class="col-sm-4 col-form-label">Nationality :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="nationality_desc" id="nationality_desc" value="Bangladeshi" placeholder="Nationality">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="status" class="col-sm-4 col-form-label">Status :</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select" name="status" id="status">
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="hbs_test" class="col-sm-4 col-form-label">HBS Ag :</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select" name="hbs_test" id="hbs_test">
                                                        <option value="">Choose</option>
                                                        <option value="(+) ve">(+) ve</option>
                                                        <option value="(-) ve">(-) ve</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Identity Documents --}}
                            <div class="sec-card">
                                <div class="sec-card-head"><i class="bi bi-card-text"></i> Identity Documents</div>
                                <div class="sec-card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="national_id_no" class="col-sm-4 col-form-label">National ID :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="national_id_no" id="national_id_no" value="{{ old('national_id_no') }}" placeholder="National ID">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="id_card_issue" class="col-sm-4 col-form-label">ID Card Issue :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="id_card_issue" id="id_card_issue" value="{{ old('id_card_issue') }}" placeholder="Issue date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="valid_till" class="col-sm-4 col-form-label">Valid Till :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="valid_till" id="valid_till" value="{{ old('valid_till') }}" placeholder="Valid till">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="passport_no" class="col-sm-4 col-form-label">Passport No :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="passport_no" id="passport_no" value="{{ old('passport_no') }}" placeholder="Passport No">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="place_of_issue" class="col-sm-4 col-form-label">Place of Issue :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="place_of_issue" id="place_of_issue" value="{{ old('place_of_issue') }}" placeholder="Place of Issue">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="id_mark" class="col-sm-4 col-form-label">ID Mark :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="id_mark" id="id_mark" value="{{ old('id_mark') }}" placeholder="Identification mark">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="birthday_id" class="col-sm-4 col-form-label">Birth Certificate :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="birthday_id" id="birthday_id" value="{{ old('birthday_id') }}" placeholder="Birth Certificate">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="last_education" class="col-sm-4 col-form-label">Last Education :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="last_education" id="last_education" value="{{ old('last_education') }}" placeholder="Last Education">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Contact & Photo --}}
                            <div class="sec-card">
                                <div class="sec-card-head"><i class="bi bi-telephone"></i> Contact & Photo / Signature</div>
                                <div class="sec-card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="emp_mobile_no" class="col-sm-4 col-form-label">Emp Mobile :</label>
                                                <div class="col-sm-8">
                                                    <input type="tel" class="form-control" name="emp_mobile_no" id="emp_mobile_no" value="{{ old('emp_mobile_no') }}" placeholder="Mobile No">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="sms_mobile_no" class="col-sm-4 col-form-label">SMS Mobile :</label>
                                                <div class="col-sm-8">
                                                    <input type="tel" class="form-control" name="sms_mobile_no" id="sms_mobile_no" value="{{ old('sms_mobile_no') }}" placeholder="SMS Mobile No">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="office_food" class="col-sm-4 col-form-label">Office Food :</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select" name="office_food" id="office_food">
                                                        <option value="">Choose One</option>
                                                        <option value="N">No</option>
                                                        <option value="Y">Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="sec-hr">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="photo" class="col-sm-4 col-form-label">Photo :</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="file" id="photo" name="photo">
                                                    <div class="img-box mt-2" style="height:100px;width:100px;">
                                                        <img id="preview-image" src="#" alt="Preview" width="100" height="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row p-1">
                                                <label for="signature" class="col-sm-4 col-form-label">Signature :</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="file" id="signature" name="signature">
                                                    <div class="img-box mt-2" style="height:80px;width:200px;">
                                                        <img id="preview-sign" src="#" alt="Preview" width="200" height="80">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="action-bar">
                                <button class="btn btn-success" type="submit" id="emppersonalSave"><i class="bi bi-check-circle"></i> Save</button>
                                <button class="btn btn-primary" type="submit" id="emppersonalUpdate"><i class="bi bi-pencil-square"></i> Update</button>
                                <button class="btn btn-danger" type="button" id="clearFieldsBtn"><i class="bi bi-x-circle"></i> Clear</button>
                            </div>
                        </form>
                    </div>

                    {{-- ─────────────────────────────────────
                         TAB 2 : OFFICIAL INFORMATION
                    ───────────────────────────────────── --}}
                    <div class="tab-pane fade show" id="off" role="tabpanel" aria-labelledby="off-tab" tabindex="0">
                        <form action="" method="" id="empofficialSave">
                            <div class="page-heading"><i class="bi bi-briefcase-fill"></i> Official Information</div>

                            <div class="empid-bar">
                                <div>
                                    <label>Employee ID</label>
                                    <input type="text" class="form-control" name="empof_id" id="empof_id" value="{{ old('empno') }}" placeholder="Employee ID" style="width:220px;">
                                </div>
                            </div>

                            {{-- Base Information --}}
                            <div class="sec-card">
                                <div class="sec-card-head"><i class="bi bi-building"></i> Base Information</div>
                                <div class="sec-card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="comapnylist_of" class="col-sm-4 col-form-label">Company :</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="company_id" id="comapnylist_of">
                                                        <option selected value="">Select Company</option>
                                                        @foreach($companyList as $comapnyLists)
                                                        <option value="{{$comapnyLists->company_id}}">{{$comapnyLists->company_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="deptList" class="col-sm-4 col-form-label">Department :</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="dept_no" id="deptList">
                                                        <option selected value="">Select One</option>
                                                        @foreach($deptList as $deptList)
                                                        <option value="{{$deptList->dept_no}}">{{$deptList->dept_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="section_no" class="col-sm-4 col-form-label">Section :</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" id="section_no" name="section_no">
                                                        <option selected value="">Select One</option>
                                                        @foreach($section_list as $section_list)
                                                        <option value="{{$section_list->section_no}}">{{$section_list->section_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="floorList" class="col-sm-4 col-form-label">Floor No :</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="floor_id" id="floorList">
                                                        <option value="">Select One</option>
                                                        @foreach($floorList as $floorList)
                                                        <option value="{{$floorList->floor_id}}">{{$floorList->floor_desc}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="line" class="col-sm-4 col-form-label">Line No :</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="line" id="line">
                                                        <option selected value="">Select One</option>
                                                        @foreach($lineInfo as $lineInfo)
                                                        <option value="{{$lineInfo->line_no}}">{{$lineInfo->line}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="des_id" class="col-sm-4 col-form-label">Designation :</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="des_id" id="des_id">
                                                        <option selected>Select One</option>
                                                        @foreach($designation as $designation)
                                                        <option value="{{$designation->des_id}}">{{$designation->designation_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="emp_type" class="col-sm-4 col-form-label">Emp Type :</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="emp_type" id="emp_type">
                                                        <option selected value="">Select One</option>
                                                        @foreach($empType as $empType)
                                                        <option value="{{$empType->emp_type}}">{{$empType->emp_type}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="grade_id" class="col-sm-4 col-form-label">Grade :</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="grade_id" id="grade_id">
                                                        <option selected value="">Select One</option>
                                                        @foreach($gradeInfo as $gradeInfo)
                                                        <option value="{{$gradeInfo->grade_id}}">{{$gradeInfo->grade_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="shift_code" class="col-sm-4 col-form-label">Shift :</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="shift_code" id="shift_code">
                                                        <option selected value="">Select One</option>
                                                        @foreach($shiftInfo as $shiftInfo)
                                                        <option value="{{$shiftInfo->shift_code}}">{{$shiftInfo->shift_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="shift_group" class="col-sm-4 col-form-label">Shift Group :</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="shift_group" id="shift_group">
                                                        <option selected value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="cal_code" class="col-sm-4 col-form-label">Calendar :</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="cal_code" id="cal_code">
                                                        <option selected value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="weekly_off" class="col-sm-4 col-form-label">Weekly Off :</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="weekly_off" id="weekly_off">
                                                        <option selected value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Joining & Date Info --}}
                            <div class="sec-card">
                                <div class="sec-card-head"><i class="bi bi-calendar-check"></i> Joining & Date Information</div>
                                <div class="sec-card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="opt_no" class="col-sm-4 col-form-label">OPT No :</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="opt_no" id="opt_no">
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="joining_date" class="col-sm-4 col-form-label">Joining Date :</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="joining_date" id="joining_date" value="{{ old('joining_date') }}" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="as_on_join" class="col-sm-4 col-form-label">As On Join :</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="as_on_join" id="as_on_join" value="{{ old('as_on_join') }}" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="conform_date" class="col-sm-4 col-form-label">Confirmation Date :</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="conform_date" id="conform_date" value="{{ old('conform_date') }}" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="provision_period" class="col-sm-4 col-form-label">Provision Period :</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="provision_period" id="provision_period" value="{{ old('provision_period') }}" placeholder="Provision Period">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="increment_date" class="col-sm-4 col-form-label">Increment Date :</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="increment_date" id="increment_date" value="{{ old('increment_date') }}" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label for="appraisal_cal" class="col-sm-4 col-form-label">Appraisal Calendar :</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="appraisal_cal" id="appraisal_cal">
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Category & Entitlements --}}
                            <div class="sec-card">
                                <div class="sec-card-head"><i class="bi bi-list-check"></i> Category & Entitlements</div>
                                <div class="sec-card-body">
                                    <div class="row">
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Leave Category :</label><div class="col-sm-7"><select class="form-select" name="lv_cat_id" id="lv_cat_id"><option value="">Select One</option></select></div></div></div>
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Allowance Category :</label><div class="col-sm-7"><select class="form-select" name="allw_cat_id" id="allw_cat_id"><option value="">Select One</option></select></div></div></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Work Entitlement :</label><div class="col-sm-7"><select class="form-select" name="work_ent" id="work_ent"><option value="">Select One</option></select></div></div></div>
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">OT Entitlement :</label><div class="col-sm-7"><select class="form-select" name="ot_ent" id="ot_ent"><option value="">Select One</option></select></div></div></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Residence Entitlement :</label><div class="col-sm-7"><select class="form-select" name="res_ent" id="res_ent"><option value="">Select One</option></select></div></div></div>
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Transport Entitlement :</label><div class="col-sm-7"><select class="form-select" name="tran_ent" id="tran_ent"><option value="">Select One</option></select></div></div></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">PF Entitlement :</label><div class="col-sm-7"><select class="form-select" name="pf_ent" id="pf_ent"><option value="">Select One</option></select></div></div></div>
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Tax Entitlement :</label><div class="col-sm-7"><select class="form-select" name="tax_ent" id="tax_ent"><option value="">Select One</option></select></div></div></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Provident Fund :</label><div class="col-sm-7"><input type="text" class="form-control" name="pro_fund" id="pro_fund" value="{{ old('pro_fund') }}" placeholder="Provident Fund"></div></div></div>
                                    </div>
                                </div>
                            </div>

                            {{-- Salary & Bank --}}
                            <div class="sec-card">
                                <div class="sec-card-head"><i class="bi bi-bank"></i> Salary & Banking</div>
                                <div class="sec-card-body">
                                    <div class="row">
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Gross Salary :</label><div class="col-sm-7"><input type="number" class="form-control" name="gross" id="gross" value="{{ old('gross') }}" placeholder="Gross Amount"></div></div></div>
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Other Allowance :</label><div class="col-sm-7"><input type="number" class="form-control" name="other_allowance" id="other_allowance" value="{{ old('other_allowance') }}" placeholder="Other Allowance"></div></div></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row p-1">
                                                <label class="col-sm-4 col-form-label">Bank Name :</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="bank_name" id="bank_name">
                                                        <option value="">Select Bank</option>
                                                        @foreach($bankNmae as $bankNmae)
                                                        <option value="{{$bankNmae->bank_name}}">{{$bankNmae->bank_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Account No :</label><div class="col-sm-7"><input type="text" class="form-control" name="bank_ac_no" id="bank_ac_no" value="{{ old('bank_ac_no') }}" placeholder="Account No"></div></div></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">TIN No :</label><div class="col-sm-7"><input type="number" class="form-control" name="tin_no" id="tin_no" value="{{ old('tin_no') }}" placeholder="TIN No"></div></div></div>
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Tax Deduction :</label><div class="col-sm-7"><input type="number" class="form-control" name="tax_deduction" id="tax_deduction" value="{{ old('tax_deduction') }}" placeholder="Amount"></div></div></div>
                                    </div>
                                </div>
                            </div>

                            {{-- Release Information --}}
                            <div class="sec-card">
                                <div class="sec-card-head"><i class="bi bi-box-arrow-right"></i> Release Information</div>
                                <div class="sec-card-body">
                                    <div class="row">
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Dismissal Date :</label><div class="col-sm-7"><input type="date" class="form-control" name="termination_date" id="dismisal_date" value="{{ old('dismisal_date') }}"></div></div></div>
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Resigned Date :</label><div class="col-sm-7"><input type="date" class="form-control" name="resigned_date" id="resigned_date" value="{{ old('resigned_date') }}"></div></div></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Reason :</label><div class="col-sm-7"><textarea class="form-control" name="reason" id="reason" placeholder="Reason in details...">{{ old('reason') }}</textarea></div></div></div>
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Is Lefty :</label><div class="col-sm-7"><select class="form-select" name="is_lefty" id="is_lefty"><option value="">Choose</option><option value="L">Lefty</option><option value="R">Resigned</option></select></div></div></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">Service Book No :</label><div class="col-sm-7"><input type="text" class="form-control" name="service_book_number" id="service_book_number" value="{{ old('service_book_number') }}" placeholder="Service Book No"></div></div></div>
                                        <div class="col-md-6"><div class="row p-1"><label class="col-sm-4 col-form-label">A/C :</label><div class="col-sm-7"><input type="text" class="form-control" name="ac_no" id="ac_no" value="{{ old('ac_no') }}" placeholder="A/C"></div></div></div>
                                    </div>
                                </div>
                            </div>

                            <div class="action-bar">
                                <button class="btn btn-success" type="submit" id="offc_save"><i class="bi bi-check-circle"></i> Save</button>
                                <button class="btn btn-primary" type="submit" id="offc_update"><i class="bi bi-pencil-square"></i> Update</button>
                                <button class="btn btn-danger" type="button" id="clearoff"><i class="bi bi-x-circle"></i> Clear</button>
                            </div>
                        </form>
                    </div>

                    {{-- ─────────────────────────────────────
                         TAB 3 : LOCATION
                    ───────────────────────────────────── --}}
                    @include('hrm.empentry.empadress')

                    {{-- ─────────────────────────────────────
                         TAB 4 : EDUCATION
                    ───────────────────────────────────── --}}
                    @include('hrm.empentry.empacademic')

                    {{-- ─────────────────────────────────────
                         TAB 5 : SHORT COURSE
                    ───────────────────────────────────── --}}
                    @include('hrm.empentry.empshortcourse')

                    {{-- ─────────────────────────────────────
                         TAB 6 : TRAINING
                    ───────────────────────────────────── --}}
                    @include('hrm.empentry.emptrain')

                    {{-- ─────────────────────────────────────
                         TAB 7 : EXPERIENCE
                    ───────────────────────────────────── --}}
                    @include('hrm.empentry.empexperience')

                    {{-- ─────────────────────────────────────
                         TAB 8 : NOMINEE
                    ───────────────────────────────────── --}}
                    @include('hrm.empentry.empnomeenee')

                    {{-- ─────────────────────────────────────
                         TAB 9 : JOB HISTORY
                    ───────────────────────────────────── --}}
                    @include('hrm.empentry.empjobhistory')

                </div>{{-- /tab-content --}}
            </main>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         SCRIPTS (all original, untouched)
    ══════════════════════════════════════════ --}}
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
    <script type="text/javascript">
    $('input, select').on('keydown', function(e) {
        if (e.keyCode == 13) { e.preventDefault(); }
    });

    $('#findemp').on('click', function(e) {
        e.preventDefault();
        var empno = $("#empno").val();
        $('#emppersonalSave').hide();
        $('#offc_save').hide();
        $('#emppersonalUpdate').show();
        $('#offc_update').show();
        $('#updateorsave').val('update');

        $.ajax({
            url: 'empDetailsSearch',
            method: 'get',
            data: { 'empno': empno },
            success: function(data) {
                $.each(data, function(key, empdt) {
                    $('#first_name').val(empdt.first_name);
                    $('#middle_name').val(empdt.middle_name);
                    $('#last_name').val(empdt.last_name);
                    $('#card_no').val(empdt.card_no);
                    $('#comapnylist').val(empdt.company_id).change();
                    $('#father_name').val(empdt.father_name);
                    $('#mother_name').val(empdt.mother_name);
                    $('#husband_name').val(empdt.husband_name);
                    $('#dob').val(moment(empdt.dob).format("YYYY-MM-DD"));
                    $('#as_on_date').val(moment(empdt.as_on).format("YYYY-MM-DD"));
                    $('#as_on').val('empdt.as_on');
                    $('#age').val(empdt.age);
                    $('#b_name').val(empdt.b_name);
                    $('#religion_id').val(empdt.religion_id);
                    $('#nationality_desc').val(empdt.nationality_desc);
                    $('#status').val(empdt.status);
                    $('#sex').val(empdt.sex);
                    $('#national_id_no').val(empdt.national_id_no);
                    if (empdt.id_card_issue == null) { $('#id_card_issue').val(null); }
                    else { $('#id_card_issue').val(moment(empdt.id_card_issue).format("YYYY-MM-DD")); }
                    $('#passport_no').val(empdt.passport_no);
                    $('#last_education').val(empdt.last_education);
                    if (empdt.valid_till == null) { $('#valid_till').val(null); }
                    else { $('#valid_till').val(moment(empdt.valid_till).format("YYYY-MM-DD")); }
                    $('#place_of_issue').val(empdt.place_of_issue);
                    $('#id_mark').val(empdt.id_mark);
                    $('#birthday_id').val(empdt.birthday_id);
                    $('#blood_group').val(empdt.blood_group);
                    $('#hbs_test').val(empdt.hbs_test);
                    $('#emp_mobile_no').val(empdt.emp_mobile_no);
                    $('#sms_mobile_no').val(empdt.sms_mobile_no);
                    $('#office_food').val(empdt.office_food);
                    $('#marial_status').val(empdt.marial_status).change();
                    $('#ageDet').val(empdt.age2);

                    var emp_pic_link = "http://192.168.189.205:81/emp_photo/" + empdt.empno + ".jpg";
                    $("#preview-image").attr("src", emp_pic_link);
                    var emp_sign_link = "http://192.168.189.205:81/emp_sign/" + empdt.empno + ".jpg";
                    $("#preview-sign").attr("src", emp_sign_link);

                    $.each(empdt.getempofficial, function(key, getempofficial) {
                        $('#comapnylist_of').val(getempofficial.company_id).change();
                        $('#deptList').val(getempofficial.dept_no).change();
                        $('#section_no').val(getempofficial.section_no).change();
                        $('#line').val(getempofficial.line).change();
                        $('#des_id').val(getempofficial.des_id).change();
                        $('#emp_type').val(getempofficial.emp_type).change();
                        $('#grade_id').val(getempofficial.grade_id);
                        $('#shift_code').val(getempofficial.shift_code).change();
                        $('#cal_code').val(getempofficial.cal_code);
                        $('#weekly_off').val(getempofficial.weekly_off);
                        $('#opt_no').val(getempofficial.opt_no);
                        $('#joining_date').val(moment(getempofficial.joining_date).format("YYYY-MM-DD"));
                        $('#as_on_join').val(getempofficial.as_on_join);
                        if (getempofficial.conform_date == null) { $('#conform_date').val(null); }
                        else { $('#conform_date').val((moment(getempofficial.conform_date).format("YYYY-MM-DD"))); }
                        if (getempofficial.increment_date == null) { $('#increment_date').val(''); }
                        else { $('#increment_date').val(moment(getempofficial.increment_date).format("YYYY-MM-DD")); }
                        $('#provision_period').val(getempofficial.provision_period);
                        $('#lv_cat_id').val(getempofficial.lv_cat_id);
                        $('#allw_cat_id').val(getempofficial.allw_cat_id);
                        $('#s_group_name').val(getempofficial.s_group_name);
                        $('#work_ent').val(getempofficial.work_ent);
                        $('#ot_ent').val(getempofficial.ot_ent);
                        $('#res_ent').val(getempofficial.res_ent);
                        $('#tran_ent').val(getempofficial.tran_ent);
                        $('#pf_ent').val(getempofficial.pf_ent);
                        $('#tax_ent').val(getempofficial.tax_ent);
                        $('#pro_fund').val(getempofficial.pro_fund);
                        $('#gross').val(getempofficial.gross);
                        $('#other_allowance').val(getempofficial.other_allowance);
                        $('#bank_ac_no').val(getempofficial.bank_ac_no);
                        $('#tin_no').val(getempofficial.tin_no);
                        $('#tax_deduction').val(getempofficial.tax_deduction);
                        $('#termination_date').val(getempofficial.termination_date);
                        $('#resigned_date').val(getempofficial.resigned_date);
                        $('#reason').val(getempofficial.reason);
                        $('#service_book_number').val(getempofficial.service_book_number);
                        $('#ac_no').val(getempofficial.ac_no);
                        if ($('#floorList').val() == null) { $('#floorList').val(getempofficial.floor_id).change(); }
                    });

                    $.each(empdt.getemploc, function(key, getemploc) {
                        $('#p_address').val(getemploc.p_address);
                        $('#p_village').val(getemploc.p_village);
                        $('#p_post_office').val(getemploc.p_post_off);
                        $('#p_police_station').val(getemploc.p_police_station);
                        $('#p_city').val(getemploc.p_city);
                        $('#p_district').val(getemploc.p_district);
                        $('#p_phone').val(getemploc.p_phone);
                        $('#p_fax').val(getemploc.p_fax);
                        $('#p_pin_code').val(getemploc.p_pin_code);
                        $('#p_cperson').val(getemploc.p_cperson);
                        $('#r_address').val(getemploc.r_address);
                        $('#r_city').val(getemploc.r_city);
                        $('#r_district').val(getemploc.r_district);
                        $('#r_phone').val(getemploc.r_phone);
                        $('#r_fax').val(getemploc.r_fax);
                        $('#r_mobile').val(getemploc.r_mobile);
                        $('#r_email').val(getemploc.r_email);
                        $('#r_cperson').val(getemploc.r_cperson);
                    });

                    $.each(empdt.getempedu, function(key, getempedu) {
                        $('#empnoedu').val(getempedu.empno);
                        $('#name_of_ins').val(getempedu.name_of_ins);
                        $('#passed_exam').val(getempedu.passed_exam);
                        $('#division').val(getempedu.division);
                        $('#year').val(getempedu.year);
                        $('#marks').val(getempedu.marks);
                        $('#board').val(getempedu.board);
                        $('#subject').val(getempedu.subject);
                    });

                    $.each(empdt.getemploc, function(key, getemploc) {
                        $('#empnoNominee').val(getemploc.empno);
                        $('#depd_name').val(getemploc.depd_name);
                        $('#depent_name_bangla').val(getemploc.depent_name_bangla);
                        $('#relationship').val(getemploc.relationship);
                        $('#relation_bn').val(getemploc.relation_bn);
                        $('#address').val(getemploc.address);
                        $('#d_age').val(getemploc.d_age);
                        $('#d_sex').val(getemploc.d_sex);
                        $('#percentage').val(getemploc.percentage);
                    });
                });
            },
            error: function(response) {}
        });
    });

    $("#empno").on('keyup', function(e) {
        e.preventDefault();
        var empno = $("#empno").val();
        $('#empof_id').val(empno);
        $('#card_no').val(empno);
        $('#empadempno').val(empno);
        $('#empnoedu').val(empno);
        $('#empnoshtcourse').val(empno);
        $('#empnoNominee').val(empno);
        $('#empnojob').val(empno);
        $('#empnotraining').val(empno);
        $('#empnoexp').val(empno);

        $.ajax({
            url: 'empsearch',
            method: 'get',
            data: { 'search_key': empno },
            success: function(response) {
                var res = response.data;
                var html = '';
                var htmldata = res.map(function(item) {
                    html += '<option value=' + item.new_empno + '>';
                });
                $("#empno_list").empty();
                $("#empno_list").append(html);
            },
            error: function(response) {}
        });
    });

    $(function() {
        $("#emppersonalSave2").submit(function(e) {
            e.preventDefault();
            var up = $('#updateorsave').val();
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            const fd = new FormData(this);
            var empno = $("#empno").val();
            $.ajax({
                url: 'empSearchExist', method: 'get', data: { 'empno': empno },
                success: function(data) {
                    $.each(data, function(key, getEmpExist) {
                        if (getEmpExist.empcount > 0 && up == 'new') {
                            Swal.fire('Error!', 'Employee No Already Exsist!', 'Error');
                        } else {
                            $.ajax({
                                url: 'emppersonalsave', method: 'POST', data: fd,
                                cache: false, contentType: false, processData: false, dataType: 'json',
                                success: function(response) {
                                    if (response.status == 200) { Swal.fire('Added!', 'Employee Added Successfully!', 'success'); }
                                    else { Swal.fire('Error!', 'Update Error!', 'Error'); }
                                },
                                error: function(response) {
                                    $('#massege').html(response.responseJSON.errors.empno);
                                }
                            });
                        }
                    });
                },
                error: function(response) { $('#massege').html(response.responseJSON.errors.empno); }
            });
        });

        $("#empofficialSave").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            const fd = new FormData(this);
            $.ajax({
                url: 'empoffcsave', method: 'POST', data: fd,
                cache: false, contentType: false, processData: false, dataType: 'json',
                success: function(response) {
                    if (response.status == 200) { Swal.fire('Added!', 'Employee Added Successfully!', 'success'); }
                    else { Swal.fire('Error!', 'Update Error!', 'Error'); }
                },
                error: function(data) { console.log(data); }
            });
        });

        $("#empadressSave").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            const fd = new FormData(this);
            $.ajax({
                url: 'empaddcsave', method: 'POST', data: fd,
                cache: false, contentType: false, processData: false, dataType: 'json',
                success: function(response) { if (response.status == 200) { Swal.fire('Added!', 'Employee Added Successfully!', 'success'); } },
                error: function(data) { console.log(data); }
            });
        });

        $("#empEduInsert").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            const fd = new FormData(this);
            $.ajax({
                url: 'empEducsave', method: 'POST', data: fd,
                cache: false, contentType: false, processData: false, dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        var empno = $('#empnoedu').val();
                        $.get("{{ URL::to('getEdu') }}" + '/' + empno, function(data) { $('#emp_edu_data').empty().html(data); });
                        Swal.fire('Added!', 'Employee Added Successfully!', 'success');
                    }
                },
                error: function(data) { console.log(data); }
            });
        });

        $("#empshort").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            const fd = new FormData(this);
            $.ajax({
                url: 'empShortSave', method: 'POST', data: fd,
                cache: false, contentType: false, processData: false, dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        var empno = $('#empnoshtcourse').val();
                        $.get("{{ URL::to('getCourse') }}" + '/' + empno, function(data) { $('#emp_course_data').empty().html(data); });
                        Swal.fire('Added!', 'Employee Added Successfully!', 'success');
                    }
                },
                error: function(response) { console.log(response); }
            });
        });

        $("#empFamForm").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            const fd = new FormData(this);
            $.ajax({
                url: 'empNomineeSave', method: 'POST', data: fd,
                cache: false, contentType: false, processData: false, dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        var empno = $('#empnoNominee').val();
                        $.get("{{ URL::to('getNome') }}" + '/' + empno, function(data) { $('#emp_nom_data').empty().html(data); });
                        Swal.fire('Added!', 'Employee Added Successfully!', 'success');
                    } else { Swal.fire('Error!', 'Nomeeni Already Added!', 'error'); }
                },
                error: function(response) { console.log(response); }
            });
        });

        $("#empJob").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            const fd = new FormData(this);
            $.ajax({
                url: 'empHistory', method: 'POST', data: fd,
                cache: false, contentType: false, processData: false, dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        var empno = $('#empnojob').val();
                        $.get("{{ URL::to('getJob') }}" + '/' + empno, function(data) { $('#emp_job_data').empty().html(data); });
                        Swal.fire('Added!', 'Employee Added Successfully!', 'success');
                    }
                },
                error: function(response) { console.log(response); }
            });
        });

        $("#empTrain").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            const fd = new FormData(this);
            $.ajax({
                url: 'empTraining', method: 'POST', data: fd,
                cache: false, contentType: false, processData: false, dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        var empno = $('#empnotraining').val();
                        $.get("{{ URL::to('getTrain') }}" + '/' + empno, function(data) { $('#emp_train_data').empty().html(data); });
                        Swal.fire('Added!', 'Employee Added Successfully!', 'success');
                    }
                },
                error: function(response) { console.log(response); }
            });
        });

        $("#empExp").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            const fd = new FormData(this);
            $.ajax({
                url: 'empExp', method: 'POST', data: fd,
                cache: false, contentType: false, processData: false, dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        var empno = $('#empnoexp').val();
                        $.get("{{ URL::to('empExper') }}" + '/' + empno, function(data) { $('#emp_exp_data').empty().html(data); });
                        Swal.fire('Added!', 'Employee Added Successfully!', 'success');
                    }
                },
                error: function(response) { console.log(response); }
            });
        });

        $(document).ready(function() {
            $('#updateorsave').val('new');
            $('#comapnylist').select2();
            $('#comapnylist_of').select2();
            $('#deptList').select2();
            $('#section_no').select2();
            $('#floorList').select2();
            $('#des_id').select2();
            $('#line').select2();
            $('#p_police_station').select2();
            $('#p_district2').select2();
            $('#r_district').select2();
            $('#emp_type').select2();
            $('#grade_id').select2();
            $('#shift_code').select2();
            $('#cal_code').select2();
            $('#opt_no').select2();
            $('#weekly_off').select2();

            $('#emppersonalUpdate').hide();

            $("#empno").on('keyup', function(e) {
                fetAllEmpEduData();
                fetAllEmpCourseData();
                fetAllEmpFamilyData();
                fetchEmpJob();
                fetchTrainData();
                fetchExpData();
            });
        });

        function fetAllEmpEduData() {
            var empno = $('#empnoedu').val();
            $.get("{{ URL::to('getEdu') }}" + '/' + empno, function(data) { $('#emp_edu_data').empty().html(data); });
        }
        function fetAllEmpCourseData() {
            var empno = $('#empnoshtcourse').val();
            $.get("{{ URL::to('getCourse') }}" + '/' + empno, function(data) { $('#emp_course_data').empty().html(data); });
        }
        function fetAllEmpFamilyData() {
            var empno = $('#empnoNominee').val();
            $.get("{{ URL::to('getNome') }}" + '/' + empno, function(data) { $('#emp_nom_data').empty().html(data); });
        }
        function fetchEmpJob() {
            var empno = $('#empnojob').val();
            $.get("{{ URL::to('getJob') }}" + '/' + empno, function(data) { $('#emp_job_data').empty().html(data); });
        }
    });

    function fetchTrainData() {
        var empno = $('#empnotraining').val();
        $.get("{{ URL::to('getTrain') }}" + '/' + empno, function(data) { $('#emp_train_data').empty().html(data); });
    }
    function fetchExpData() {
        var empno = $('#empnoexp').val();
        $.get("{{ URL::to('empExper') }}" + '/' + empno, function(data) { $('#emp_exp_data').empty().html(data); });
    }
    </script>

    <script>
    $(document).ready(function() {
        $(document).on('change', '#comapnylist', function() {
            var comapnyID = $(this).val();
            if (comapnyID) {
                $.ajax({
                    url: '/getEmp/', type: "GET",
                    data: { "_token": "{{ csrf_token() }}" }, dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#deptList').append('<option hidden>Choose Dept</option>');
                            $.each(data, function(key, emp) { $('#provision_period').val(emp.middle_name); });
                        }
                    }
                });
            }
        });

        $(document).on('change', '#comapnylist_of', function() {
            var empno = $("#empno").val();
            var comapnyID = $(this).val();
            $('select[name="floor_id"]').empty();
            if (comapnyID) {
                $.ajax({
                    url: '/floorList/' + comapnyID, type: "GET",
                    data: { "_token": "{{ csrf_token() }}" }, dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#floorList').empty();
                            $('#floorList').append('<option value="">Select One</option>');
                            $.each(data, function(key, floorList) {
                                $('select[name="floor_id"]').append('<option value="' + floorList.floor_id + '">' + floorList.floor_desc + '</option>');
                            });
                            $.ajax({
                                url: 'empDetailsSearch', method: 'get', data: { 'empno': empno },
                                success: function(data) {
                                    $.each(data, function(key, empdt) {
                                        $.each(empdt.getempofficial, function(key, getempofficial) {
                                            $('#floorList').val(getempofficial.floor_id).change();
                                        });
                                    });
                                },
                                error: function(response) {}
                            });
                        } else { $('#floor_id').append('<option>No Data</option>'); }
                    }
                });
            } else { $('#floor_id').append('<option>No Data</option>'); }
        });
    });
    </script>

    <script type="text/javascript">
    $(function() {
        var dateObj = moment(new Date()).format("YYYY-MM-DD");
        $("#as_on_date").val(dateObj);
        $("#as_on_date").datepicker({ dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true });
        $("#id_card_issue").datepicker({ dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true });
        $("#valid_till").datepicker({ dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true });
        $("#conform_date").datepicker({ dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true });
        $("#joining_date").datepicker({ dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true });
        $("#increment_date").datepicker({ dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true });
        $("#dob").datepicker({
            dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true, yearRange: '1900:+0',
            onSelect: function(selected, evnt) {
                var dateC = moment($("#as_on_date").val());
                var diff = moment($("#dob").val()).diff(dateC, 'milliseconds');
                var duration = moment.duration(diff);
                var age = duration.format().replace("-", "");
                $("#ageDet").val(age);
            }
        });
    });

    $(document).ready(function() {
        $("#clearFieldsBtn").on("click", function() {
            $('input[type="text"]').val('');
            $('input[type="number"]').val('');
            $('input[type="date"]').val('');
            $('#comapnylist').val('0');
            $('#religion_id').val('');
            $('#status').val('');
            $('#blood_group').val('');
        });
    });
    </script>

    <script>
    document.getElementById("photo").onchange = function(event) {
        const previewImage = document.getElementById("preview-image");
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onloadend = function() { previewImage.src = reader.result; }
        if (file) { reader.readAsDataURL(file); } else { previewImage.src = ""; }
    };

    document.getElementById("signature").onchange = function(event) {
        const previewImage = document.getElementById("preview-sign");
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onloadend = function() { previewImage.src = reader.result; }
        if (file) { reader.readAsDataURL(file); } else { previewImage.src = ""; }
    };
    </script>

    <script>
    $(document).ready(function() {
        $("#clearjob").on("click", function() {
            $('input[type="text"]').val(''); $('input[type="number"]').val(''); $('input[type="date"]').val('');
            $('#empnojob').val(''); $('#join_as').val(''); $('#designation').val(''); $('#join_date').val(''); $('#work_location').val('');
        });
    });
    $("#clearacedamy").on("click", function() {
        $('input[type="text"]').val(''); $('input[type="number"]').val(''); $('input[type="date"]').val('');
        $('#empnoedu').val(''); $('#name_of_ins').val(''); $('#passed_exam').val(''); $('#division').val(''); $('#year').val(''); $('#marks').val(''); $('#board').val(''); $('#subject').val('');
    });
    $("#clearaddr").on("click", function() {
        $('input[type="text"]').val(''); $('input[type="number"]').val(''); $('input[type="date"]').val('');
        $('#empadempno').val(''); $('#p_address').val(''); $('#p_village').val(''); $('#p_post_office').val(''); $('#p_police_station').val(''); $('#p_city').val(''); $('#p_district2').val(''); $('#p_pin_code').val(''); $('#p_phone').val(''); $('#p_fax').val(''); $('#p_cperson').val(''); $('#r_address').val(''); $('#r_city').val(''); $('#r_district').val(''); $('#r_phone').val(''); $('#r_fax').val(''); $('#r_mobile').val(''); $('#r_email').val(''); $('#r_cperson').val('');
    });
    $("#clearleave").on("click", function() {
        $('input[type="text"]').val(''); $('input[type="number"]').val(''); $('input[type="date"]').val('');
        $('#empnotraining').val(''); $('#t_title').val(''); $('#t_conducted_by').val(''); $('#t_from').val(''); $('#t_to').val(''); $('#to_days').val(''); $('#t_certificate').val(''); $('#skill_type').val('');
    });
    $("#clearexp").on("click", function() {
        $('input[type="text"]').val(''); $('input[type="number"]').val(''); $('input[type="date"]').val('');
        $('#empnoexp').val(''); $('#prv_emp_no').val(''); $('#organization').val(''); $('#org_address').val(''); $('#org_tel').val(''); $('#designation').val(''); $('#dept').val(''); $('#d_from').val(''); $('#d_to').val(''); $('#total_years').val(''); $('#leave_reason').val(''); $('#last_sal_drawn').val('');
    });
    $("#clearimg").on("click", function() {
        $('input[type="text"]').val(''); $('input[type="number"]').val(''); $('input[type="date"]').val('');
        $('#empnoimg').val(''); $('#photo').val(''); $('#signature').val('');
    });
    $("#clearnominee").on("click", function() {
        $('input[type="text"]').val(''); $('input[type="number"]').val(''); $('input[type="date"]').val('');
        $('#empnoNominee').val(''); $('#depd_name').val(''); $('#depent_name_bangla').val(''); $('#relationship').val(''); $('#relation_bn').val(''); $('#address').val(''); $('#address_bn').val(''); $('#d_age').val(''); $('#male').val(''); $('#female').val(''); $('#percentage').val('');
    });
    $("#clearoff").on("click", function() {
        $('input[type="text"]').val(''); $('input[type="number"]').val(''); $('input[type="date"]').val('');
        $('#empof_id').val(''); $('#comapnylist_of').val(''); $('#deptList').val(''); $('#section_no').val(''); $('#floorList').val(''); $('#line').val(''); $('#des_id').val(''); $('#emp_type').val(''); $('#grade_id').val(''); $('#shift_code').val(''); $('#cal_code').val(''); $('#weekly_off').val(''); $('#opt_no').val(''); $('#joining_date').val(''); $('#as_on_join').val(''); $('#conform_date').val(''); $('#provision_period').val(''); $('#lv_cat_id').val(''); $('#allw_cat_id').val(''); $('#shift_group').val(''); $('#appraisal_cal').val(''); $('#work_ent').val(''); $('#ot_ent').val(''); $('#res_ent').val(''); $('#tran_ent').val(''); $('#pf_ent').val(''); $('#tax_ent').val(''); $('#pro_fund').val(''); $('#increment_date').val(''); $('#gross').val(''); $('#other_allowance').val(''); $('#bank_name').val(''); $('#bank_ac_no').val(''); $('#tin_no').val(''); $('#tax_deduction').val(''); $('#dismisal_date').val(''); $('#resigned_date').val(''); $('#reason').val(''); $('#service_book_number').val(''); $('#ac_no').val('');
    });
    $("#clearshortc").on("click", function() {
        $('input[type="text"]').val(''); $('input[type="number"]').val(''); $('input[type="date"]').val('');
        $('#empnoshtcourse').val(''); $('#course_name').val(''); $('#conducted_by').val(''); $('#c_from').val(''); $('#total_day').val(''); $('#certificate').val('');
    });
    $("#cleartrain").on("click", function() {
        $('input[type="text"]').val(''); $('input[type="number"]').val(''); $('input[type="date"]').val('');
        $('#empnotraining').val(''); $('#t_title').val(''); $('#t_conducted_by').val(''); $('#t_from').val(''); $('#t_to').val(''); $('#to_days').val(''); $('#t_certificate').val(''); $('#skill_type').val('');
    });
    </script>

</body>
</html>
