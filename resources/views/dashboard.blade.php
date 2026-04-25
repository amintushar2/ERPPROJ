{{-- resources/views/hrm/dashboard.blade.php --}}
{{-- Extends your existing layout which already has the topbar --}}
@extends('layouts.app')

@push('styles')
    <style>
        :root {
            --hrm-primary: #1a3c5e;
            --hrm-accent: #0d6efd;
            --hrm-success: #198754;
            --hrm-warning: #fd7e14;
            --hrm-danger: #dc3545;
            --hrm-muted: #6c757d;
            --hrm-border: #dee2e6;
            --hrm-surface: #f8f9fa;
            --hrm-card-shadow: 0 1px 3px rgba(0, 0, 0, .06), 0 2px 8px rgba(0, 0, 0, .04);
        }

        /* ── PAGE WRAPPER ── */
        .hrm-page {
            background: var(--hrm-surface);
            min-height: calc(100vh - 56px);
            padding: 1.5rem 1.75rem;
        }

        /* ── PAGE HEADER ── */
        .hrm-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .hrm-page-title {
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--hrm-muted);
            margin-bottom: .15rem;
        }

        .hrm-page-sub {
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--hrm-primary);
            line-height: 1.2;
        }

        .hrm-db-badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .72rem;
            font-weight: 500;
            color: #7a3800;
            background: #fff3e0;
            border: 1px solid #ffe0b2;
            border-radius: 20px;
            padding: .28rem .85rem;
        }

        .hrm-db-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #22c55e;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .35
            }
        }

        /* ── STAT CARDS ── */
        .hrm-stat {
            background: #fff;
            border: 1px solid var(--hrm-border);
            border-radius: 8px;
            padding: 1.1rem 1.25rem;
            box-shadow: var(--hrm-card-shadow);
            position: relative;
            overflow: hidden;
        }

        .hrm-stat-label {
            font-size: .68rem;
            font-weight: 600;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--hrm-muted);
            margin-bottom: .5rem;
        }

        .hrm-stat-value {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
            color: var(--hrm-primary);
        }

        .hrm-stat-meta {
            font-size: .72rem;
            color: var(--hrm-muted);
            margin-top: .4rem;
        }

        .hrm-stat-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            opacity: .07;
            font-size: 3.5rem;
        }

        .hrm-stat.border-start {
            border-left-width: 3px !important;
        }

        /* ── CARDS ── */
        .hrm-card {
            background: #fff;
            border: 1px solid var(--hrm-border);
            border-radius: 8px;
            box-shadow: var(--hrm-card-shadow);
        }

        .hrm-card-header {
            padding: .85rem 1.1rem;
            border-bottom: 1px solid var(--hrm-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .hrm-card-title {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--hrm-primary);
            margin: 0;
        }

        .hrm-card-body {
            padding: 1rem 1.1rem;
        }

        /* ── TABLE ── */
        .hrm-table {
            font-size: .8rem;
            margin: 0;
        }

        .hrm-table thead th {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--hrm-muted);
            border-bottom: 2px solid var(--hrm-border);
            background: var(--hrm-surface);
            padding: .55rem .75rem;
            white-space: nowrap;
        }

        .hrm-table tbody td {
            padding: .55rem .75rem;
            border-color: var(--hrm-border);
            vertical-align: middle;
            color: #2c3e50;
        }

        .hrm-table tbody tr:hover {
            background: #f0f4ff;
        }

        /* ── BADGES ── */
        .hrm-badge {
            font-size: .65rem;
            font-weight: 600;
            padding: .22rem .6rem;
            border-radius: 4px;
            letter-spacing: .03em;
        }

        /* ── DEPT BAR ── */
        .dept-bar-wrap {
            background: #e9ecef;
            border-radius: 3px;
            height: 5px;
            flex: 1;
            overflow: hidden;
        }

        .dept-bar-fill {
            height: 100%;
            border-radius: 3px;
            transition: width .6s ease;
        }

        /* ── OT CHART ── */
        .ot-bar-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            flex: 1;
        }

        .ot-bar-outer {
            width: 100%;
            background: #e9ecef;
            border-radius: 3px 3px 0 0;
            position: relative;
            height: 80px;
            display: flex;
            align-items: flex-end;
        }

        .ot-bar-fill {
            width: 100%;
            border-radius: 3px 3px 0 0;
            background: var(--hrm-accent);
            transition: height .7s ease;
        }

        .ot-bar-label {
            font-size: .62rem;
            color: var(--hrm-muted);
            text-align: center;
            white-space: nowrap;
        }

        .ot-bar-val {
            font-size: .65rem;
            font-weight: 600;
            color: var(--hrm-primary);
        }

        /* ── MODAL PRINT ── */
        @media print {
            body>*:not(#printModal) {
                display: none !important;
            }

            .modal-dialog {
                max-width: 100% !important;
                margin: 0 !important;
            }

            .modal-footer,
            .btn-close,
            .no-print {
                display: none !important;
            }

            .hrm-table tbody tr:hover {
                background: none !important;
            }
        }

        /* ── GENDER DONUT (CSS only) ── */
        .gender-wrap {
            position: relative;
            width: 80px;
            height: 80px;
            flex-shrink: 0;
        }

        .gender-wrap svg {
            transform: rotate(-90deg);
        }

        .gender-label {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: .62rem;
            font-weight: 700;
            color: var(--hrm-primary);
        }

        /* ── AVATAR CIRCLE ── */
        .hrm-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .6rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* ── LEAVE PILLS ROW ── */
        .leave-pill {
            background: var(--hrm-surface);
            border: 1px solid var(--hrm-border);
            border-radius: 6px;
            padding: .5rem .75rem;
            text-align: center;
            flex: 1;
            min-width: 100px;
        }

        .leave-pill-name {
            font-size: .62rem;
            font-weight: 600;
            color: var(--hrm-muted);
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .leave-pill-taken {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--hrm-primary);
            line-height: 1;
        }

        .leave-pill-bal {
            font-size: .65rem;
            color: var(--hrm-success);
        }

        .hrm-clock-box {
            display: inline-flex;
            align-items: center;
            gap: 10px;

            padding: 10px 20px;
            border-radius: 30px;

            background: #fff3e0;
            border: 1px solid #ffe0b2;

            font-size: 1.1rem;
            /* 🔥 Bigger text */
            font-weight: 700;
            /* Bold */

            color: #7a3800;

            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }
    </style>
@endpush

@section('content')
    <div class="hrm-page">

        {{-- ══ PAGE HEADER ══════════════════════════════════════════════════════ --}}
        <div class="hrm-page-header">
            <div>
                <div class="hrm-page-title">Human Resource Management</div>
                <div class="hrm-page-sub">Workforce Dashboard</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="hrm-db-badge">
                    <span class="hrm-db-dot"></span>
                    Oracle HRM · Live
                </span>
                <div class="hrm-clock-box">
                    <span class="hrm-db-dot"></span>
                    <span id="liveClock"></span>
                </div>
            </div>
        </div>

        {{-- ══ ROW 1 — KPI STATS ════════════════════════════════════════════════ --}}
        <div class="row g-3 mb-3">
            <div class="col-6 col-md-3">
                <div class="hrm-stat border-start border-primary">
                    <div class="hrm-stat-label">Total Employees</div>
                    <div class="hrm-stat-value" id="statTotalEmp">{{ number_format($totalEmployees) }}</div>
                    <div class="hrm-stat-meta">Active headcount</div>
                    <span class="hrm-stat-icon">👥</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="hrm-stat border-start border-success">
                    <div class="hrm-stat-label">Present Today</div>
                    <div class="hrm-stat-value text-success" id="statPresent">{{ $todayAtt->present ?? 0 }}</div>
                    <div class="hrm-stat-meta" id="statAttendanceRate">
                        {{ $totalEmployees > 0 ? round((($todayAtt->present ?? 0) / $totalEmployees) * 100, 1) : 0 }}%
                        attendance rate
                    </div>
                    <span class="hrm-stat-icon">✅</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="hrm-stat border-start border-warning">
                    <div class="hrm-stat-label">On Leave</div>
                    <div class="hrm-stat-value text-warning" id="statOnLeave">{{ $todayAtt->on_leave ?? 0 }}</div>
                    <div class="hrm-stat-meta">
                        Late arrivals: <span id="statLate">{{ $todayAtt->late ?? 0 }}</span>
                    </div>
                    <span class="hrm-stat-icon">🏖</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="hrm-stat border-start border-danger">
                    <div class="hrm-stat-label">Absent</div>
                    <div class="hrm-stat-value text-danger" id="statAbsent">{{ $todayAtt->absent ?? 0 }}</div>
                    <div class="hrm-stat-meta">Unauthorised absence</div>
                    <span class="hrm-stat-icon">⚠</span>
                </div>
            </div>
        </div>

        {{-- ══ ROW 2 — OT CHART + DEPT + GENDER ════════════════════════════════ --}}
        <div class="row g-3 mb-3">

            {{-- AVERAGE MONTHLY OT --}}
            <div class="col-md-5">
                <div class="hrm-card h-100">
                    <div class="hrm-card-header">
                        <span class="hrm-card-title">Avg Monthly Overtime (hrs)</span>
                        <span class="text-muted" style="font-size:.68rem">Last 6 months</span>
                    </div>
                    <div class="hrm-card-body">
                        @php
                            $maxOT = collect($avgOT)->max('avg_ot') ?: 1;
                        @endphp
                        <div class="d-flex align-items-flex-end gap-2" style="height:100px" id="otBarContainer">
                            @forelse($avgOT as $row)
                                <div class="ot-bar-col">
                                    <div class="ot-bar-val">{{ $row->avg_ot }}</div>
                                    <div class="ot-bar-outer">
                                        <div class="ot-bar-fill" style="height:{{ round(($row->avg_ot / $maxOT) * 75) }}px">
                                        </div>
                                    </div>
                                    <div class="ot-bar-label">{{ substr($row->att_month, 0, 3) }}</div>
                                </div>
                            @empty
                                <div class="text-muted" style="font-size:.75rem">No overtime data available.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- DEPT HEADCOUNT --}}
            <div class="col-md-4">
                <div class="hrm-card h-100">
                    <div class="hrm-card-header">
                        <span class="hrm-card-title">Dept Headcount</span>
                    </div>
                    <div class="hrm-card-body">
                        @php
                            $maxDept = collect($deptCount)->max('cnt') ?: 1;
                            $deptColors = ['#0d6efd', '#6610f2', '#0dcaf0', '#198754', '#fd7e14', '#dc3545'];
                        @endphp
                        <div id="deptBarContainer"> {{-- ← ADD THIS WRAPPER --}}
                            @foreach ($deptCount as $i => $dept)
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div style="font-size:.72rem;color:#2c3e50;min-width:90px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"
                                        title="{{ $dept->dept_name }}">{{ $dept->dept_name }}</div>
                                    <div class="dept-bar-wrap">
                                        <div class="dept-bar-fill"
                                            style="width:{{ round(($dept->cnt / $maxDept) * 100) }}%;background:{{ $deptColors[$i % count($deptColors)] }}">
                                        </div>
                                    </div>
                                    <div
                                        style="font-size:.72rem;font-weight:600;color:var(--hrm-primary);min-width:24px;text-align:right">
                                        {{ $dept->cnt }}</div>
                                </div>
                            @endforeach
                        </div> {{-- ← CLOSE WRAPPER --}}
                    </div>
                </div>
            </div>

            {{-- GENDER + LEAVE SUMMARY --}}
            <div class="col-md-3">
                <div class="hrm-card h-100">
                    <div class="hrm-card-header">
                        <span class="hrm-card-title">Gender Split</span>
                    </div>
                    <div class="hrm-card-body">
                        @php
                            $male =
                                collect($genderSplit)->firstWhere('sex', 'Male')->cnt ??
                                (collect($genderSplit)->firstWhere('sex', 'M')->cnt ?? 0);
                            $female =
                                collect($genderSplit)->firstWhere('sex', 'Female')->cnt ??
                                (collect($genderSplit)->firstWhere('sex', 'F')->cnt ?? 0);
                            $gTotal = $male + $female ?: 1;
                            $mPct = round(($male / $gTotal) * 100);
                            $fPct = round(($female / $gTotal) * 100);
                            $circum = 2 * 3.14159 * 30;
                            $maleDash = round(($mPct / 100) * $circum, 2);
                            $femaleDash = $circum - $maleDash;
                        @endphp
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="gender-wrap">
                                <svg width="80" height="80" viewBox="0 0 80 80">
                                    <circle cx="40" cy="40" r="30" fill="none" stroke="#e9ecef"
                                        stroke-width="10" />
                                    <circle id="genderMaleArc" cx="40" cy="40" r="30" fill="none"
                                        stroke="#0d6efd" stroke-width="10"
                                        stroke-dasharray="{{ $maleDash }} {{ $femaleDash }}"
                                        stroke-linecap="butt" />
                                    <circle id="genderFemaleArc" cx="40" cy="40" r="30" fill="none"
                                        stroke="#f06595" stroke-width="10"
                                        stroke-dasharray="{{ $femaleDash }} {{ $maleDash }}"
                                        stroke-dashoffset="{{ -$maleDash }}" stroke-linecap="butt" />
                                </svg>
                                <div class="gender-label" id="genderTotal">{{ $gTotal }}</div>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-1 mb-1">
                                    <span
                                        style="width:8px;height:8px;border-radius:50%;background:#0d6efd;display:inline-block"></span>
                                    <span style="font-size:.72rem;color:var(--hrm-muted)">Male</span>
                                    <span id="genderMaleCount"
                                        style="font-size:.72rem;font-weight:700;color:var(--hrm-primary);margin-left:4px">{{ $male }}
                                        ({{ $mPct }}%)</span>

                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <span
                                        style="width:8px;height:8px;border-radius:50%;background:#f06595;display:inline-block"></span>
                                    <span style="font-size:.72rem;color:var(--hrm-muted)">Female</span>
                                    <span id="genderFemaleCount"
                                        style="font-size:.72rem;font-weight:700;color:var(--hrm-primary);margin-left:4px">{{ $female }}
                                        ({{ $fPct }}%)</span>

                                </div>
                            </div>
                        </div>
                        {{-- Leave pills --}}
                        <div
                            style="font-size:.62rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--hrm-muted);margin-bottom:.5rem">
                            Leave Taken ({{ now()->year }})</div>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($leaveSummary as $lv)
                                <div class="leave-pill">
                                    <div class="leave-pill-name">{{ Str::limit($lv->leave_name, 10) }}</div>
                                    <div class="leave-pill-taken">{{ $lv->total_taken }}</div>
                                    <div class="leave-pill-bal">Bal: {{ $lv->total_balance }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ ROW 3 — ACTION BUTTONS + RECENT JOINERS ══════════════════════════ --}}
        <div class="row g-3 mb-3">
            <div class="col-md-8">
                <div class="hrm-card">
                    <div class="hrm-card-header">
                        <span class="hrm-card-title">Recent Joiners <span class="text-muted fw-normal"
                                style="text-transform:none;letter-spacing:0">(last 30 days)</span></span>
                    </div>
                    <div class="table-responsive">
                        <table class="table hrm-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Emp No</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Join Date</th>
                                    <th>Gender</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentJoiners as $i => $emp)
                                    <tr>
                                        <td class="text-muted">{{ $i + 1 }}</td>
                                        <td><span class="fw-600">{{ $emp->empno }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="hrm-avatar"
                                                    style="background:{{ $emp->sex == 'Male' || $emp->sex == 'M' ? '#dbeafe' : '#fce7f3' }};color:{{ $emp->sex == 'Male' || $emp->sex == 'M' ? '#1e40af' : '#9d174d' }}">
                                                    {{ strtoupper(substr($emp->emp_name, 0, 2)) }}
                                                </div>
                                                {{ $emp->emp_name }}
                                            </div>
                                        </td>
                                        <td>{{ $emp->dept_name }}</td>
                                        <td>{{ $emp->designation_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($emp->joining_date)->format('d M Y') }}</td>
                                        <td>
                                            <span
                                                class="hrm-badge {{ in_array($emp->sex, ['Male', 'M']) ? 'bg-primary bg-opacity-10 text-primary' : 'bg-pink text-danger' }}">
                                                {{ $emp->sex }} </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-3" style="font-size:.78rem">
                                            No new joiners in the last 30 days.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- QUICK ACTION BUTTONS --}}
            <div class="col-md-4">
                <div class="hrm-card h-100">
                    <div class="hrm-card-header">
                        <span class="hrm-card-title">Alerts & Actions</span>
                    </div>
                    <div class="hrm-card-body d-flex flex-column gap-2">

                        {{-- Probation Ending --}}
                        <button
                            class="btn btn-outline-warning btn-sm d-flex align-items-center justify-content-between w-100 text-start"
                            data-bs-toggle="modal" data-bs-target="#modalProbation">
                            <span>
                                <i class="bi bi-hourglass-split me-2"></i>
                                Probation Ending This Month
                            </span>
                            <span class="badge bg-warning text-dark"
                                id="badgeProbation">{{ count($probationEnd) }}</span>
                        </button>

                        {{-- Increment This Month --}}
                        <button
                            class="btn btn-outline-success btn-sm d-flex align-items-center justify-content-between w-100 text-start"
                            data-bs-toggle="modal" data-bs-target="#modalIncrementThis">
                            <span>
                                <i class="bi bi-graph-up-arrow me-2"></i>
                                Increment Due This Month
                            </span>
                            <span class="badge bg-success" id="badgeIncrThis">{{ count($incrementThisMonth) }}</span>
                        </button>

                        {{-- Increment Next Month --}}
                        <button
                            class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-between w-100 text-start"
                            data-bs-toggle="modal" data-bs-target="#modalIncrementNext">
                            <span>
                                <i class="bi bi-calendar2-plus me-2"></i>
                                Increment Due Next Month
                            </span>
                            <span class="badge bg-primary"
                                id="badgeIncrNext">{{ count($incrementNextMonth ?? []) }}</span>
                        </button>

                        <hr class="my-1">

                        <div class="text-muted"
                            style="font-size:.68rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase">Quick
                            Links</div>

                        <a href="#" class="btn btn-light btn-sm text-start border">
                            <i class="bi bi-person-plus me-2 text-primary"></i> Add New Employee
                        </a>
                        <a href="#" class="btn btn-light btn-sm text-start border">
                            <i class="bi bi-file-earmark-text me-2 text-success"></i> Leave Applications
                        </a>
                        <a href="#" class="btn btn-light btn-sm text-start border">
                            <i class="bi bi-clock-history me-2 text-warning"></i> Attendance Report
                        </a>
                        <a href="#" class="btn btn-light btn-sm text-start border">
                            <i class="bi bi-cash-stack me-2 text-danger"></i> Payroll Processing
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /hrm-page --}}


    {{-- ══════════════════════════════════════════════════════════════════════════
     MODALS
════════════════════════════════════════════════════════════════════════════ --}}

    {{-- ── MODAL: PROBATION ENDING THIS MONTH ── --}}
    <div class="modal fade" id="modalProbation" tabindex="-1" aria-labelledby="modalProbationLabel">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header py-2 px-3" style="background:var(--hrm-primary)">
                    <h6 class="modal-title text-white mb-0" id="modalProbationLabel">
                        <i class="bi bi-hourglass-split me-2"></i>
                        Probation Period Ending — {{ now()->format('F Y') }}
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table hrm-table" id="tblProbation">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Emp No</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Join Date</th>
                                    <th>Probation Period</th>
                                    <th>Confirm Date</th>
                                    <th>Months Served</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($probationEnd as $i => $emp)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $emp->empno }}</td>
                                        <td>{{ $emp->emp_name }}</td>
                                        <td>{{ $emp->dept_name }}</td>
                                        <td>{{ $emp->designation_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($emp->joining_date)->format('d M Y') }}</td>
                                        <td>{{ $emp->provision_period }} months</td>
                                        <td>
                                            @if ($emp->conform_date)
                                                {{ \Carbon\Carbon::parse($emp->conform_date)->format('d M Y') }}
                                            @else
                                                <span class="text-warning fw-semibold">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $emp->months_served }}</td>
                                        <td>
                                            <span class="hrm-badge bg-warning bg-opacity-15 text-warning">Due</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4">No probation confirmations
                                            due this month.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer py-2 px-3 no-print">
                    <span class="text-muted me-auto" style="font-size:.72rem">{{ count($probationEnd) }} record(s)</span>
                    <button class="btn btn-outline-secondary btn-sm"
                        onclick="printModal('tblProbation','Probation Period Ending — {{ now()->format('F Y') }}')">
                        <i class="bi bi-printer me-1"></i> Print
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ── MODAL: INCREMENT DUE THIS MONTH ── --}}
    <div class="modal fade" id="modalIncrementThis" tabindex="-1" aria-labelledby="modalIncrThisLabel">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header py-2 px-3" style="background:#198754">
                    <h6 class="modal-title text-white mb-0" id="modalIncrThisLabel">
                        <i class="bi bi-graph-up-arrow me-2"></i>
                        Increment Due This Month — {{ now()->format('F Y') }}
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table hrm-table" id="tblIncrThis">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Emp No</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Increment Date</th>
                                    <th>Current Gross</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($incrementThisMonth as $i => $emp)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $emp->empno }}</td>
                                        <td>{{ $emp->emp_name }}</td>
                                        <td>{{ $emp->dept_name }}</td>
                                        <td>{{ $emp->designation_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($emp->increment_date)->format('d M Y') }}</td>
                                        <td class="fw-semibold text-success">{{ number_format($emp->gross, 2) }}</td>
                                        <td class="no-print">
                                            <span class="hrm-badge bg-success bg-opacity-15 text-success">Process</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">No increments due this
                                            month.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer py-2 px-3 no-print">
                    <span class="text-muted me-auto" style="font-size:.72rem">{{ count($incrementThisMonth) }}
                        record(s)</span>
                    <button class="btn btn-outline-secondary btn-sm"
                        onclick="printModal('tblIncrThis','Increment Due — {{ now()->format('F Y') }}')">
                        <i class="bi bi-printer me-1"></i> Print
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ── MODAL: INCREMENT DUE NEXT MONTH ── --}}
    <div class="modal fade" id="modalIncrementNext" tabindex="-1" aria-labelledby="modalIncrNextLabel">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header py-2 px-3" style="background:#0d6efd">
                    <h6 class="modal-title text-white mb-0" id="modalIncrNextLabel">
                        <i class="bi bi-calendar2-plus me-2"></i>
                        Increment Due Next Month — {{ now()->addMonth()->format('F Y') }}
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table hrm-table" id="tblIncrNext">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Emp No</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Increment Date</th>
                                    <th>Current Gross</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($incrementNextMonth as $i => $emp)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $emp->empno }}</td>
                                        <td>{{ $emp->emp_name }}</td>
                                        <td>{{ $emp->dept_name }}</td>
                                        <td>{{ $emp->designation_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($emp->increment_date)->format('d M Y') }}</td>
                                        <td class="fw-semibold">{{ number_format($emp->gross, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">No increments due next
                                            month.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer py-2 px-3 no-print">
                    <span class="text-muted me-auto" style="font-size:.72rem">{{ count($incrementNextMonth) }}
                        record(s)</span>
                    <button class="btn btn-outline-secondary btn-sm"
                        onclick="printModal('tblIncrNext','Increment Due Next Month — {{ now()->addMonth()->format('F Y') }}')">
                        <i class="bi bi-printer me-1"></i> Print
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{--
    ════════════════════════════════════════════════════════════════
    DASHBOARD AUTO-REFRESH  — paste inside @push('scripts')
    in your dashboard_blade.php, AFTER the existing clock script.

    Polls /dashboard/live-data every 60 seconds and updates:
      • All 4 KPI stat cards (Total / Present / On Leave / Absent)
      • Dept Headcount bars
      • Gender donut SVG
      • OT bar chart
      • Alert badge counts (Probation / Increment)
      • Last-updated timestamp badge
    ════════════════════════════════════════════════════════════════
--}}

    <script>
        // ─────────────────────────────────────────────────────────────────
        // CONFIG
        // ─────────────────────────────────────────────────────────────────
        const REFRESH_INTERVAL_MS = 60000; // 60 seconds — change freely
        const LIVE_DATA_URL = '{{ route('hrm.dashboard.liveData') }}';

        // ─────────────────────────────────────────────────────────────────
        // BADGE: "Last updated" shown in the page header
        // We inject it next to the Oracle HRM badge automatically.
        // ─────────────────────────────────────────────────────────────────
        function injectUpdatedBadge() {
            if (document.getElementById('lastUpdatedBadge')) return; // already exists

            const badge = document.createElement('span');
            badge.id = 'lastUpdatedBadge';
            badge.style.cssText = `
        display:inline-flex;align-items:center;gap:.4rem;
        font-size:.72rem;font-weight:500;color:#155724;
        background:#d4edda;border:1px solid #c3e6cb;
        border-radius:20px;padding:.28rem .85rem;
    `;
            badge.innerHTML = '<i class="bi bi-arrow-repeat"></i> <span id="lastUpdatedText">Updating…</span>';

            // Insert after the Oracle HRM badge
            const hrmBadge = document.querySelector('.hrm-db-badge');
            if (hrmBadge) hrmBadge.insertAdjacentElement('afterend', badge);
        }

        // ─────────────────────────────────────────────────────────────────
        // KPI CARD UPDATER — animates the number change
        // ─────────────────────────────────────────────────────────────────
        function animateValue(el, newVal) {
            if (!el) return;
            const current = parseInt(el.textContent.replace(/,/g, '')) || 0;
            const target = parseInt(String(newVal).replace(/,/g, '')) || 0;
            if (current === target) return;

            const step = target > current ? 1 : -1;
            const diff = Math.abs(target - current);
            const duration = Math.min(600, diff * 15); // max 600ms
            const interval = Math.max(10, duration / diff);

            let cur = current;
            const timer = setInterval(() => {
                cur += step;
                el.textContent = cur.toLocaleString();
                if (cur === target) clearInterval(timer);
            }, interval);
        }

        // ─────────────────────────────────────────────────────────────────
        // DEPT BAR CHART UPDATER
        // ─────────────────────────────────────────────────────────────────
        const DEPT_COLORS = ['#0d6efd', '#6610f2', '#0dcaf0', '#198754', '#fd7e14', '#dc3545', '#6c757d', '#20c997'];

        function updateDeptBars(deptData) {
            const container = document.getElementById('deptBarContainer');
            if (!container || !deptData.length) return;

            const maxCnt = Math.max(...deptData.map(d => d.cnt), 1);

            // Build new rows
            const html = deptData.map((dept, i) => `
        <div class="d-flex align-items-center gap-2 mb-2">
            <div style="font-size:.72rem;color:#2c3e50;min-width:90px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"
                 title="${escHtml(dept.dept_name)}">${escHtml(dept.dept_name)}</div>
            <div class="dept-bar-wrap">
                <div class="dept-bar-fill"
                     style="width:0%;background:${DEPT_COLORS[i % DEPT_COLORS.length]};transition:width .7s ease">
                </div>
            </div>
            <div style="font-size:.72rem;font-weight:600;color:var(--hrm-primary);min-width:24px;text-align:right">
                ${dept.cnt}
            </div>
        </div>
    `).join('');

            container.innerHTML = html;

            // Animate bars in after paint
            requestAnimationFrame(() => {
                container.querySelectorAll('.dept-bar-fill').forEach((bar, i) => {
                    const pct = Math.round((deptData[i].cnt / maxCnt) * 100);
                    bar.style.width = pct + '%';
                });
            });
        }

        // ─────────────────────────────────────────────────────────────────
        // GENDER DONUT UPDATER
        // ─────────────────────────────────────────────────────────────────
        function updateGenderDonut(genderData) {
            const male = (genderData.find(g => g.sex === 'M' || g.sex === 'Male') || {}).cnt ?? 0;
            const female = (genderData.find(g => g.sex === 'F' || g.sex === 'Female') || {}).cnt ?? 0;
            const total = male + female || 1;

            const mPct = Math.round((male / total) * 100);
            const circum = 2 * Math.PI * 30;
            const maleDash = Math.round((mPct / 100) * circum * 100) / 100;
            const femDash = Math.round((circum - maleDash) * 100) / 100;

            // Male arc
            const maleCircle = document.getElementById('genderMaleArc');
            if (maleCircle) {
                maleCircle.setAttribute('stroke-dasharray', `${maleDash} ${femDash}`);
            }
            // Female arc
            const femCircle = document.getElementById('genderFemaleArc');
            if (femCircle) {
                femCircle.setAttribute('stroke-dasharray', `${femDash} ${maleDash}`);
                femCircle.setAttribute('stroke-dashoffset', `-${maleDash}`);
            }
            // Centre total
            const totalEl = document.getElementById('genderTotal');
            if (totalEl) totalEl.textContent = total.toLocaleString();

            // Legend numbers
            const maleCountEl = document.getElementById('genderMaleCount');
            const femaleCountEl = document.getElementById('genderFemaleCount');
            if (maleCountEl) maleCountEl.textContent = `${male} (${mPct}%)`;
            if (femaleCountEl) femaleCountEl.textContent = `${female} (${100 - mPct}%)`;
        }

        // ─────────────────────────────────────────────────────────────────
        // OT BAR CHART UPDATER
        // ─────────────────────────────────────────────────────────────────
        function updateOTChart(otData) {
            const container = document.getElementById('otBarContainer');
            if (!container || !otData.length) return;

            const maxOT = Math.max(...otData.map(d => parseFloat(d.avg_ot) || 0), 1);

            container.innerHTML = otData.map(row => `
        <div class="ot-bar-col">
            <div class="ot-bar-val">${row.avg_ot}</div>
            <div class="ot-bar-outer">
                <div class="ot-bar-fill" style="height:0px;transition:height .7s ease"></div>
            </div>
            <div class="ot-bar-label">${escHtml(String(row.att_month).substring(0,3))}</div>
        </div>
    `).join('');

            requestAnimationFrame(() => {
                container.querySelectorAll('.ot-bar-fill').forEach((bar, i) => {
                    const h = Math.round((parseFloat(otData[i].avg_ot) / maxOT) * 75);
                    bar.style.height = h + 'px';
                });
            });
        }

        // ─────────────────────────────────────────────────────────────────
        // REFRESH INDICATOR — spinner flash on card
        // ─────────────────────────────────────────────────────────────────
        function flashRefresh() {
            document.querySelectorAll('.hrm-stat').forEach(card => {
                card.style.transition = 'opacity .2s';
                card.style.opacity = '.6';
                setTimeout(() => {
                    card.style.opacity = '1';
                }, 300);
            });
        }

        // ─────────────────────────────────────────────────────────────────
        // HELPER — escape HTML for dynamic content
        // ─────────────────────────────────────────────────────────────────
        function escHtml(str) {
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
        }

        // ─────────────────────────────────────────────────────────────────
        // MAIN FETCH — gets JSON and dispatches all updaters
        // ─────────────────────────────────────────────────────────────────
        function fetchDashboardData() {
            fetch(LIVE_DATA_URL, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(res => {
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    return res.json();
                })
                .then(data => {
                    if (!data.success) return;

                    flashRefresh();

                    // ── KPI stat values ──────────────────────────────────────────────
                    animateValue(document.getElementById('statTotalEmp'), data.total_employees);
                    animateValue(document.getElementById('statPresent'), data.present);
                    animateValue(document.getElementById('statOnLeave'), data.on_leave);
                    animateValue(document.getElementById('statAbsent'), data.absent);
                    animateValue(document.getElementById('statLate'), data.late);

                    // Attendance rate text
                    const rateEl = document.getElementById('statAttendanceRate');
                    if (rateEl) rateEl.textContent = data.attendance_rate + '% attendance rate';

                    // ── Charts ───────────────────────────────────────────────────────
                    updateDeptBars(data.deptCount);
                    updateGenderDonut(data.genderSplit);
                    updateOTChart(data.avg_ot);

                    // ── Alert badge counts ────────────────────────────────────────────
                    const probBadge = document.getElementById('badgeProbation');
                    const incrThis = document.getElementById('badgeIncrThis');
                    const incrNext = document.getElementById('badgeIncrNext');
                    if (probBadge) probBadge.textContent = data.probationEnd.length;
                    if (incrThis) incrThis.textContent = data.incrementThisMonth.length;
                    if (incrNext) incrNext.textContent = data.incrementNextMonth.length;
                    console.log(data.incrementThisMonth.length);
                    // ── Timestamp ────────────────────────────────────────────────────
                    const el = document.getElementById('lastUpdatedText');
                    if (el) el.textContent = 'Updated ' + data.updated_at;
                })
                .catch(err => {
                    console.warn('[Dashboard] Refresh failed:', err.message);
                    const el = document.getElementById('lastUpdatedText');
                    if (el) el.textContent = '⚠ Refresh failed — retrying…';
                });
        }

        // ─────────────────────────────────────────────────────────────────
        // BOOT — run once page is ready, then poll on interval
        // ─────────────────────────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', () => {
            injectUpdatedBadge();

            // First refresh after 60s; initial data already rendered by Blade
            setTimeout(() => {
                fetchDashboardData();
                setInterval(fetchDashboardData, REFRESH_INTERVAL_MS);
            }, REFRESH_INTERVAL_MS);
        });
    </script>
    <script>
        function printModal(tableId, title) {
            console.log('Print function called for table:', tableId, 'with title:', title);
            const table = document.getElementById(tableId);
            if (!table) {
                alert('Table not found: ' + tableId);
                return;
            }

            const safeTitle = title.replace(/</g, "&lt;").replace(/>/g, "&gt;");

            const clone = table.cloneNode(true);
            clone.querySelectorAll('.no-print').forEach(el => el.remove());

            const win = window.open('', '_blank', 'width=900,height=650');
            if (!win) {
                alert('Popup blocked! Allow popups.');
                return;
            }

            win.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>${safeTitle}</title>
                <style>
                    body { font-family: Arial; font-size: 11px; margin: 20px; }
                    table { width:100%; border-collapse:collapse; }
                    th { background:#1a3c5e; color:#fff; padding:6px; }
                    td { padding:5px; border-bottom:1px solid #ccc; }
                </style>
            </head>
            <body>
                <h3>${safeTitle}</h3>
                ${clone.outerHTML}
            </body>
            </html>
        `);

            win.document.close();

            // KEY FIX HERE
            setTimeout(() => {
                win.focus();
                win.print();
            }, 500);
        }
    </script>
    <script>
        function updateClock() {
            const now = new Date();

            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            };

            const date = now.toLocaleDateString('en-GB', options);

            const time = now.toLocaleTimeString('en-GB', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true

            });

            document.getElementById('liveClock').innerHTML = date + ' ' + time;
        }

        // run immediately
        updateClock();

        // update every second
        setInterval(updateClock, 1000);
    </script>
@endpush
