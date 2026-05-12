@extends('layouts.app')

@push('styles')
    {{-- ── Bootstrap Icons ── --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- ── Select2 ── --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

    <style>
        /* ── ID Card module scoped variables ── */
        :root {
            --idc-primary: #1a3a5c;
            --idc-accent: #e8a020;
            --idc-radius: 8px;
            --h: 32px;
            --inp: #fff;
        }

        /* ── Card header strip ── */
        .idc-card-header {
            background: var(--idc-primary);
            color: #fff;
            border-radius: var(--idc-radius) var(--idc-radius) 0 0;
            padding: .6rem 1.1rem;
            font-weight: 600;
            font-size: .88rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        /* ── Section label ── */
        .idc-section-label {
            background: #eef2f7;
            border-left: 4px solid var(--idc-primary);
            padding: .28rem .75rem;
            border-radius: 0 4px 4px 0;
            font-weight: 600;
            font-size: .78rem;
            color: #1a3a5c;
            margin-bottom: .7rem;
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        /* ── Multi-emp tag box ── */
        .idc-tag-box {
            min-height: 36px;
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            align-items: center;
            cursor: text;
            height: auto !important;
            background: #fff;
            border: 1px solid #ced4da;
            border-radius: .375rem;
            padding: 3px 8px;
            transition: border-color .15s, box-shadow .15s;
        }

        .idc-tag-box:focus-within {
            border-color: #86b7fe;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
        }

        .idc-tag {
            background: #e6f1fb;
            color: #185fa5;
            border-radius: 4px;
            padding: 1px 7px;
            font-size: .75rem;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        .idc-tag .idc-tag-x {
            cursor: pointer;
            font-size: .85rem;
            line-height: 1;
            color: #185fa5;
        }

        .idc-tag .idc-tag-x:hover {
            color: #a32d2d;
        }

        .idc-tag-input {
            border: none;
            outline: none;
            background: transparent;
            font-size: .82rem;
            min-width: 110px;
            color: inherit;
            padding: 2px 0;
        }

        /* ── Select2 height fix ── */
        .select2-container--bootstrap-5 .select2-selection {
            min-height: var(--h) !important;
            font-size: .82rem !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            line-height: var(--h) !important;
            padding: 0 8px !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            height: var(--h) !important;
        }

        /* ── Inline autocomplete dropdown ── */
        .idc-inline-drop {
            position: absolute;
            z-index: 1055;
            background: #fff;
            border: 1px solid #c8d0dc;
            border-radius: 6px;
            max-height: 200px;
            overflow-y: auto;
            min-width: 340px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .12);
        }

        .idc-drop-item {
            padding: 5px 12px;
            cursor: pointer;
            font-size: .78rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .idc-drop-item:hover {
            background: #f0f5ff;
        }

        .idc-drop-empno {
            color: #185fa5;
            font-weight: 600;
            min-width: 72px;
        }

        .idc-drop-sec {
            color: #aaa;
            font-size: .72rem;
            margin-left: auto;
        }

        /* ── Report buttons ── */
        .idc-btn-row {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .idc-btn-report {
            border-radius: .375rem;
            padding: .32rem .85rem;
            font-size: .78rem;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid transparent;
            transition: opacity .15s, transform .1s;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
        }

        .idc-btn-report:hover {
            opacity: .88;
            transform: translateY(-1px);
        }

        .idc-btn-report:active {
            transform: translateY(0);
        }

        .idc-btn-gold {
            background: #e8a020;
            color: #fff;
            border-color: #c8891a;
        }

        .idc-btn-navy {
            background: #1a3a5c;
            color: #fff;
            border-color: #122844;
        }

        .idc-btn-teal {
            background: #0f6e56;
            color: #fff;
            border-color: #0b5240;
        }

        .idc-btn-slate {
            background: #5f6e7c;
            color: #fff;
            border-color: #4a5762;
        }

        .idc-btn-indigo {
            background: #3c3489;
            color: #fff;
            border-color: #2c266a;
        }

        .idc-btn-red {
            background: #a32d2d;
            color: #fff;
            border-color: #7e2121;
        }

        .idc-btn-outline {
            background: #fff;
            color: #1a3a5c;
            border-color: #b0bec5;
        }

        .idc-btn-outline:hover {
            background: #f0f4f8;
        }

        /* ── LOV modal ── */
        #idcLovModal .modal-header {
            background: var(--idc-primary);
            color: #fff;
        }

        #idcLovModal .modal-header .btn-close {
            filter: invert(1);
        }

        #idcLovModal thead th {
            background: var(--idc-primary);
            color: #fff;
        }

        #idcLovModal .sticky-top {
            top: 0;
            z-index: 2;
        }

        /* ── Print: hide AdminLTE chrome ── */
        @media print {

            .main-sidebar,
            .main-header,
            .main-footer,
            .content-header,
            .idc-no-print {
                display: none !important;
            }

            .content-wrapper {
                margin-left: 0 !important;
                padding: 0 !important;
            }

            body {
                background: #fff !important;
            }
        }
    </style>
@endpush

@section('content')
    @yield('idc_content')
@endsection

@push('scripts')
    {{-- ── jQuery (AdminLTE already includes it, this is a safety fallback) ── --}}
    <script>
        if (typeof jQuery === 'undefined') {
            document.write('<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"><\/script>');
        }
    </script>

    {{-- ── Bootstrap JS (AdminLTE already includes it, safety fallback) ── --}}
    <script>
        if (typeof bootstrap === 'undefined') {
            document.write(
                '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"><\/script>');
        }
    </script>

    {{-- ── Select2 ── --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- ── SweetAlert2 ── --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
@endpush
