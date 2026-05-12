@extends('hrm.report.layouts.id_card')
@section('title', 'ID Card Creation')
@section('page_title', 'ID Card Creation')
@section('breadcrumb', 'Report Form')

@section('idc_content')

    <div class="card shadow-sm border-0 rounded-3">

        {{-- ── Card header ── --}}
        <div class="idc-card-header">
            <i class="bi bi-person-badge"></i>
            ID Card Creation &mdash; Report
            <a hidden href="{{ route('id-card.create') }}" class="btn btn-sm ms-auto idc-no-print"
                style="background:var(--idc-accent);color:#1a3a5c;font-weight:600;font-size:.75rem">
                <i class="bi bi-plus-circle"></i> New Employee
            </a>
        </div>

        <div class="card-body pt-3">

            {{-- ══════════════════════════════════════
                 PARAMETERS
            ══════════════════════════════════════ --}}
            <div class="idc-section-label">
                <i class="bi bi-sliders2"></i> Employee &amp; Report Parameters
            </div>

            <div class="row g-3 align-items-end mb-4">

                {{-- ── Multi-employee tag input ── --}}
                <div class="col-xl-5 col-lg-6">
                    <label class="form-label form-label-sm fw-semibold mb-1">
                        Employee No
                        <span class="text-muted fw-normal" style="font-size:.73rem">
                            — type, comma-separate, or use LOV
                        </span>
                    </label>
                    <div class="d-flex gap-2 align-items-start" style="position:relative">
                        <div id="idcTagBox" class="idc-tag-box flex-grow-1"
                            onclick="document.getElementById('idcTagInput').focus()">
                            <input id="idcTagInput" class="idc-tag-input" placeholder="e.g. 1001, 1002"
                                autocomplete="off" />
                        </div>
                        <button type="button" class="btn btn-sm flex-shrink-0"
                            style="background:#1a3a5c;color:#fff;margin-top:1px" onclick="idcOpenLov()">
                            <i class="bi bi-list-ul"></i> LOV
                        </button>
                        {{-- Inline autocomplete dropdown --}}
                        <div id="idcInlineDrop" class="idc-inline-drop" style="display:none;top:38px;left:0;"></div>
                    </div>
                    <input type="hidden" id="idcHiddenEmpNos" value="">
                </div>

                {{-- ── Section ── --}}
                <div class="col-xl-3 col-lg-4 col-md-5">
                    <label class="form-label form-label-sm fw-semibold mb-1">Section</label>
                    <select id="idcSection" class="form-select form-select-sm select2"
                        data-placeholder="-- All sections --">
                        <option value="">-- All sections --</option>
                        @foreach ($sections as $sec)
                            <option value="{{ $sec->section_no }}">
                                {{ $sec->section_no }} – {{ $sec->section_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ── From date ── --}}
                <div class="col-xl-2 col-lg-3 col-md-3 col-sm-6">
                    <label class="form-label form-label-sm fw-semibold mb-1">From Date</label>
                    <input type="date" id="idcFromDate" class="form-control form-control-sm">
                </div>

                {{-- ── End date ── --}}
                <div class="col-xl-2 col-lg-3 col-md-3 col-sm-6">
                    <label class="form-label form-label-sm fw-semibold mb-1">End Date</label>
                    <input type="date" id="idcEndDate" class="form-control form-control-sm">
                </div>

            </div>

            {{-- ══════════════════════════════════════
                 REPORT BUTTONS
            ══════════════════════════════════════ --}}
            <div class="idc-section-label">
                <i class="bi bi-printer"></i> Print / Report
            </div>

            <div class="idc-btn-row idc-no-print">
                <button class="idc-btn-report idc-btn-gold" data-type="bangla_knit"
                    data-report="ID_CARD_bangla_level_knit.rdf">
                    <i class="bi bi-printer-fill"></i> Bangla Knit Card
                </button>
                <button class="idc-btn-report idc-btn-navy" data-type="bangla_front" data-report="ID_CARD_bangla_front.rdf">
                    <i class="bi bi-front"></i> Bangla Front
                </button>
                <button class="idc-btn-report idc-btn-teal" data-type="bangla_single" data-report="ID_CARD_bangla.rdf">
                    <i class="bi bi-person-vcard"></i> Bangla Single
                </button>
                <button class="idc-btn-report idc-btn-slate" data-type="bangla_back" data-report="ID_CARD_bangla_back.rdf">
                    <i class="bi bi-back"></i> Back Part
                </button>
                <button class="idc-btn-report idc-btn-outline" data-type="card_label"
                    data-report="ID_CARD_Process_lebel.rdf">
                    <i class="bi bi-tag"></i> Card Label
                </button>
                <button class="idc-btn-report idc-btn-outline" data-type="emp_label" data-report="emp_lebel.rdf">
                    <i class="bi bi-tags"></i> Emp Label
                </button>
                <button class="idc-btn-report idc-btn-outline" data-type="emp_label" data-report="emp_lebel.rdf">
                    <i class="bi bi-tags-fill"></i> Emp Label (Range)
                </button>
                <button class="idc-btn-report idc-btn-outline" data-type="process_label"
                    data-report="ID_CARD_Process_lebel.rdf">
                    <i class="bi bi-calendar-range"></i> Process Label (Range)
                </button>
                <button class="idc-btn-report idc-btn-indigo" data-type="temp_card" data-report="ID_CARD_Process_Temp.rdf">
                    <i class="bi bi-card-heading"></i> Temp Card
                </button>
                <button class="idc-btn-report idc-btn-red" data-type="process_rony"
                    data-report="ID_CARD_Process_Rony_I.rdf">
                    <i class="bi bi-person-badge-fill"></i> Process Card
                </button>
                <button class="idc-btn-report idc-btn-outline" data-type="bangla_level"
                    data-report="ID_CARD_bangla_level.rdf">
                    <i class="bi bi-layers"></i> Bangla Level
                </button>
            </div>

        </div>{{-- /card-body --}}
    </div>{{-- /card --}}


    {{-- ══════════════════════════════════════════════════
         LOV MODAL  — server-side search + pagination
    ══════════════════════════════════════════════════ --}}
    <div class="modal fade" id="idcLovModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header py-2" style="background:#1a3a5c;color:#fff">
                    <h6 class="modal-title mb-0">
                        <i class="bi bi-list-check me-1"></i> Select Employees (LOV)
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                {{-- ── Search bar ── --}}
                <div class="p-2 border-bottom bg-light d-flex gap-2 align-items-center flex-wrap">
                    <div class="input-group input-group-sm" style="max-width:280px">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input id="idcLovSearch" class="form-control form-control-sm" placeholder="Emp no or name…"
                            autocomplete="off">
                    </div>
                    <select id="idcLovSecFilter" class="form-select form-select-sm" style="max-width:200px">
                        <option value="">All sections</option>
                        @foreach ($sections as $sec)
                            <option value="{{ $sec->section_no }}">
                                {{ $sec->section_no }} – {{ $sec->section_name }}
                            </option>
                        @endforeach
                    </select>
                    <span id="idcLovTotalLabel" class="text-muted small ms-auto"></span>
                </div>

                {{-- ── Table ── --}}
                <div class="modal-body p-0" style="min-height:360px">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th style="width:36px">
                                    <input type="checkbox" id="idcLovChkAll" title="Toggle visible rows"
                                        onchange="idcLovToggleAll(this.checked)">
                                </th>
                                <th>Emp No</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Section</th>
                                <th>Join Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="idcLovBody">
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Opening…
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- ── Footer ── --}}
                <div class="modal-footer py-2 justify-content-between flex-wrap gap-2">
                    {{-- Left: selected count + pagination --}}
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <span id="idcLovCount" class="badge text-bg-primary">0 selected</span>
                        <div id="idcLovPagination"></div>
                    </div>
                    {{-- Right: actions --}}
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-secondary" onclick="idcLovClearAll()">
                            <i class="bi bi-x-circle me-1"></i>Clear All
                        </button>
                        <button class="btn btn-sm" style="background:#1a3a5c;color:#fff" onclick="idcLovConfirm()">
                            <i class="bi bi-check2-all me-1"></i>Add Selected
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script>
        // ══════════════════════════════════════════════════════════
        //  STATE
        // ══════════════════════════════════════════════════════════
        let idcTags = []; // committed tag values
        let idcChecked = new Set(); // checked emp_nos inside LOV
        let idcLovModal;

        // ── LOV pagination state ──
        let idcLovPage = 1;
        let idcLovLastPage = 1;
        let idcLovTotal = 0;
        let idcLovLoading = false;
        let idcLovTimer = null;

        // ══════════════════════════════════════════════════════════
        //  BOOT
        // ══════════════════════════════════════════════════════════
        document.addEventListener('DOMContentLoaded', function() {

            idcLovModal = new bootstrap.Modal(document.getElementById('idcLovModal'));

            // Select2 on main section dropdown
            $('#idcSection').select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $('body'),
            });

            // LOV search — debounced server call
            document.getElementById('idcLovSearch')
                .addEventListener('input', () => {
                    clearTimeout(idcLovTimer);
                    idcLovTimer = setTimeout(() => idcLovFetch(1), 320);
                });

            // LOV section filter — immediate server call
            document.getElementById('idcLovSecFilter')
                .addEventListener('change', () => idcLovFetch(1));
        });


        // ══════════════════════════════════════════════════════════
        //  TAG INPUT
        // ══════════════════════════════════════════════════════════
        function idcRenderTags() {
            const box = document.getElementById('idcTagBox');
            box.querySelectorAll('.idc-tag').forEach(t => t.remove());
            const inp = document.getElementById('idcTagInput');
            [...idcTags].forEach(no => {
                const span = document.createElement('span');
                span.className = 'idc-tag';
                span.innerHTML = `${no}<span class="idc-tag-x" onclick="idcRemoveTag('${no}')">×</span>`;
                box.insertBefore(span, inp);
            });
            document.getElementById('idcHiddenEmpNos').value = idcTags.join(',');
        }

        function idcAddTag(no) {
            no = no.trim().toUpperCase();
            if (!no || idcTags.includes(no)) return;
            idcTags.push(no);
            idcRenderTags();
        }

        function idcRemoveTag(no) {
            idcTags = idcTags.filter(t => t !== no);
            idcChecked.delete(no);
            idcRenderTags();
            idcUpdateLovCount();
        }

        // keydown: Enter / comma / space → commit tag
        document.getElementById('idcTagInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ',' || e.key === ' ') {
                e.preventDefault();
                const val = this.value.replace(/,/g, '').trim();
                if (val) {
                    idcAddTag(val);
                    this.value = '';
                }
                idcHideInline();
            } else if (e.key === 'Backspace' && this.value === '' && idcTags.length) {
                idcRemoveTag(idcTags[idcTags.length - 1]);
            }
        });

        // input: trigger inline autocomplete
        document.getElementById('idcTagInput').addEventListener('input', function() {
            idcFetchInline(this.value.replace(/,/g, '').trim());
        });


        // ══════════════════════════════════════════════════════════
        //  INLINE AUTOCOMPLETE
        // ══════════════════════════════════════════════════════════
        let idcInlineTimer;

        function idcFetchInline(q) {
            clearTimeout(idcInlineTimer);
            const drop = document.getElementById('idcInlineDrop');
            if (!q) {
                idcHideInline();
                return;
            }

            idcInlineTimer = setTimeout(() => {
                $.get('{{ route('id-card.api.employeesKeyUp') }}', {
                        q
                    })
                    .done(data => {
                        const hits = data.filter(e => !idcTags.includes(e.emp_no)).slice(0, 8);
                        if (!hits.length) {
                            idcHideInline();
                            return;
                        }
                        drop.innerHTML = hits.map(e => `
                    <div class="idc-drop-item" onmousedown="idcPickInline('${e.emp_no}')">
                        <span class="idc-drop-empno">${e.emp_no}</span>
                        <span>${e.emp_name}</span>
                        <span class="idc-drop-sec">${e.section ?? ''}</span>
                    </div>`).join('');
                        drop.style.display = 'block';
                    });
            }, 220);
        }

        function idcPickInline(no) {
            idcAddTag(no);
            document.getElementById('idcTagInput').value = '';
            idcHideInline();
        }

        function idcHideInline() {
            document.getElementById('idcInlineDrop').style.display = 'none';
        }

        document.addEventListener('click', e => {
            if (!e.target.closest('#idcTagBox') && !e.target.closest('#idcInlineDrop')) {
                idcHideInline();
            }
        });


        // ══════════════════════════════════════════════════════════
        //  LOV MODAL  —  server-side search + pagination
        // ══════════════════════════════════════════════════════════
        function idcOpenLov() {
            // sync checked set with current tags
            idcChecked = new Set(idcTags);

            // reset modal search fields
            document.getElementById('idcLovSearch').value = '';
            document.getElementById('idcLovSecFilter').value = '';
            idcLovPage = 1;

            idcLovFetch(1);
            idcLovModal.show();
        }

        // ── Core fetch ────────────────────────────────────────────
        function idcLovFetch(page) {
            if (idcLovLoading) return;
            idcLovLoading = true;

            const q = document.getElementById('idcLovSearch').value.trim();
            const sec = document.getElementById('idcLovSecFilter').value;

            // Loading placeholder
            document.getElementById('idcLovBody').innerHTML = `
        <tr>
            <td colspan="7" class="text-center py-4 text-muted">
                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                Loading employees…
            </td>
        </tr>`;

            $.get('{{ route('id-card.api.employees') }}', {
                    q,
                    section_no: sec,
                    page,
                    per_page: 50,
                })
                .done(res => {
                    idcLovPage = res.current_page;
                    idcLovLastPage = res.last_page;
                    idcLovTotal = res.total;

                    document.getElementById('idcLovTotalLabel').textContent =
                        res.total + ' employee(s) found';

                    idcRenderLovRows(res.data);
                    idcRenderPagination();
                })
                .fail(() => {
                    document.getElementById('idcLovBody').innerHTML = `
            <tr>
                <td colspan="7" class="text-center text-danger py-4">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Failed to load. Please try again.
                </td>
            </tr>`;
                    document.getElementById('idcLovPagination').innerHTML = '';
                })
                .always(() => {
                    idcLovLoading = false;
                });
        }

        // ── Render table rows ─────────────────────────────────────
        function idcRenderLovRows(data) {
            const statusBadge = {
                'Active': 'success',
                'Inactive': 'secondary',
            };

            if (!data.length) {
                document.getElementById('idcLovBody').innerHTML = `
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    <i class="bi bi-inbox me-1"></i> No employees found.
                </td>
            </tr>`;
                idcUpdateLovCount();
                // uncheck select-all
                document.getElementById('idcLovChkAll').checked = false;
                document.getElementById('idcLovChkAll').indeterminate = false;
                return;
            }

            document.getElementById('idcLovBody').innerHTML = data.map(e => {
                const checked = idcChecked.has(e.emp_no);
                const safeNo = e.emp_no.replace(/'/g, "\\'");
                return `
        <tr class="${checked ? 'table-primary' : ''}"
            style="cursor:pointer"
            onclick="idcLovToggleRow('${safeNo}', this)">
            <td onclick="event.stopPropagation()">
                <input type="checkbox" class="idc-lov-chk"
                       ${checked ? 'checked' : ''}
                       onchange="idcLovToggleRow('${safeNo}', this.closest('tr'))">
            </td>
            <td>
                <code class="text-primary" style="font-size:.78rem">${e.emp_no}</code>
            </td>
            <td>
                <div style="font-size:.82rem;font-weight:500">${e.emp_name || '—'}</div>
                ${e.emp_name_bn
                    ? `<small class="text-muted bangla-text">${e.emp_name_bn}</small>`
                    : ''}
            </td>
            <td style="font-size:.78rem">${e.designation || '—'}</td>
            <td style="font-size:.78rem">
                ${e.section_no ? `<span class="badge bg-light text-dark border me-1">${e.section_no}</span>` : ''}
                ${e.section || '—'}
            </td>
            <td style="font-size:.78rem;white-space:nowrap">${e.join_date || '—'}</td>
            <td>
                <span class="badge bg-${statusBadge[e.status] ?? 'secondary'}" style="font-size:.68rem">
                    ${e.status || '—'}
                </span>
            </td>
        </tr>`;
            }).join('');

            idcUpdateSelectAllState();
            idcUpdateLovCount();
        }

        // ── Pagination renderer ───────────────────────────────────
        function idcRenderPagination() {
            const el = document.getElementById('idcLovPagination');

            if (idcLovLastPage <= 1) {
                el.innerHTML = '';
                return;
            }

            const delta = 2;
            const start = Math.max(1, idcLovPage - delta);
            const end = Math.min(idcLovLastPage, idcLovPage + delta);
            let pages = [];
            for (let i = start; i <= end; i++) pages.push(i);

            const prevDisabled = idcLovPage === 1 ? 'disabled' : '';
            const nextDisabled = idcLovPage === idcLovLastPage ? 'disabled' : '';

            let html = `<nav aria-label="LOV pages"><ul class="pagination pagination-sm mb-0">`;

            // Prev
            html += `<li class="page-item ${prevDisabled}">
        <a class="page-link" href="#" onclick="idcLovGo(${idcLovPage - 1});return false">
            <i class="bi bi-chevron-left"></i>
        </a>
    </li>`;

            // First page + ellipsis
            if (start > 1) {
                html += `<li class="page-item">
            <a class="page-link" href="#" onclick="idcLovGo(1);return false">1</a>
        </li>`;
                if (start > 2) {
                    html += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
                }
            }

            // Page buttons
            pages.forEach(p => {
                html += `<li class="page-item ${p === idcLovPage ? 'active' : ''}">
            <a class="page-link" href="#" onclick="idcLovGo(${p});return false">${p}</a>
        </li>`;
            });

            // Last page + ellipsis
            if (end < idcLovLastPage) {
                if (end < idcLovLastPage - 1) {
                    html += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
                }
                html += `<li class="page-item">
            <a class="page-link" href="#" onclick="idcLovGo(${idcLovLastPage});return false">
                ${idcLovLastPage}
            </a>
        </li>`;
            }

            // Next
            html += `<li class="page-item ${nextDisabled}">
        <a class="page-link" href="#" onclick="idcLovGo(${idcLovPage + 1});return false">
            <i class="bi bi-chevron-right"></i>
        </a>
    </li>`;

            html += `</ul></nav>
        <small class="text-muted ms-2">
            Page ${idcLovPage} of ${idcLovLastPage}
        </small>`;

            el.innerHTML = html;
        }

        function idcLovGo(page) {
            if (page < 1 || page > idcLovLastPage || page === idcLovPage) return;
            idcLovFetch(page);
        }

        // ── Toggle single row ─────────────────────────────────────
        function idcLovToggleRow(no, tr) {
            const chk = tr.querySelector('.idc-lov-chk');
            if (idcChecked.has(no)) {
                idcChecked.delete(no);
                tr.classList.remove('table-primary');
                if (chk) chk.checked = false;
            } else {
                idcChecked.add(no);
                tr.classList.add('table-primary');
                if (chk) chk.checked = true;
            }
            idcUpdateSelectAllState();
            idcUpdateLovCount();
        }

        // ── Toggle all visible rows ───────────────────────────────
        function idcLovToggleAll(checked) {
            document.querySelectorAll('#idcLovBody tr').forEach(tr => {
                const codeEl = tr.querySelector('code');
                if (!codeEl) return;
                const no = codeEl.textContent.trim();
                const chk = tr.querySelector('.idc-lov-chk');
                if (checked) {
                    idcChecked.add(no);
                    tr.classList.add('table-primary');
                } else {
                    idcChecked.delete(no);
                    tr.classList.remove('table-primary');
                }
                if (chk) chk.checked = checked;
            });
            idcUpdateLovCount();
        }

        // ── Select-all checkbox state (checked / indeterminate) ───
        function idcUpdateSelectAllState() {
            const all = document.querySelectorAll('#idcLovBody .idc-lov-chk');
            const chkd = document.querySelectorAll('#idcLovBody .idc-lov-chk:checked');
            const master = document.getElementById('idcLovChkAll');
            if (!all.length) {
                master.checked = master.indeterminate = false;
            } else if (chkd.length === all.length) {
                master.checked = true;
                master.indeterminate = false;
            } else if (chkd.length === 0) {
                master.checked = master.indeterminate = false;
            } else {
                master.checked = false;
                master.indeterminate = true;
            }
        }

        function idcLovClearAll() {
            idcChecked.clear();
            // uncheck all visible rows
            document.querySelectorAll('#idcLovBody .idc-lov-chk').forEach(c => c.checked = false);
            document.querySelectorAll('#idcLovBody tr').forEach(tr => tr.classList.remove('table-primary'));
            document.getElementById('idcLovChkAll').checked = false;
            document.getElementById('idcLovChkAll').indeterminate = false;
            idcUpdateLovCount();
        }

        function idcLovConfirm() {
            idcChecked.forEach(no => idcAddTag(no));
            idcLovModal.hide();
        }

        function idcUpdateLovCount() {
            const n = idcChecked.size;
            const el = document.getElementById('idcLovCount');
            el.textContent = n + ' selected';
            el.className = 'badge ' + (n > 0 ? 'text-bg-primary' : 'text-bg-secondary');
        }


        // ══════════════════════════════════════════════════════════
        //  RUN REPORT BUTTONS
        // ══════════════════════════════════════════════════════════
        $(document).on('click', '.idc-btn-report', function() {

            // Flush any partially typed emp no
            const inp = document.getElementById('idcTagInput');
            const v = inp.value.replace(/,/g, '').trim();
            if (v) {
                idcAddTag(v);
                inp.value = '';
            }

            if (!idcTags.length) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Employee Selected',
                    text: 'Enter or select at least one Employee No.',
                    confirmButtonColor: '#1a3a5c',
                });
                document.getElementById('idcTagInput').focus();
                return;
            }

            const type = $(this).data('type');
            const report = $(this).data('report');
            const label = $(this).text().trim();

            Swal.fire({
                title: 'Run Report',
                html: `Run <b>${label}</b><br>
                <code style="font-size:11px">${report}</code><br><br>
                <b>${idcTags.length}</b> employee(s):<br>
                <span style="font-size:12px;color:#555">${idcTags.join(', ')}</span>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-printer"></i> Run &amp; Print',
                confirmButtonColor: '#1a3a5c',
            }).then(result => {
                if (!result.isConfirmed) return;

                // Flush once more
                const finalInp = document.getElementById('idcTagInput');
                const finalVal = finalInp.value.replace(/,/g, '').trim();
                if (finalVal) {
                    idcAddTag(finalVal);
                    finalInp.value = '';
                }

                if (!idcTags.length) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Employee',
                        text: 'No employee numbers found.',
                        confirmButtonColor: '#1a3a5c'
                    });
                    return;
                }

                const params = new URLSearchParams();
                params.set('emp_nos', idcTags.join(','));
                params.set('card_type', type);
                params.set('section_no', $('#idcSection').val() || '');
                params.set('from_date', $('#idcFromDate').val() || '');
                params.set('end_date', $('#idcEndDate').val() || '');

                window.open('{{ route('id-card.print') }}' + '?' + params.toString(), '_blank');
            });
        });
    </script>
@endpush
