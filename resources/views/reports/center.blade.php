{{--
    resources/views/reports/center.blade.php
    HRM Report Center — Bootstrap 5 UI
    Fixes:
      [1] LOV fields → rendered as <select> dropdowns (data served inline from controller)
      [2] Date format → DD-MM-YYYY display via flatpickr, sent as DD-MON-YYYY to Oracle
--}}

@extends('layouts.app')

@section('title', 'HRM Report Center')

@push('styles')
    {{-- Bootstrap 5 --}}


    {{-- Flatpickr (DD-MM-YYYY date picker) --}}

    <style>
        :root {
            --hrm-primary: #003366;
            --hrm-secondary: #0055a5;
            --hrm-accent: #e8a020;
            --hrm-light: #f4f7fb;
            --hrm-border: #d0dce8;
        }

        body {
            background-color: var(--hrm-light);
            font-family: 'Segoe UI', sans-serif;
            font-size: 0.875rem;
        }

        /* ── Navbar ── */
        .navbar-hrm {
            background: linear-gradient(135deg, var(--hrm-primary) 0%, var(--hrm-secondary) 100%);
            border-bottom: 3px solid var(--hrm-accent);
            padding: 0.5rem 1.5rem;
        }

        .navbar-hrm .navbar-brand {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: .3px;
        }

        .navbar-hrm .nav-badge {
            background: var(--hrm-accent);
            color: #fff;
            font-size: .7rem;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 600;
        }

        /* ── Page Header ── */
        .page-header {
            background: #fff;
            border-bottom: 1px solid var(--hrm-border);
            padding: .75rem 1.5rem;
        }

        .page-header h5 {
            color: var(--hrm-primary);
            font-weight: 700;
            margin: 0;
        }

        .breadcrumb {
            margin: 0;
            font-size: .78rem;
        }

        .breadcrumb-item.active {
            color: var(--hrm-secondary);
        }

        /* ── Card ── */
        .card {
            border: 1px solid var(--hrm-border);
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 51, 102, .07);
        }

        .card-header-hrm {
            background: linear-gradient(135deg, var(--hrm-primary) 0%, var(--hrm-secondary) 100%);
            color: #fff;
            border-radius: 7px 7px 0 0 !important;
            padding: .65rem 1rem;
            font-weight: 600;
            font-size: .875rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        /* ── Form Controls ── */
        .form-label {
            font-weight: 600;
            color: #444;
            margin-bottom: .25rem;
            font-size: .8rem;
        }

        .form-control,
        .form-select {
            border-color: var(--hrm-border);
            font-size: .85rem;
            border-radius: 5px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--hrm-secondary);
            box-shadow: 0 0 0 .18rem rgba(0, 85, 165, .18);
        }

        .input-group-text {
            background: var(--hrm-light);
            border-color: var(--hrm-border);
            color: var(--hrm-secondary);
            font-size: .85rem;
        }

        /* ── LOV Select2 fix for input-group ── */
        .input-group .select2-container {
            flex: 1 1 auto;
            width: 1% !important;
        }

        .input-group .select2-container .select2-selection--single {
            height: 36px;
            border-radius: 0 5px 5px 0 !important;
            border-left: 0 !important;
            border-color: var(--hrm-border) !important;
            display: flex;
            align-items: center;
        }

        .input-group .select2-container .select2-selection__rendered {
            line-height: normal;
            font-size: .85rem;
        }

        .input-group .select2-container .select2-selection__arrow {
            height: 34px;
        }

        /* ── Flatpickr styling to match Bootstrap ── */
        .flatpickr-input {
            background: #fff !important;
        }

        .flatpickr-calendar {
            font-size: .82rem;
        }

        .flatpickr-day.selected,
        .flatpickr-day.selected:hover {
            background: var(--hrm-secondary);
            border-color: var(--hrm-secondary);
        }

        /* ── Parameter section ── */
        #param-section {
            border-top: 2px dashed var(--hrm-border);
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .param-section-title {
            font-size: .78rem;
            font-weight: 700;
            color: var(--hrm-secondary);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: .75rem;
        }

        .param-row {
            animation: fadeSlide .25s ease forwards;
            opacity: 0;
        }

        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── Buttons ── */
        .btn-run {
            background: linear-gradient(135deg, var(--hrm-primary), var(--hrm-secondary));
            color: #fff;
            border: none;
            font-weight: 600;
            padding: .45rem 1.5rem;
            font-size: .875rem;
            border-radius: 5px;
            transition: opacity .2s;
        }

        .btn-run:hover:not(:disabled) {
            opacity: .88;
            color: #fff;
        }

        .btn-run:disabled {
            opacity: .6;
            cursor: not-allowed;
        }

        .btn-reset {
            border: 1px solid var(--hrm-border);
            color: #555;
            font-size: .875rem;
        }

        /* ── Alerts ── */
        .alert-hrm-error {
            background: #fff3f3;
            border-left: 4px solid #dc3545;
            color: #842029;
            font-size: .82rem;
            border-radius: 0 5px 5px 0;
            padding: .5rem .75rem;
        }

        .alert-hrm-success {
            background: #f0fff4;
            border-left: 4px solid #198754;
            color: #155724;
            font-size: .82rem;
            border-radius: 0 5px 5px 0;
            padding: .5rem .75rem;
        }

        /* ── Skeleton ── */
        .skeleton {
            background: linear-gradient(90deg, #e8ecf0 25%, #d0dae4 50%, #e8ecf0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.2s infinite;
            border-radius: 4px;
            height: 34px;
            margin-bottom: .75rem;
        }

        @keyframes shimmer {
            from {
                background-position: 200% 0
            }

            to {
                background-position: -200% 0
            }
        }

        /* ── Info bar ── */
        .report-info-bar {
            background: #eef4fc;
            border: 1px solid var(--hrm-border);
            border-radius: 5px;
            padding: .5rem .85rem;
            font-size: .78rem;
            color: var(--hrm-secondary);
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        /* ── Footer ── */
        .footer-bar {
            background: var(--hrm-primary);
            color: rgba(255, 255, 255, .55);
            text-align: center;
            font-size: .72rem;
            padding: .5rem;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }

        /* ── Date display helper ── */
        .date-display-txt {
            font-size: .72rem;
            color: var(--hrm-secondary);
            margin-top: 2px;
            display: block;
        }
    </style>
@endpush

@section('content')
    {{-- ── Navbar ── --}}
    <nav class="navbar navbar-hrm">
        <span class="navbar-brand">
            <i class="bi bi-grid-3x3-gap-fill me-2"></i>Four Design (Pvt.) Ltd.
        </span>
        <span class="nav-badge"><i class="bi bi-person-badge me-1"></i>HRM Module</span>
    </nav>

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5><i class="bi bi-file-earmark-bar-graph me-2" style="color:var(--hrm-accent)"></i>Report Center
            </h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" style="color:var(--hrm-secondary)">HRM</a>
                    </li>
                    <li class="breadcrumb-item active">Report Center</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- ── Main Content ── --}}
    <div class="container-fluid px-4 py-3" style="max-width:960px; padding-bottom:3rem;">

        @if (session('error'))
            <div class="alert-hrm-error mb-3">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>{{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header-hrm">
                <i class="bi bi-sliders"></i>Report Selection &amp; Parameters
            </div>
            <div class="card-body p-3">

                {{-- ── Report Dropdown ── --}}
                <div class="row g-2 align-items-end mb-2">
                    <div class="col-md-9">
                        <label class="form-label" for="report_no">
                            <i class="bi bi-list-ul me-1" style="color:var(--hrm-secondary)"></i>Select Report
                        </label>
                        <select class="form-select" id="report_no" name="report_no">
                            <option value="">-- Select a Report --</option>
                            @foreach ($reports as $report)
                                <option value="{{ $report->report_id }}">{{ $report->report_title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-secondary btn-reset w-100" id="btn-reset" type="button">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                        </button>
                    </div>
                </div>

                {{-- ── Report Info Bar ── --}}
                <div class="report-info-bar d-none mt-2" id="report-info-bar">
                    <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                    <span id="report-file-label"></span>
                    <span class="ms-auto text-muted" id="param-count-label"></span>
                </div>

                {{-- ── Dynamic Parameter Fields ── --}}
                <div id="param-section" class="d-none">
                    <div class="param-section-title mt-3">
                        <i class="bi bi-funnel me-1"></i>Report Parameters
                    </div>
                    <div id="loading-skeleton" class="d-none">
                        <div class="skeleton"></div>
                        <div class="skeleton" style="width:70%"></div>
                        <div class="skeleton" style="width:85%"></div>
                    </div>
                    <div id="dynamic-params" class="row g-3"></div>
                </div>

                {{-- ── Action Buttons ── --}}
                <div class="d-flex gap-2 align-items-center mt-3 pt-3 border-top" id="action-bar"
                    style="display:none!important">
                    <button class="btn btn-run" id="btn-run" type="button">
                        <i class="bi bi-play-fill me-1"></i>Run Report
                    </button>
                    <div id="status-msg" class="ms-2"></div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bar">
        HRM Report Center &nbsp;|&nbsp; Oracle Reports Server: {{ config('hrm.report_server_url') }}
    </div>

    {{-- ── Scripts ── --}}
@endsection

@push('scripts')
    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        const reportSel = document.getElementById('report_no');
        const paramSec = document.getElementById('param-section');
        const dynDiv = document.getElementById('dynamic-params');
        const actionBar = document.getElementById('action-bar');
        const btnRun = document.getElementById('btn-run');
        const btnReset = document.getElementById('btn-reset');
        const statusMsg = document.getElementById('status-msg');
        const infoBar = document.getElementById('report-info-bar');
        const fileLabel = document.getElementById('report-file-label');
        const cntLabel = document.getElementById('param-count-label');
        const skeleton = document.getElementById('loading-skeleton');
        const runReportUrl = @json(route('reports.run'));

        // Track flatpickr instances to destroy on reset
        let flatpickrInstances = [];

        // ── Init Select2 on the main report dropdown ────────────────────────
        $(reportSel).select2({
            theme: 'bootstrap-5',
            placeholder: '-- Select a Report --',
            allowClear: true,
            width: '100%'
        });

        // ── WHEN-LIST-CHANGED → SHOW_PRM_IN_MOOD ───────────────────────────
        $(reportSel).on('change', async function() {
            const reportId = this.value;

            // Oracle: ITEM_VELUE_NULL — reset everything
            clearAll();
            if (!reportId) return;

            skeleton.classList.remove('d-none');
            paramSec.classList.remove('d-none');

            try {
                const res = await fetch(`/hrm/reports/${reportId}/parameters`);
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                const data = await res.json();

                skeleton.classList.add('d-none');

                fileLabel.textContent = 'File: ' + (data.report_file_name || '—');
                cntLabel.textContent = data.parameters.length + ' parameter(s)';
                infoBar.classList.remove('d-none');

                if (!data.parameters.length) {
                    dynDiv.innerHTML = `<div class="col-12 text-muted small">
                <i class="bi bi-info-circle me-1"></i>No parameters required for this report.
            </div>`;
                } else {
                    dynDiv.innerHTML = data.parameters.map((p, i) => buildField(p, i)).join('');
                    initDynamicControls(); // Init Select2 on LOV dropdowns + flatpickr on dates
                }

                actionBar.style.removeProperty('display');
                clearStatus();
                focusFirstParameter();

            } catch (e) {
                skeleton.classList.add('d-none');
                showError('HRM-1006: The error is — ' + e.message);
            }
        });

        // ── WHEN-BUTTON-PRESSED (RUN_REPORTS) ──────────────────────────────
        btnRun.addEventListener('click', async function() {
            const reportId = reportSel.value;
            if (!reportId) return;

            // Collect all parameter values
            // For LOV selects → use the selected value
            // For date fields → read data-oracle-value (DD-MM-YYYY converted by flatpickr onChange)
            const parameters = {};

            dynDiv.querySelectorAll('[data-param-key]').forEach(el => {
                if (el.classList.contains('hrm-date')) autoFormatDate(el);

                if (el.tagName === 'INPUT' && el.dataset.oracleValue) {
                    // Date input — use the pre-converted DD-MM-YYYY value
                    if (el.dataset.oracleValue !== '') parameters[el.dataset.paramKey] = el.dataset
                        .oracleValue;
                } else if (el.value !== '') {
                    parameters[el.dataset.paramKey] = el.value;
                }
            });

            btnRun.disabled = true;
            btnRun.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Generating PDF…`;
            clearStatus();

            try {
                const res = await fetch(runReportUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({
                        report_id: reportId,
                        parameters
                    }),
                });

                if (!res.ok) {
                    const err = await res.json().catch(() => ({
                        error: 'Server error'
                    }));
                    throw new Error(err.error || `HTTP ${res.status}`);
                }

                // Oracle: SHOW_DOCUMENT — open PDF in new tab
                const blob = await res.blob();
                window.open(URL.createObjectURL(blob), '_blank');
                showSuccess('<i class="bi bi-check-circle-fill me-1"></i>Report opened successfully.');

            } catch (e) {
                showError('<i class="bi bi-exclamation-triangle-fill me-1"></i>HRM-9999: ERROR !!! ' + e
                    .message);
            } finally {
                btnRun.disabled = false;
                btnRun.innerHTML = '<i class="bi bi-play-fill me-1"></i>Run Report';
            }
        });

        // ── Reset ───────────────────────────────────────────────────────────
        btnReset.addEventListener('click', function() {
            $(reportSel).val(null).trigger('change');
            clearAll();
            infoBar.classList.add('d-none');
            paramSec.classList.add('d-none');
            actionBar.style.setProperty('display', 'none', 'important');
        });

        // ── Build HTML for a single parameter field ─────────────────────────
        function buildField(p, index) {
            const id = 'prm_' + (p.block_item || index);
            const key = p.block_value_item || p.block_item;
            const delay = (index * 60) + 'ms';
            let input = '';

            if (p.input_type === 'lov') {
                // ── LOV → Bootstrap <select> with Select2 ───────────────────
                // Oracle: LOV_ON_CLICK / lov_on_click(:system.cursor_item)
                const options = (p.lov_options || [])
                    .map(o => `<option value="${escHtml(o.value)}">${escHtml(o.label)}</option>`)
                    .join('');

                input = `
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-chevron-expand"></i></span>
                <select class="form-select lov-select2"
                        id="${id}"
                        data-param-key="${key}">
                    <option value="" selected>-- Select --</option>
                    ${options}
                </select>
            </div>`;

            } else if (p.input_type === 'date') {
                // ── Date → flatpickr DD-MM-YYYY ─────────────────────────────
                // data-oracle-value holds the value in DD-MM-YYYY (sent to controller → converted to DD-MON-YYYY)
                input = `
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                <input type="text"
                       class="form-control hrm-date"
                       id="${id}"
                       data-param-key="${key}"
                       data-oracle-value=""
                       placeholder="DD-MM-YYYY"
                       autocomplete="off"
                       >
            </div>
            <small class="date-display-txt">Format: DD-MM-YYYY</small>`;

            } else if (p.input_type === 'number') {
                input = `
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-hash"></i></span>
                <input type="number"
                       class="form-control"
                       id="${id}"
                       data-param-key="${key}"
                       placeholder="Enter ${escHtml(p.label)}">
            </div>`;
            } else {
                // Plain text
                input = `
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-input-cursor-text"></i></span>
                <input type="text"
                       class="form-control"
                       id="${id}"
                       data-param-key="${key}"
                       placeholder="Enter ${escHtml(p.label)}">
            </div>`;
            }

            return `
        <div class="col-md-6 param-row" style="animation-delay:${delay}">
            <label class="form-label" for="${id}">${escHtml(p.label || p.block_item)}</label>
            ${input}
        </div>`;
        }

        // ── Init controls after dynDiv is populated ─────────────────────────
        function initDynamicControls() {
            // Destroy old flatpickr instances
            flatpickrInstances.forEach(fp => fp.destroy());
            flatpickrInstances = [];

            // ── LOV dropdowns → Select2 ─────────────────────────────────────
            $('.lov-select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $('#dynamic-params'),
            });


            // ── Date inputs → flatpickr (DD-MM-YYYY) ────────────────────────
            // Flatpickr displays DD-MM-YYYY, stores YYYY-MM-DD internally.
            // onChange → we update data-oracle-value with DD-MM-YYYY for the controller.
            document.querySelectorAll('.hrm-date').forEach(el => {
                const fp = flatpickr(el, {
                    dateFormat: 'd-m-Y',
                    allowInput: true,
                    disableMobile: true,

                    // 🔥 STOP Flatpickr from mis-parsing
                    parseDate: function(dateStr) {
                        if (/^\d{6}$/.test(dateStr)) {
                            const dd = dateStr.substring(0, 2);
                            const mm = dateStr.substring(2, 4);
                            const yy = dateStr.substring(4, 6);
                            const yyyy = (parseInt(yy, 10) <= 30 ? '20' : '19') + yy;

                            return new Date(yyyy, mm - 1, dd);
                        }

                        if (/^\d{8}$/.test(dateStr)) {
                            const dd = dateStr.substring(0, 2);
                            const mm = dateStr.substring(2, 4);
                            const yyyy = dateStr.substring(4, 8);

                            return new Date(yyyy, mm - 1, dd);
                        }

                        // fallback for normal format
                        const parts = dateStr.split("-");
                        if (parts.length === 3) {
                            return new Date(parts[2], parts[1] - 1, parts[0]);
                        }

                        return null;
                    },

                    formatDate: function(date) {
                        const dd = String(date.getDate()).padStart(2, '0');
                        const mm = String(date.getMonth() + 1).padStart(2, '0');
                        const yyyy = date.getFullYear();
                        return `${dd}-${mm}-${yyyy}`;
                    },

                    onValueUpdate: function(selectedDates, dateStr) {
                        el.dataset.oracleValue = dateStr;
                    }
                });

                flatpickrInstances.push(fp);

                el.addEventListener('blur', function() {
                    autoFormatDate(el);
                });
            });

            bindEnterNavigation();
        }

        // ── Utility ─────────────────────────────────────────────────────────
        function getFocusableFields() {
            return Array.from(dynDiv.querySelectorAll('[data-param-key]'))
                .filter(el => !el.disabled && (el.offsetParent !== null || $(el).hasClass('select2-hidden-accessible')));
        }

        function focusControl(el) {
            if (!el) return;

            if ($(el).hasClass('select2-hidden-accessible')) {
                $(el).next('.select2-container').find('.select2-selection').trigger('focus');
                return;
            }

            el.focus();
            if (typeof el.select === 'function') el.select();
        }

        function focusFirstParameter() {
            const fields = getFocusableFields();

            setTimeout(() => {
                if (fields.length) {
                    focusControl(fields[0]);
                } else {
                    btnRun.focus();
                }
            }, 50);
        }

        function bindEnterNavigation() {
            getFocusableFields().forEach(el => {
                el.addEventListener('keydown', function(event) {
                    if (event.key !== 'Enter') return;

                    event.preventDefault();
                    if (el.classList.contains('hrm-date')) autoFormatDate(el);

                    const fields = getFocusableFields();
                    const nextField = fields[fields.indexOf(el) + 1];

                    if (nextField) {
                        focusControl(nextField);
                    } else {
                        btnRun.focus();
                    }
                });
            });

            $('.lov-select2').on('select2:select', function() {
                const fields = getFocusableFields();
                const nextField = fields[fields.indexOf(this) + 1];

                setTimeout(() => {
                    if (nextField) {
                        focusControl(nextField);
                    } else {
                        btnRun.focus();
                    }
                }, 0);
            });
        }

        function autoFormatDate(el) {
            var raw = el.value.replace(/\D/g, '');
            if (!raw) return;

            var day, mon, yr;

            if (raw.length === 6) {
                day = raw.substr(0, 2);
                mon = raw.substr(2, 2);
                yr = raw.substr(4, 2);
                yr = (parseInt(yr, 10) <= 30 ? '20' : '19') + yr;
            } else if (raw.length === 8) {
                day = raw.substr(0, 2);
                mon = raw.substr(2, 2);
                yr = raw.substr(4, 4);
            } else {
                return;
            }

            var d = parseInt(day, 10),
                m = parseInt(mon, 10),
                y = parseInt(yr, 10);

            if (d < 1 || d > 31 || m < 1 || m > 12 || y < 1900 || y > 2099) return;

            var formatted = day + '-' + mon + '-' + yr;
            el.value = formatted;
            el.dataset.oracleValue = formatted;

            if (el._flatpickr) el._flatpickr.setDate(formatted, false, 'd-m-Y');
        }

        btnRun.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                btnRun.click();
            }
        });

        function escHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;')
                .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        function clearAll() {
            dynDiv.innerHTML = '';
            flatpickrInstances.forEach(fp => fp.destroy());
            flatpickrInstances = [];
            // Destroy any orphan Select2 instances
            $('.lov-select2').each(function() {
                if ($(this).data('select2')) $(this).select2('destroy');
            });
        }

        function clearStatus() {
            statusMsg.innerHTML = '';
        }

        function showError(msg) {
            statusMsg.innerHTML = `<div class="alert-hrm-error">${msg}</div>`;
        }

        function showSuccess(msg) {
            statusMsg.innerHTML = `<div class="alert-hrm-success">${msg}</div>`;
        }
    </script>
@endpush
