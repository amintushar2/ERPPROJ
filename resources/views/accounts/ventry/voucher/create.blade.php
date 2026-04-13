@extends('accounts.ventry.layouts.app')

@section('title', 'New Voucher — AFM Finance')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('vouchers.index') }}" class="text-decoration-none text-secondary">Vouchers</a>
    </li>
    <li class="breadcrumb-item active">New Voucher</li>
@endsection

@section('content')

    <form id="voucherForm" action="{{ route('vouchers.store') }}" method="POST" novalidate>
        @csrf

        {{-- ── MASTER HEADER CARD ──────────────────────────────── --}}
        <div class="page-card">
            <div class="page-card-header">
                <h6><i class="bi bi-journal-plus me-2"></i>Voucher Header</h6>
                @if (isset($unapprovedCount) && $unapprovedCount > 0)
                    <span class="badge bg-warning text-dark">
                        <i class="bi bi-bell-fill me-1"></i>{{ $unapprovedCount }} Unapproved Voucher(s)
                    </span>
                @endif
            </div>
            <div class="page-card-body">

                <div class="notice-bar">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Logged in as <strong>{{ Auth::user()->user_id ?? Auth::user()->name }}</strong>
                    &nbsp;&middot;&nbsp;
                    Company: <strong id="companyLabel">{{ $companies[0]->company_name ?? '' }}</strong>
                </div>

                {{-- Simplified Header: Type | Date | Voucher No | Pay/Receive To --}}
                <div class="row g-3">

                    <div class="col-md-2">
                        <label class="form-label">Voucher Type <span class="text-danger">*</span></label>
                        <select name="VOUCHER_TYPE" id="VOUCHER_TYPE" class="form-select" required
                            onchange="onVoucherTypeChange(this.value)">
                            <option value="">-- Select --</option>
                            @foreach ($voucherTypes as $t)
                                <option value="{{ $t->voucher_type }}"
                                    {{ old('VOUCHER_TYPE') == $t->voucher_type ? 'selected' : '' }}>
                                    {{ $t->voucher_type }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Voucher type is required.</div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Voucher Date <span class="text-danger">*</span></label>
                        <div class="input-group input-group-sm">
                            <input type="date" name="VOUCHER_DATE" id="VOUCHER_DATE" class="form-control" required
                                value="{{ old('VOUCHER_DATE', date('Y-m-d')) }}" onchange="validateVoucherDate(this.value)">
                            <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                        </div>
                        <div class="invalid-feedback">Voucher date is required.</div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Voucher No</label>
                        <input type="text" name="VOUCHER_NO" id="VOUCHER_NO" class="form-control"
                            value="{{ old('VOUCHER_NO') }}" placeholder="Manual / Auto">
                        <div class="form-text" style="font-size:10px;color:#6c757d">
                            Leave blank for auto-generate
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Company <span class="text-danger">*</span></label>
                        <select name="COMPANY_ID" id="COMPANY_ID" class="form-select" required
                            onchange="document.getElementById('companyLabel').textContent=this.options[this.selectedIndex].text">
                            @foreach ($companies as $c)
                                <option value="{{ $c->company_id }}"
                                    {{ old('company_id', $defaultCompany ?? '') == $c->company_id ? 'selected' : '' }}>
                                    {{ $c->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pay To / Receive From — label changes with voucher type --}}
                    <div class="col-md-3">
                        <label class="form-label" id="payReceiveLabel">Pay To / Received From</label>
                        <input type="text" name="RECEIVE_PAY_TO" id="RECEIVE_PAY_TO" class="form-control"
                            value="{{ old('RECEIVE_PAY_TO') }}" placeholder="Enter payee / payer name…">
                    </div>

                </div>

            </div>
        </div>

        {{-- ── ADD LINE CARD ───────────────────────────────────── --}}
        <div class="page-card">
            <div class="page-card-header">
                <h6><i class="bi bi-plus-square me-2"></i>Add Voucher Line</h6>
                <small class="text-white-50">Select account → enter debit or credit → click Add Line</small>
            </div>
            <div class="page-card-body">
                <div class="add-panel">

                    {{-- ══════════════════════════════════════════════════════
                         ROW 1 — Account code + conditional sub-fields beside it
                         Sub-fields are ALL hidden on load (display:none).
                         They appear beside the account code when flag = 1.
                         Uses flex-wrap so they flow naturally next to the code.
                    ══════════════════════════════════════════════════════ --}}
                    <div class="d-flex flex-wrap gap-2 align-items-start mb-3" id="accountRow">

                        {{-- Account code (always visible) --}}
                        <div style="min-width:220px; flex:0 0 220px">
                            <label class="form-label">Account <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="CTL_ACCOUNT_ID" class="form-control" placeholder="Account code…"
                                    onchange="onAccountCodeChange()">
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#accountLovModal" onclick="openAccountLov()">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <div id="CTL_ACCOUNT_NAME" class="text-muted mt-1"
                                style="font-size:11px;min-height:14px;font-style:italic"></div>
                        </div>

                        {{-- IS_CREDITOR = 1 — shown beside account --}}
                        <div class="sub-field" id="sfCreditor" style="display:none; min-width:210px; flex:0 0 210px">
                            <label class="form-label">
                                <span class="badge bg-primary" style="font-size:10px">Creditor</span>
                            </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="CTL_CREDITOR_CODE" class="form-control"
                                    placeholder="Creditor code…" onchange="loadPartyName('creditor')">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="openPartyLov('creditor')">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <input type="text" id="CTL_CREDITOR_NAME" class="form-control mt-1"
                                style="font-size:11px;height:26px" placeholder="Creditor name" readonly>
                        </div>

                        {{-- IS_DETOR = 1 — shown beside account --}}
                        <div class="sub-field" id="sfDetor" style="display:none; min-width:210px; flex:0 0 210px">
                            <label class="form-label">
                                <span class="badge bg-success" style="font-size:10px">Debtor</span>
                            </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="CTL_DETOR_CODE" class="form-control"
                                    placeholder="Debtor code…" onchange="loadPartyName('detor')">
                                <button class="btn btn-outline-secondary" type="button" onclick="openPartyLov('detor')">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <input type="text" id="CTL_DETOR_NAME" class="form-control mt-1"
                                style="font-size:11px;height:26px" placeholder="Debtor name" readonly>
                        </div>

                        {{-- IS_EMPLOYEE = 1 — shown beside account --}}
                        <div class="sub-field" id="sfEmployee" style="display:none; min-width:190px; flex:0 0 190px">
                            <label class="form-label">
                                <span class="badge" style="font-size:10px;background:#6f42c1;color:#fff">Employee</span>
                            </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="CTL_EMP_CODE" class="form-control" placeholder="Emp code…"
                                    onchange="loadEmpName()">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="openPartyLov('employee')">
                                    <i class="bi bi-person-search"></i>
                                </button>
                            </div>
                            <input type="text" id="CTL_EMP_NAME" class="form-control mt-1"
                                style="font-size:11px;height:26px" placeholder="Employee name" readonly>
                        </div>

                        {{-- IS_ASSET = 1 — shown beside account --}}
                        <div class="sub-field" id="sfAsset" style="display:none; min-width:180px; flex:0 0 180px">
                            <label class="form-label">
                                <span class="badge bg-warning text-dark" style="font-size:10px">Asset</span>
                            </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="CTL_ASSET_CODE" class="form-control"
                                    placeholder="Asset code…">
                                <button class="btn btn-outline-secondary" type="button" onclick="openPartyLov('asset')">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>

                        {{-- IS_COST_CENTER = 1 — shown beside account --}}
                        <div class="sub-field" id="sfCostCenter" style="display:none; min-width:160px; flex:0 0 160px">
                            <label class="form-label">
                                <span class="badge bg-secondary" style="font-size:10px">Cost Center</span>
                            </label>
                            <input type="text" id="CTL_COST_CENTER" class="form-control form-control-sm"
                                placeholder="CC code…">
                        </div>

                        {{-- IS_LC = 1 — shown beside account --}}
                        <div class="sub-field" id="sfLC" style="display:none; min-width:160px; flex:0 0 160px">
                            <label class="form-label">
                                <span class="badge bg-danger" style="font-size:10px">LC No</span>
                            </label>
                            <input type="text" id="CTL_LC_NO" class="form-control form-control-sm"
                                placeholder="LC number…">
                        </div>

                        {{-- IS_MASTER_LC = 1 — shown beside account --}}
                        <div class="sub-field" id="sfMasterLC" style="display:none; min-width:160px; flex:0 0 160px">
                            <label class="form-label">
                                <span class="badge bg-danger" style="font-size:10px">Master LC</span>
                            </label>
                            <input type="text" id="CTL_MASTER_LC_NO" class="form-control form-control-sm"
                                placeholder="Master LC no…">
                        </div>

                        {{-- Cheque — shown for BANKP / BANKR only --}}
                        <div class="sub-field" id="sfCheque" style="display:none; min-width:160px; flex:0 0 160px">
                            <label class="form-label">
                                <span class="badge bg-info text-dark" style="font-size:10px">Cheque No</span>
                            </label>
                            <input type="text" id="CTL_CHE_RECP_NO" class="form-control form-control-sm"
                                placeholder="Cheque no…">
                        </div>

                    </div>

                    {{-- ══════════════════════════════════════════════════════
                         ROW 2 — Debit | Credit | USD Dr | USD Cr | Reference
                    ══════════════════════════════════════════════════════ --}}
                    <div class="row g-2 mb-3">
                        <div class="col-md-2">
                            <label class="form-label">Debit (BDT)</label>
                            <input type="number" id="CTL_DEBIT_AMT" class="form-control text-end" placeholder="0.00"
                                step="0.01" min="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Credit (BDT)</label>
                            <input type="number" id="CTL_CREDIT_AMT" class="form-control text-end" placeholder="0.00"
                                step="0.01" min="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">USD Debit</label>
                            <input type="number" id="CTL_USD_DEBIT" class="form-control text-end" placeholder="0.00"
                                step="0.01" min="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">USD Credit</label>
                            <input type="number" id="CTL_USD_CREDIT" class="form-control text-end" placeholder="0.00"
                                step="0.01" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Reference</label>
                            <input type="text" id="CTL_REFERENCE" class="form-control"
                                placeholder="Invoice / ref no…">
                        </div>
                    </div>

                    {{-- Row 3: Ledger balance + Credit Limit + Actions --}}
                    <div class="d-flex align-items-center gap-3 flex-wrap">

                        <div>
                            <div class="form-label mb-1">Ledger Balance</div>
                            <div class="input-group input-group-sm" style="width:190px">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-bank" style="font-size:12px"></i>
                                </span>
                                <input type="text" id="LEDGER_BALANCE"
                                    class="form-control text-end bg-light fw-semibold" readonly placeholder="0.00">
                            </div>
                        </div>

                        {{-- CREDIT_LIMIT from AFM_CHART_OF_ACCOUNTS --}}
                        <div id="creditLimitBox" style="display:none">
                            <div class="form-label mb-1">Credit Limit</div>
                            <div class="input-group input-group-sm" style="width:190px">
                                <span class="input-group-text bg-warning">
                                    <i class="bi bi-exclamation-triangle" style="font-size:12px"></i>
                                </span>
                                <input type="text" id="CREDIT_LIMIT"
                                    class="form-control text-end bg-warning bg-opacity-25 fw-semibold" readonly
                                    placeholder="0.00">
                            </div>
                        </div>

                        {{-- Credit limit warning --}}
                        <div id="creditLimitWarn" style="display:none">
                            <span class="badge bg-danger py-2 px-3" style="font-size:12px">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                Credit limit exceeded!
                            </span>
                        </div>

                        <div class="ms-auto d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearLineInputs()">
                                <i class="bi bi-x-circle me-1"></i>Clear
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" id="BTN_ADD" onclick="addLine()">
                                <i class="bi bi-plus-lg me-1"></i>Add Line
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ── VOUCHER LINES CARD ──────────────────────────────── --}}
        <div class="page-card">
            <div class="page-card-header">
                <h6><i class="bi bi-table me-2"></i>Voucher Lines</h6>
                <span id="lineCountBadge" class="badge bg-light text-dark">0 lines</span>
            </div>
            <div class="page-card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered afm-table align-middle mb-0" id="detailTable">
                        <thead>
                            <tr>
                                <th style="width:32px">#</th>
                                <th style="width:110px">Account</th>
                                <th>Account Name</th>
                                <th class="td-r" style="width:110px">Debit (BDT)</th>
                                <th class="td-r" style="width:110px">Credit (BDT)</th>
                                <th class="td-r" style="width:76px">USD Dr</th>
                                <th class="td-r" style="width:76px">USD Cr</th>
                                <th style="width:105px">Reference</th>
                                <th style="width:110px">Party / Emp</th>
                                <th style="width:88px">Cheque</th>
                                <th style="width:58px"></th>
                            </tr>
                        </thead>
                        <tbody id="detailBody">
                            <tr id="emptyRow">
                                <td colspan="11" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                    No lines added yet. Use the form above to add lines.
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end text-muted pe-2">
                                    <strong>TOTAL</strong>
                                </td>
                                <td class="td-r td-mono fw-bold" id="totalDebit">0.00</td>
                                <td class="td-r td-mono fw-bold" id="totalCredit">0.00</td>
                                <td class="td-r td-mono" id="totalUsdDebit">0.00</td>
                                <td class="td-r td-mono" id="totalUsdCredit">0.00</td>
                                <td colspan="3"></td>
                                <td id="balanceCell"></td>
                            </tr>
                            <tr>
                                <td colspan="11" class="text-muted" id="amountWords"
                                    style="font-size:11px;font-style:italic;padding:5px 10px;background:#f8f9fa">
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Toolbar --}}
            <div class="form-toolbar">
                <a href="{{ route('vouchers.create') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>New
                </a>
                <button type="submit" class="btn btn-success btn-sm" id="BTN_SAVE">
                    <i class="bi bi-save me-1"></i>Save
                </button>
                <button type="button" class="btn btn-primary btn-sm" id="BTN_SUBMIT" onclick="quickSubmit()">
                    <i class="bi bi-send me-1"></i>Submit
                </button>
                <button type="button" class="btn btn-outline-dark btn-sm" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>Print
                </button>
                <a href="{{ route('vouchers.index') }}" class="btn btn-outline-secondary btn-sm ms-auto">
                    <i class="bi bi-arrow-left me-1"></i>Back to List
                </a>
            </div>
        </div>

        {{-- Hidden lines container --}}
        <div id="hiddenLines"></div>

    </form>

    {{-- ── ACCOUNT LOV MODAL ───────────────────────────────── --}}
    <div class="modal" id="accountLovModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background:#003366;color:#fff;padding:10px 16px">
                    <h6 class="modal-title">
                        <i class="bi bi-search me-2"></i>Select Account
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row g-2 mb-2">
                        <div class="col-md-5">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" id="lovSearch" class="form-control"
                                    placeholder="Search by code or account name…" oninput="searchAccounts()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select id="lovTypeFilter" class="form-select form-select-sm" onchange="searchAccounts()">
                                <option value="">All account types</option>
                                <option value="creditor">Creditor (IS_CREDITOR=1)</option>
                                <option value="debtor">Debtor (IS_DETOR=1)</option>
                                <option value="employee">Employee (IS_EMPLOYEE=1)</option>
                                <option value="asset">Asset (IS_ASSET=1)</option>
                                <option value="lc">LC (IS_LC=1)</option>
                                <option value="cost_center">Cost Center (IS_COST_CENTER=1)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-info py-1 px-2 mb-0" style="font-size:11px">
                                <i class="bi bi-info-circle me-1"></i>
                                Double-click or click a row to select the account
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm afm-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width:120px">Account Code</th>
                                    <th>Account Name</th>
                                    <th class="td-r" style="width:130px">Ledger Balance</th>
                                    <th style="width:80px">Credit Limit</th>
                                    <th style="width:160px">Type Flags</th>
                                </tr>
                            </thead>
                            <tbody id="lovResults">
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        <div class="spinner-border spinner-border-sm me-2"></div>
                                        Loading accounts…
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // ══════════════════════════════════════════════════════════════
            //  Voucher Entry Form — JavaScript
            //  AFM_CHART_OF_ACCOUNTS flags:
            //    IS_CREDITOR, IS_DETOR, IS_LC, IS_COST_CENTER,
            //    IS_ASSET, IS_EMPLOYEE, IS_MASTER_LC
            //  CREDIT_LIMIT binding included
            // ══════════════════════════════════════════════════════════════

            let lines = [];
            let editIdx = null;
            let selAcc = null; // currently selected account full row data
            let lovModal = null;

            document.addEventListener('DOMContentLoaded', function() {
                lovModal = new bootstrap.Modal(document.getElementById('accountLovModal'));
                onVoucherTypeChange(document.getElementById('VOUCHER_TYPE').value);
                renderLines();
                document.getElementById('VOUCHER_TYPE').focus();
            });

            // ── VOUCHER TYPE: change Pay To / Received From label + cash row
            function onVoucherTypeChange(type) {
                const lbl = document.getElementById('payReceiveLabel');
                lbl.textContent = ['CASHP', 'BANKP'].includes(type) ? 'Pay To' : ['CASHR', 'BANKR'].includes(type) ?
                    'Received From' :
                    'Pay To / Received From';

                // Cheque sub-field only for bank vouchers
                if (selAcc) applyAccountFlags(selAcc, type);
            }

            // ── VOUCHER DATE: validate not future (except POSDT)
            function validateVoucherDate(val) {
                const d = new Date(val);
                const type = document.getElementById('VOUCHER_TYPE').value;
                if (d > new Date() && type !== 'POSDT') {
                    showToast('Voucher date cannot be in the future.', 'warning');
                    document.getElementById('VOUCHER_DATE').value =
                        new Date().toISOString().slice(0, 10);
                }
            }

            // ══════════════════════════════════════════════════════════════
            //  ACCOUNT LOV
            // ══════════════════════════════════════════════════════════════

            function openAccountLov() {
                const modalEl = document.getElementById('accountLovModal');

                const modal = new bootstrap.Modal(modalEl);
                modal.show();

                document.getElementById('lovSearch').value = '';
                document.getElementById('lovTypeFilter').value = '';
                searchAccounts();
            }

            function searchAccounts() {
                const q = document.getElementById('lovSearch').value;
                const company = document.getElementById('COMPANY_ID').value;
                const type = document.getElementById('lovTypeFilter').value;

                document.getElementById('lovResults').innerHTML =
                    '<tr><td colspan="5" class="text-center text-muted py-3">' +
                    '<div class="spinner-border spinner-border-sm me-2"></div>Searching…</td></tr>';

                fetch(
                        `{{ route('vouchers.api.lov') }}?q=${encodeURIComponent(q)}&company_id=${encodeURIComponent(company)}&type=${encodeURIComponent(type)}`
                    )
                    .then(r => r.json())
                    .then(rows => renderLovResults(rows))
                    .catch(() => searchAccountsFallback(q));
            }

            function renderLovResults(rows) {
                const tbody = document.getElementById('lovResults');
                if (!rows.length) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-3">No accounts found.</td></tr>';
                    return;
                }
                tbody.innerHTML = rows.map(r => `
                    <tr class="lov-row" style="cursor:pointer" data-row='${escJson(r)}'>
                        <td class="td-mono text-primary">${r.account_head_id}</td>
                        <td>${r.account_head_name}</td>
                        <td class="td-r td-mono ${parseFloat(r.balance||0)<0?'text-danger':''}">
                            ${parseFloat(r.balance||0).toLocaleString('en-US',{minimumFractionDigits:2})}
                        </td>
                        <td class="td-r td-mono ${parseFloat(r.credit_limit||0)>0?'text-warning':'text-muted'}">
                            ${parseFloat(r.credit_limit||0)>0
                                ? parseFloat(r.credit_limit).toLocaleString('en-US',{minimumFractionDigits:2})
                                : '—'}
                        </td>
                        <td>${buildFlagPills(r)}</td>
                    </tr>`).join('');
            }

            // Safely escape JSON for data-row attribute
            function escJson(obj) {
                return JSON.stringify(obj)
                    .replace(/'/g, '&#39;')
                    .replace(/"/g, '&quot;');
            }

            // Fallback sample data for dev / demo
            function searchAccountsFallback(q) {
                const sample = [{
                        account_head_id: '0102001001',
                        account_head_name: 'Cash in hand — main',
                        balance: 125400.50,
                        credit_limit: 0,
                        is_creditor: 0,
                        is_detor: 0,
                        is_employee: 0,
                        is_asset: 0,
                        is_cost_center: 0,
                        is_lc: 0,
                        is_master_lc: 0
                    },
                    {
                        account_head_id: '0102002001',
                        account_head_name: 'Bank — current account',
                        balance: 842300.00,
                        credit_limit: 0,
                        is_creditor: 0,
                        is_detor: 0,
                        is_employee: 0,
                        is_asset: 0,
                        is_cost_center: 0,
                        is_lc: 0,
                        is_master_lc: 0,
                        is_cheque: 1
                    },
                    {
                        account_head_id: '0301001001',
                        account_head_name: 'Accounts payable — creditors',
                        balance: -340000.00,
                        credit_limit: 500000,
                        is_creditor: 1,
                        is_detor: 0,
                        is_employee: 0,
                        is_asset: 0,
                        is_cost_center: 0,
                        is_lc: 0,
                        is_master_lc: 0
                    },
                    {
                        account_head_id: '0301002001',
                        account_head_name: 'Accounts receivable',
                        balance: 178500.00,
                        credit_limit: 300000,
                        is_creditor: 0,
                        is_detor: 1,
                        is_employee: 0,
                        is_asset: 0,
                        is_cost_center: 0,
                        is_lc: 0,
                        is_master_lc: 0
                    },
                    {
                        account_head_id: '0401001001',
                        account_head_name: 'Salary expense',
                        balance: 0,
                        credit_limit: 0,
                        is_creditor: 0,
                        is_detor: 0,
                        is_employee: 1,
                        is_asset: 0,
                        is_cost_center: 1,
                        is_lc: 0,
                        is_master_lc: 0
                    },
                    {
                        account_head_id: '0501001001',
                        account_head_name: 'Fixed assets — equipment',
                        balance: 950000.00,
                        credit_limit: 0,
                        is_creditor: 0,
                        is_detor: 0,
                        is_employee: 0,
                        is_asset: 1,
                        is_cost_center: 0,
                        is_lc: 0,
                        is_master_lc: 0
                    },
                    {
                        account_head_id: '0601001001',
                        account_head_name: 'LC payable',
                        balance: -55000.00,
                        credit_limit: 200000,
                        is_creditor: 0,
                        is_detor: 0,
                        is_employee: 0,
                        is_asset: 0,
                        is_cost_center: 0,
                        is_lc: 1,
                        is_master_lc: 1
                    },
                    {
                        account_head_id: '0701001001',
                        account_head_name: 'General expense',
                        balance: 0,
                        credit_limit: 0,
                        is_creditor: 0,
                        is_detor: 0,
                        is_employee: 0,
                        is_asset: 0,
                        is_cost_center: 1,
                        is_lc: 0,
                        is_master_lc: 0
                    },
                    {
                        account_head_id: '0801001001',
                        account_head_name: 'Capital account',
                        balance: 1500000.00,
                        credit_limit: 0,
                        is_creditor: 0,
                        is_detor: 0,
                        is_employee: 0,
                        is_asset: 0,
                        is_cost_center: 0,
                        is_lc: 0,
                        is_master_lc: 0
                    },
                ];
                const lower = (q || '').toLowerCase();
                const rows = lower ?
                    sample.filter(a =>
                        a.account_head_id.includes(lower) ||
                        a.account_head_name.toLowerCase().includes(lower)) :
                    sample;
                renderLovResults(rows);
            }

            // Build flag pills from AFM_CHART_OF_ACCOUNTS columns
            function buildFlagPills(r) {
                const map = [
                    ['is_creditor', 'primary', 'Creditor'],
                    ['is_detor', 'success', 'Debtor'],
                    ['is_employee', 'purple', 'Employee'],
                    ['is_asset', 'warning', 'Asset'],
                    ['is_cost_center', 'secondary', 'Cost Ctr'],
                    ['is_lc', 'danger', 'LC'],
                    ['is_master_lc', 'danger', 'Master LC'],
                    ['is_cheque', 'info', 'Cheque'],
                ];
                const pills = map
                    .filter(([k]) => parseInt(r[k] || 0) === 1)
                    .map(([, c, l]) => {
                        const style = c === 'purple' ?
                            'style="background:#6f42c1;color:#fff;font-size:10px"' :
                            `style="font-size:10px"`;
                        return `<span class="badge bg-${c}" ${style}>${l}</span>`;
                    })
                    .join(' ');
                return pills || '<span class="text-muted" style="font-size:11px">—</span>';
            }

            // Click on a LOV row → select account
            document.addEventListener('click', function(e) {
                const row = e.target.closest('.lov-row');
                if (row) selectAccount(JSON.parse(row.dataset.row.replace(/&quot;/g, '"').replace(/&#39;/g, "'")));
            });

            function selectAccount(data) {
                selAcc = data;

                document.getElementById('CTL_ACCOUNT_ID').value = data.account_head_id;
                document.getElementById('CTL_ACCOUNT_NAME').textContent = data.account_head_name;

                const bal = parseFloat(data.balance || 0);
                const balEl = document.getElementById('LEDGER_BALANCE');
                balEl.value = bal.toLocaleString('en-US', {
                    minimumFractionDigits: 2
                });

                bindCreditLimit(data);
                applyAccountFlags(data, document.getElementById('VOUCHER_TYPE').value);

                const modalEl = document.getElementById('accountLovModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
                // remove backdrop instantly

                // ✅ FIX SCROLL ISSUE
                setTimeout(() => {
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';

                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                }, 200);
                setTimeout(() => {
                    focusNextFieldAfterAccount();
                }, 100);
            }



            //focus next field
            function focusNextFieldAfterAccount() {
                const order = [
                    'sfCreditor',
                    'sfDetor',
                    'sfEmployee',
                    'sfAsset',
                    'sfCostCenter',
                    'sfLC',
                    'sfMasterLC',
                    'sfCheque'
                ];

                for (let id of order) {
                    const el = document.getElementById(id);

                    if (el && el.style.display !== 'none') {
                        const input = el.querySelector('input');
                        if (input) {
                            input.focus();
                            return;
                        }
                    }
                }

                // fallback → debit field
                document.getElementById('CTL_DEBIT_AMT').focus();
            }



            // Bind credit limit from AFM_CHART_OF_ACCOUNTS.CREDIT_LIMIT
            function bindCreditLimit(data) {
                const limit = parseFloat(data.credit_limit || 0);
                const limitBox = document.getElementById('creditLimitBox');
                const limitEl = document.getElementById('CREDIT_LIMIT');
                const warnEl = document.getElementById('creditLimitWarn');

                if (limit > 0) {
                    limitBox.style.display = '';
                    limitEl.value = limit.toLocaleString('en-US', {
                        minimumFractionDigits: 2
                    });
                    checkCreditLimit(); // check immediately
                } else {
                    limitBox.style.display = 'none';
                    warnEl.style.display = 'none';
                }
            }

            // Check if current credit amount exceeds limit
            function checkCreditLimit() {
                if (!selAcc) return;
                const limit = parseFloat(selAcc.credit_limit || 0);
                const credit = parseFloat(document.getElementById('CTL_CREDIT_AMT').value || 0);
                const bal = parseFloat(selAcc.balance || 0);
                const warnEl = document.getElementById('creditLimitWarn');

                if (limit > 0 && (Math.abs(bal) + credit) > limit) {
                    warnEl.style.display = '';
                } else {
                    warnEl.style.display = 'none';
                }
            }

            // ── APPLY ACCOUNT FLAGS → show/hide sub-fields
            // Maps directly to AFM_CHART_OF_ACCOUNTS columns
            // ALL fields hidden by default (style="display:none" in HTML)
            // Only shown when the corresponding flag = 1
            function applyAccountFlags(data, vtype) {
                // Helper: show or hide a sub-field by id
                const tog = (id, show) => {
                    const el = document.getElementById(id);
                    if (!el) return;
                    el.style.display = show ? '' : 'none';
                    // Clear inputs when hiding so stale data isn't submitted
                    if (!show) {
                        el.querySelectorAll('input').forEach(inp => inp.value = '');
                    }
                };

                // Each flag maps 1:1 to AFM_CHART_OF_ACCOUNTS column
                // parseInt handles both "1" strings and 1 numbers from API
                tog('sfCreditor', parseInt(data.is_creditor ?? data.IS_CREDITOR ?? 0) === 1);
                tog('sfDetor', parseInt(data.is_detor ?? data.IS_DETOR ?? 0) === 1);
                tog('sfEmployee', parseInt(data.is_employee ?? data.IS_EMPLOYEE ?? 0) === 1);
                tog('sfAsset', parseInt(data.is_asset ?? data.IS_ASSET ?? 0) === 1);
                tog('sfCostCenter', parseInt(data.is_cost_center ?? data.IS_COST_CENTER ?? 0) === 1);
                tog('sfLC', parseInt(data.is_lc ?? data.IS_LC ?? 0) === 1);
                tog('sfMasterLC', parseInt(data.is_master_lc ?? data.IS_MASTER_LC ?? 0) === 1);

                // Cheque is NOT a flag column — shown only for bank voucher types
                tog('sfCheque', ['BANKP', 'BANKR'].includes(vtype));
            }

            // ── Account code typed manually → fetch flags from API
            function onAccountCodeChange() {
                const id = document.getElementById('CTL_ACCOUNT_ID').value.trim();
                const company = document.getElementById('COMPANY_ID').value;
                if (!id) return;

                fetch(
                        `{{ route('vouchers.api.flags') }}?account_head_id=${encodeURIComponent(id)}&company_id=${encodeURIComponent(company)}`
                    )
                    .then(r => r.json())
                    .then(data => {
                        // API returns: account_title, ledger_balance, credit_limit,
                        //   IS_CREDITOR, IS_DETOR, IS_LC, IS_COST_CENTER,
                        //   IS_ASSET, IS_EMPLOYEE, IS_MASTER_LC
                        // Normalise to lowercase for consistency
                        const norm = {};
                        Object.keys(data).forEach(k => norm[k.toLowerCase()] = data[k]);
                        norm.account_head_id = id;
                        norm.account_head_name = data.account_title || '';
                        norm.balance = data.ledger_balance || 0;

                        selectAccount(norm);
                    })
                    .catch(() => showToast('Account not found.', 'danger'));
            }

            // ── Load party name (Creditor / Debtor) from API
            function loadPartyName(type) {
                const codeEl = type === 'creditor' ?
                    document.getElementById('CTL_CREDITOR_CODE') :
                    document.getElementById('CTL_DETOR_CODE');
                const nameEl = type === 'creditor' ?
                    document.getElementById('CTL_CREDITOR_NAME') :
                    document.getElementById('CTL_DETOR_NAME');
                if (!codeEl || !codeEl.value.trim()) return;

                fetch(`{{ route('vouchers.api.party') }}?code=${encodeURIComponent(codeEl.value.trim())}&type=${type}`)
                    .then(r => r.json())
                    .then(d => {
                        if (nameEl && d.name) nameEl.value = d.name;
                    })
                    .catch(() => {});
            }

            function loadEmpName() {
                const code = document.getElementById('CTL_EMP_CODE').value.trim();
                if (!code) return;
                fetch(`{{ route('vouchers.api.employee') }}?code=${encodeURIComponent(code)}`)
                    .then(r => r.json())
                    .then(d => {
                        const el = document.getElementById('CTL_EMP_NAME');
                        if (el && d.name) el.value = d.name;
                    })
                    .catch(() => {});
            }

            function openPartyLov(type) {
                // TODO: open specific party LOV modal for creditor / debtor / employee / asset
                showToast('Party LOV for ' + type + ' — connect to your party table.', 'info');
            }

            // ══════════════════════════════════════════════════════════════
            //  LINE MANAGEMENT
            // ══════════════════════════════════════════════════════════════

            function addLine() {
                if (!selAcc) {
                    showToast('Please select an account first.', 'warning');
                    return;
                }
                const dr = parseFloat(document.getElementById('CTL_DEBIT_AMT').value) || 0;
                const cr = parseFloat(document.getElementById('CTL_CREDIT_AMT').value) || 0;
                const udr = parseFloat(document.getElementById('CTL_USD_DEBIT').value) || 0;
                const ucr = parseFloat(document.getElementById('CTL_USD_CREDIT').value) || 0;

                if (dr === 0 && cr === 0) {
                    showToast('Enter a debit or credit amount.', 'warning');
                    return;
                }
                if (dr > 0 && cr > 0) {
                    showToast('A line cannot have both debit and credit.', 'danger');
                    return;
                }

                // Credit limit check before adding
                const limit = parseFloat(selAcc.credit_limit || 0);
                const bal = parseFloat(selAcc.balance || 0);
                if (limit > 0 && cr > 0 && (Math.abs(bal) + cr) > limit) {
                    if (!confirm(
                            `Credit amount (${cr.toFixed(2)}) exceeds credit limit (${limit.toFixed(2)}).\nDo you want to continue?`
                        )) {
                        return;
                    }
                }

                const line = {
                    accountId: selAcc.account_head_id,
                    accountName: selAcc.account_head_name,
                    debit: dr,
                    credit: cr,
                    usdDr: udr,
                    usdCr: ucr,
                    ref: document.getElementById('CTL_REFERENCE').value,
                    credCode: document.getElementById('CTL_CREDITOR_CODE')?.value || '',
                    credName: document.getElementById('CTL_CREDITOR_NAME')?.value || '',
                    detorCode: document.getElementById('CTL_DETOR_CODE')?.value || '',
                    detorName: document.getElementById('CTL_DETOR_NAME')?.value || '',
                    empCode: document.getElementById('CTL_EMP_CODE')?.value || '',
                    empName: document.getElementById('CTL_EMP_NAME')?.value || '',
                    assetCode: document.getElementById('CTL_ASSET_CODE')?.value || '',
                    costCenter: document.getElementById('CTL_COST_CENTER')?.value || '',
                    lcNo: document.getElementById('CTL_LC_NO')?.value || '',
                    masterLcNo: document.getElementById('CTL_MASTER_LC_NO')?.value || '',
                    cheqNo: document.getElementById('CTL_CHE_RECP_NO')?.value || '',
                    companyId: document.getElementById('COMPANY_ID').value,
                };

                if (editIdx !== null) {
                    lines[editIdx] = line;
                    editIdx = null;
                    document.getElementById('BTN_ADD').innerHTML =
                        '<i class="bi bi-plus-lg me-1"></i>Add Line';
                    document.querySelectorAll('#detailBody tr').forEach(tr =>
                        tr.classList.remove('table-warning'));
                } else {
                    lines.push(line);
                }

                renderLines();
                clearLineInputs();
            }

            function editLine(i) {
                const l = lines[i];
                // Highlight row
                document.querySelectorAll('#detailBody tr').forEach(tr =>
                    tr.classList.remove('table-warning'));
                document.querySelectorAll('#detailBody tr')[i]?.classList.add('table-warning');

                document.getElementById('CTL_ACCOUNT_ID').value = l.accountId;
                document.getElementById('CTL_ACCOUNT_NAME').textContent = l.accountName;
                document.getElementById('CTL_DEBIT_AMT').value = l.debit || '';
                document.getElementById('CTL_CREDIT_AMT').value = l.credit || '';
                document.getElementById('CTL_USD_DEBIT').value = l.usdDr || '';
                document.getElementById('CTL_USD_CREDIT').value = l.usdCr || '';
                document.getElementById('CTL_REFERENCE').value = l.ref;
                if (document.getElementById('CTL_CHE_RECP_NO'))
                    document.getElementById('CTL_CHE_RECP_NO').value = l.cheqNo;
                if (document.getElementById('CTL_CREDITOR_CODE'))
                    document.getElementById('CTL_CREDITOR_CODE').value = l.credCode;
                if (document.getElementById('CTL_DETOR_CODE'))
                    document.getElementById('CTL_DETOR_CODE').value = l.detorCode;

                editIdx = i;
                document.getElementById('BTN_ADD').innerHTML =
                    '<i class="bi bi-check-lg me-1"></i>Update Line';
                window.scrollTo({
                    top: document.getElementById('voucherForm').offsetTop - 80,
                    behavior: 'smooth'
                });
            }

            function removeLine(i) {
                lines.splice(i, 1);
                renderLines();
            }

            function clearLineInputs() {
                selAcc = null;
                ['CTL_ACCOUNT_ID', 'CTL_DEBIT_AMT', 'CTL_CREDIT_AMT', 'CTL_USD_DEBIT', 'CTL_USD_CREDIT',
                    'CTL_REFERENCE', 'CTL_CREDITOR_CODE', 'CTL_CREDITOR_NAME', 'CTL_DETOR_CODE', 'CTL_DETOR_NAME',
                    'CTL_EMP_CODE', 'CTL_EMP_NAME', 'CTL_ASSET_CODE', 'CTL_COST_CENTER',
                    'CTL_LC_NO', 'CTL_MASTER_LC_NO', 'CTL_CHE_RECP_NO'
                ]
                .forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.value = '';
                });

                document.getElementById('CTL_ACCOUNT_NAME').textContent = '';
                document.getElementById('LEDGER_BALANCE').value = '';
                document.getElementById('CREDIT_LIMIT').value = '';
                document.getElementById('creditLimitBox').style.display = 'none';
                document.getElementById('creditLimitWarn').style.display = 'none';

                // Hide ALL sub-fields — they are only shown after account selection
                ['sfCreditor', 'sfDetor', 'sfEmployee', 'sfAsset',
                    'sfCostCenter', 'sfLC', 'sfMasterLC', 'sfCheque'
                ]
                .forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.style.display = 'none';
                });
            }

            function renderLines() {
                const tbody = document.getElementById('detailBody');
                document.getElementById('lineCountBadge').textContent =
                    lines.length + ' line' + (lines.length !== 1 ? 's' : '');

                if (!lines.length) {
                    tbody.innerHTML =
                        `<tr><td colspan="11" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                        No lines added yet. Use the form above to add lines.</td></tr>`;
                    buildHiddenInputs();
                    updateTotals();
                    return;
                }

                tbody.innerHTML = lines.map((l, i) => `
                    <tr class="${editIdx===i?'table-warning':''}">
                        <td class="text-muted">${i + 1}</td>
                        <td class="td-mono text-primary">${l.accountId}</td>
                        <td>
                            <div>${l.accountName}</div>
                            ${(l.credName||l.detorName||l.empName)
                                ? `<small class="text-muted" style="font-size:10px">
                                                                                                                                                                                                                                                            ${l.credName||l.detorName||l.empName}</small>`
                                : ''}
                        </td>
                        <td class="td-r td-mono">${l.debit  > 0 ? l.debit.toFixed(2)  : ''}</td>
                        <td class="td-r td-mono">${l.credit > 0 ? l.credit.toFixed(2) : ''}</td>
                        <td class="td-r td-mono">${l.usdDr  > 0 ? l.usdDr.toFixed(2)  : ''}</td>
                        <td class="td-r td-mono">${l.usdCr  > 0 ? l.usdCr.toFixed(2)  : ''}</td>
                        <td class="text-muted" style="font-size:11px">${l.ref}</td>
                        <td class="text-muted" style="font-size:11px">
                            ${l.credCode||l.detorCode||l.empCode||''}
                        </td>
                        <td class="text-muted" style="font-size:11px">${l.cheqNo}</td>
                        <td>
                            <button type="button"
                                class="btn btn-outline-secondary btn-sm py-0 px-1 me-1"
                                onclick="editLine(${i})" title="Edit">
                                <i class="bi bi-pencil" style="font-size:10px"></i>
                            </button>
                            <button type="button"
                                class="btn btn-outline-danger btn-sm py-0 px-1"
                                onclick="removeLine(${i})" title="Remove">
                                <i class="bi bi-trash" style="font-size:10px"></i>
                            </button>
                        </td>
                    </tr>`).join('');

                buildHiddenInputs();
                updateTotals();
            }

            function buildHiddenInputs() {
                document.getElementById('hiddenLines').innerHTML = lines.map((l, i) => `
                    <input type="hidden" name="lines[${i}][ACCOUNT_HEAD_ID]" value="${l.accountId}">
                    <input type="hidden" name="lines[${i}][DEBIT_AMOUNT]"    value="${l.debit}">
                    <input type="hidden" name="lines[${i}][CREDIT_AMOUNT]"   value="${l.credit}">
                    <input type="hidden" name="lines[${i}][USD_DEBIT]"       value="${l.usdDr}">
                    <input type="hidden" name="lines[${i}][USD_CREDIT]"      value="${l.usdCr}">
                    <input type="hidden" name="lines[${i}][REFERENCE_NO]"    value="${l.ref}">
                    <input type="hidden" name="lines[${i}][CREDITOR_CODE]"   value="${l.credCode}">
                    <input type="hidden" name="lines[${i}][DETOR_CODE]"      value="${l.detorCode}">
                    <input type="hidden" name="lines[${i}][EMP_CODE]"        value="${l.empCode}">
                    <input type="hidden" name="lines[${i}][ASSET_CODE]"      value="${l.assetCode}">
                    <input type="hidden" name="lines[${i}][COST_CENTER]"     value="${l.costCenter}">
                    <input type="hidden" name="lines[${i}][LC_NO]"           value="${l.lcNo}">
                    <input type="hidden" name="lines[${i}][MASTER_LC_NO]"    value="${l.masterLcNo}">
                    <input type="hidden" name="lines[${i}][CHE_RECP_NO]"     value="${l.cheqNo}">
                    <input type="hidden" name="lines[${i}][COMPANY_ID]"      value="${l.companyId}">`).join('');
            }

            function updateTotals() {
                const tdr = lines.reduce((s, l) => s + l.debit, 0);
                const tcr = lines.reduce((s, l) => s + l.credit, 0);
                const tudr = lines.reduce((s, l) => s + l.usdDr, 0);
                const tucr = lines.reduce((s, l) => s + l.usdCr, 0);

                document.getElementById('totalDebit').textContent = tdr.toFixed(2);
                document.getElementById('totalCredit').textContent = tcr.toFixed(2);
                document.getElementById('totalUsdDebit').textContent = tudr.toFixed(2);
                document.getElementById('totalUsdCredit').textContent = tucr.toFixed(2);

                const diff = Math.abs(tdr - tcr);
                const cell = document.getElementById('balanceCell');

                if (lines.length && diff < 0.001) {
                    cell.innerHTML =
                        '<span class="badge bg-success"><i class="bi bi-check-lg me-1"></i>Balanced</span>';
                    document.getElementById('amountWords').textContent =
                        'In words: ' + spellOut(tdr);
                } else if (lines.length) {
                    cell.innerHTML =
                        `<span class="badge bg-danger" title="Difference: ${diff.toFixed(2)}">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>${diff.toFixed(2)}
                        </span>`;
                    document.getElementById('amountWords').textContent = '';
                } else {
                    cell.innerHTML = '';
                    document.getElementById('amountWords').textContent = '';
                }
            }

            function spellOut(n) {
                const ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
                    'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
                ];
                const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

                function hw(n) {
                    if (!n) return '';
                    if (n < 20) return ones[n] + ' ';
                    if (n < 100) return tens[Math.floor(n / 10)] + ' ' + (n % 10 ? ones[n % 10] + ' ' : '');
                    return ones[Math.floor(n / 100)] + ' Hundred ' + (n % 100 ? hw(n % 100) : '');
                }
                const i = Math.floor(n);
                if (!i) return 'Zero Only';
                let r = '';
                if (i >= 1000000) r += hw(Math.floor(i / 1000000)) + 'Million ';
                if (i >= 1000) r += hw(Math.floor((i % 1000000) / 1000)) + 'Thousand ';
                r += hw(i % 1000);
                return r.trim() + ' Only';
            }

            function quickSubmit() {
                if (!lines.length) {
                    showToast('Add voucher lines first.', 'warning');
                    return;
                }
                const dr = lines.reduce((s, l) => s + l.debit, 0);
                const cr = lines.reduce((s, l) => s + l.credit, 0);
                if (Math.abs(dr - cr) > 0.001) {
                    showToast('Debit and credit must balance before submitting.', 'danger');
                    return;
                }
                if (confirm('Submit this voucher for approval?')) {
                    document.getElementById('hiddenLines').innerHTML +=
                        '<input type="hidden" name="_submit_after_save" value="1">';
                    document.getElementById('voucherForm').submit();
                }
            }

            // ── FORM SUBMIT validation
            document.getElementById('voucherForm').addEventListener('submit', function(e) {
                this.classList.add('was-validated');
                if (!this.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                    showToast('Please fill in all required fields.', 'warning');
                    return;
                }
                if (!lines.length) {
                    e.preventDefault();
                    showToast('Please add at least one voucher line.', 'warning');
                    return;
                }
                const dr = lines.reduce((s, l) => s + l.debit, 0);
                const cr = lines.reduce((s, l) => s + l.credit, 0);
                if (Math.abs(dr - cr) > 0.001) {
                    e.preventDefault();
                    showToast(`Debit (${dr.toFixed(2)}) and Credit (${cr.toFixed(2)}) must be equal.`, 'danger');
                }
            });

            // ── AUTO-CLEAR opposite amount field
            document.getElementById('CTL_DEBIT_AMT').addEventListener('input', function() {
                if (parseFloat(this.value) > 0)
                    document.getElementById('CTL_CREDIT_AMT').value = '';
                checkCreditLimit();
            });
            document.getElementById('CTL_CREDIT_AMT').addEventListener('input', function() {
                if (parseFloat(this.value) > 0)
                    document.getElementById('CTL_DEBIT_AMT').value = '';
                checkCreditLimit();
            });

            // ── ENTER KEY: move to next field
            document.getElementById('voucherForm').addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
                    e.preventDefault();
                    const els = [...this.elements];
                    const idx = els.indexOf(e.target);
                    const next = els.slice(idx + 1).find(el =>
                        !el.disabled && !el.readOnly && el.tabIndex !== -1 && ['INPUT', 'SELECT', 'BUTTON']
                        .includes(el.tagName));
                    if (next) next.focus();
                }
            });

            function showToast(msg, type = 'info') {
                const old = document.getElementById('_toast');
                if (old) old.remove();
                const icons = {
                    warning: 'exclamation-triangle',
                    danger: 'x-circle',
                    success: 'check-circle',
                    info: 'info-circle'
                };
                const div = document.createElement('div');
                div.id = '_toast';
                div.className = `alert alert-${type} alert-dismissible fade show d-flex align-items-center gap-2 py-2`;
                div.style.cssText =
                    'position:fixed;top:70px;right:20px;z-index:9999;max-width:420px;font-size:12px;box-shadow:0 4px 12px rgba(0,0,0,.15)';
                div.innerHTML = `
                    <i class="bi bi-${icons[type]||'info-circle'}-fill"></i>
                    <span>${msg}</span>
                    <button type="button" class="btn-close ms-auto"
                        onclick="this.parentElement.remove()"></button>`;
                document.body.appendChild(div);
                setTimeout(() => {
                    if (div.parentElement) div.remove();
                }, 4500);
            }
        </script>
    @endpush
@endsection
