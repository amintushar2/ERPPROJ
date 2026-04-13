@extends('accounts.ventry.layouts.app')
@section('title', 'Voucher Summary — AFM Finance')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('vouchers.index') }}" class="text-decoration-none text-secondary">Vouchers</a>
    </li>
    <li class="breadcrumb-item active">Summary</li>
@endsection

@section('content')

    {{-- METRIC CARDS --}}
    <div class="row g-3 mb-4">

        <div class="col-sm-6 col-xl-3">
            <div class="metric-card accent-blue h-100">
                <div class="metric-label">
                    <i class="bi bi-journal-text me-1"></i> Total Vouchers
                </div>
                <div class="metric-val" id="mTotal">{{ $totalVouchers ?? 0 }}</div>
                <div class="metric-sub">this month</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="metric-card accent-orange h-100">
                <div class="metric-label">
                    <i class="bi bi-hourglass-split me-1"></i> Unapproved
                </div>
                <div class="metric-val text-warning" id="mPending">{{ $unapproved ?? 0 }}</div>
                <div class="metric-sub">awaiting action</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="metric-card accent-teal h-100">
                <div class="metric-label">
                    <i class="bi bi-currency-exchange me-1"></i> Total Debit (BDT)
                </div>
                <div class="metric-val" style="font-size:20px">
                    {{ number_format($totalDebit ?? 0, 0) }}
                </div>
                <div class="metric-sub">balanced entries</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="metric-card accent-green h-100">
                <div class="metric-label">
                    <i class="bi bi-check-circle me-1"></i> Approved
                </div>
                <div class="metric-val text-success">{{ $approved ?? 0 }}</div>
                <div class="metric-sub">this month</div>
            </div>
        </div>

    </div>

    {{-- MAIN CARD --}}
    <div class="page-card">

        <div class="page-card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">
                <i class="bi bi-bar-chart-line me-2"></i>Voucher Summary
            </h6>

            <a href="{{ route('vouchers.create') }}" class="btn btn-warning btn-sm px-3">
                <i class="bi bi-plus-lg me-1"></i>New Voucher
            </a>
        </div>

        <div class="page-card-body">
            @php $currentStatus = request('status'); @endphp

            {{-- STATUS TABS --}}
            <ul class="nav nav-tabs mb-3 flex-wrap" id="statusTabs">
                <li class="nav-item">
                    <button class="nav-link {{ $currentStatus == '' ? 'active' : '' }}" onclick="setTab(this,'')">
                        All
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link {{ $currentStatus == 'Complete' ? 'active' : '' }}"
                        onclick="setTab(this,'Complete')">
                        Complete
                    </button>
                </li>

                <li class="nav-item">

                    <button class="nav-link {{ $currentStatus == 'Submited' ? 'active' : '' }}"
                        onclick="setTab(this,'Submited')">
                        Submitted
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link {{ $currentStatus == 'Approved' ? 'active' : '' }}"
                        onclick="setTab(this,'Approved')">
                        Approved
                    </button>
                </li>
            </ul>

            {{-- FILTER --}}
            <form id="filterForm" onsubmit="event.preventDefault(); loadVouchers();">
                <input type="hidden" name="status" id="statusInput" value="{{ request('status') }}">

                <div class="row g-2 align-items-end mb-3">

                    <div class="col-md-3">
                        <label class="form-label">Search</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>

                            <input type="text" id="searchBox" name="search" class="form-control"
                                value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">From</label>
                        <input type="date" name="s_from_date" class="form-control form-control-sm"
                            value="{{ request('s_from_date') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">To</label>
                        <input type="date" name="s_to_date" class="form-control form-control-sm"
                            value="{{ request('s_to_date') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Type</label>
                        <select name="voucher_type" class="form-select form-select-sm">
                            <option value="">All</option>
                            @foreach (['CASHP', 'BANKP', 'CASHR', 'BANKR', 'JOURL', 'POSDT'] as $t)
                                <option value="{{ $t }}" {{ request('voucher_type') == $t ? 'selected' : '' }}>
                                    {{ $t }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Company</label>
                        <select name="company_id" class="form-select form-select-sm">
                            <option value="">All</option>
                            @foreach ($companies ?? [] as $c)
                                <option value="{{ $c->company_id }}"
                                    {{ request('company_id') == $c->company_id ? 'selected' : '' }}>
                                    {{ $c->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1 d-flex gap-1">
                        <button class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                </div>
            </form>

            {{-- TABLE --}}
            <div class="table-responsive">
                <canvas id="voucherChart" height="80"></canvas>
                <table class="table table-bordered table-sm afm-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th>Voucher</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Pay To</th>
                            <th>Company</th>
                            <th class="text-end">Debit</th>
                            <th class="text-end">Credit</th>
                            <th>Status</th>
                            <th>Prepared</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody id="voucherTable">
                        @forelse($vouchers ?? [] as $v)
                            @php
                                $dr = $v->details->sum('debit_amount');
                                $cr = $v->details->sum('credit_amount');
                                $st = $v->entry_status ?? 'Draft';
                            @endphp

                            <tr>
                                <td class="fw-semibold text-primary">{{ $v->voucher_id }}</td>
                                <td>{{ $v->voucher_type }}</td>
                                <td>{{ $v->voucher_date }}</td>
                                <td>{{ $v->receive_pay_to }}</td>
                                <td>{{ $v->company->company_name ?? $v->company_id }}</td>
                                <td class="text-end">{{ number_format($dr, 2) }}</td>
                                <td class="text-end">{{ number_format($cr, 2) }}</td>
                                <td><span class="badge bg-secondary">{{ $st }}</span></td>
                                <td>{{ $v->PREPARED_BY }}</td>

                                <td>
                                    <a href="{{ route('vouchers.show', $v->voucher_id) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if ($v->IS_SUBMIT !== 'Y')
                                        <a href="{{ route('vouchers.edit', $v->voucher_id) }}"
                                            class="btn btn-outline-secondary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    No data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

@endsection


@push('scripts')
    <script>
        let currentStatus = '';

        function setTab(el, status) {
            currentStatus = status;

            document.querySelectorAll('#statusTabs .nav-link')
                .forEach(t => t.classList.remove('active'));

            el.classList.add('active');

            loadVouchers();
        }




        function loadVouchers(url = null) {

            let search = document.getElementById('searchBox')?.value || '';
            let from = document.querySelector('[name="s_from_date"]')?.value || '';
            let to = document.querySelector('[name="s_to_date"]')?.value || '';
            let type = document.querySelector('[name="voucher_type"]')?.value || '';
            let company = document.querySelector('[name="company_id"]')?.value || '';

            let fetchUrl = url ?? `{{ route('vouchers.ajax.list') }}?` +
                `status=${currentStatus}` +
                `&search=${encodeURIComponent(search)}` +
                `&s_from_date=${from}` +
                `&s_to_date=${to}` +
                `&voucher_type=${type}` +
                `&company_id=${company}`;

            document.getElementById('voucherTable').innerHTML =
                `<tr><td colspan="10" class="text-center">Loading...</td></tr>`;

            fetch(fetchUrl)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('voucherTable').innerHTML = html;
                });
        }





        document.getElementById('voucherTable').innerHTML =
            `<tr><td colspan="10" class="text-center">Loading...</td></tr>`;
        document.addEventListener("DOMContentLoaded", function() {
            loadVouchers(); // 👈 auto load when page opens
        });





        document.addEventListener("DOMContentLoaded", function() {

            // instant search
            let timer;
            document.getElementById('searchBox')?.addEventListener('keyup', function() {
                clearTimeout(timer);
                timer = setTimeout(() => loadVouchers(), 400);
            });

            // dropdowns + dates auto trigger
            document.querySelectorAll(
                    '[name="voucher_type"], [name="company_id"], [name="s_from_date"], [name="s_to_date"]')
                .forEach(el => {
                    el.addEventListener('change', () => loadVouchers());
                });

            // initial load
            loadVouchers();
        });





        document.addEventListener("click", function(e) {

            if (e.target.closest(".pagination a")) {
                e.preventDefault();

                let url = new URL(e.target.closest("a").href);

                // keep filters
                url.searchParams.set('status', currentStatus);
                url.searchParams.set('search', document.getElementById('searchBox').value);
                url.searchParams.set('voucher_type', document.querySelector('[name="voucher_type"]').value);
                url.searchParams.set('company_id', document.querySelector('[name="company_id"]').value);
                url.searchParams.set('s_from_date', document.querySelector('[name="s_from_date"]').value);
                url.searchParams.set('s_to_date', document.querySelector('[name="s_to_date"]').value);

                loadVouchers(url.toString());
            }

        });



        function loadStats() {
            fetch(`{{ route('vouchers.ajax.stats') }}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('mTotal').innerText = data.total;
                    document.getElementById('mPending').innerText = data.unapproved;
                });
        }

        // auto refresh every 10 sec
        setInterval(loadStats, 10000);

        let searchTimer;

        document.addEventListener("DOMContentLoaded", function() {

            const searchInput = document.getElementById('searchBox');

            searchInput.addEventListener('keyup', function() {

                clearTimeout(searchTimer);

                searchTimer = setTimeout(() => {
                    loadVouchers(); // 👈 AJAX call
                }, 400);

            });

        });



        function loadChart() {
            fetch(`{{ route('vouchers.ajax.chart') }}`)
                .then(res => res.json())
                .then(data => {

                    let labels = data.map(d => d.month);
                    let values = data.map(d => d.total);

                    new Chart(document.getElementById('voucherChart'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Vouchers',
                                data: values,
                                borderWidth: 2
                            }]
                        }
                    });
                });
        }

        loadChart();
    </script>
@endpush
