@php
    $isEdit = isset($master);
    $isView = isset($viewMode);
@endphp
@extends('item-received.layout')

@section('title', ($master ? 'Edit' : 'New') . ' — Item Received Entry')

@section('nav-title') {{ $master ? 'Edit Item Received Entry' : 'New Item Received Entry' }} @endsection
@section('nav-badge')
    @if ($master)
        <span class="badge bg-primary mono">{{ $master->RECEIVED_NO }}</span>
    @endif
@endsection

@section('nav-actions')
    <a href="{{ route('item-received.index') }}" class="btn btn-app-exit btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    @if ($master)
        <button type="button" class="btn btn-app-delete btn-sm">
            <i class="bi bi-trash me-1"></i> Delete Full
        </button>
        <button type="button" class="btn btn-outline-info">
            <i class="bi bi-search me-1"></i> Search
        </button>
        @if (isset($master) && $mode == 'view')
            <a href="{{ route('item-received.edit', $master->received_no_id) }}" class="btn btn-secondary">
                ✏️ Edit
            </a>
        @endif
        <button type="button" class="btn btn-app-summary btn-sm">
            <i class="bi bi-file-earmark-text me-1"></i> Summary
        </button>
    @endif
    @if ($mode == 'edit')
        <button type="submit" form="mainForm" class="btn btn-app-save btn-sm">
            <i class="bi bi-check-lg me-1"></i> Update
        </button>
    @else
        <button type="submit" form="mainForm" class="btn btn-app-save btn-sm">
            <i class="bi bi-check-lg me-1"></i> Save
        </button>
    @endif
    <a href="{{ route('item-received.index') }}" class="btn btn-app-exit btn-sm">
        <i class="bi bi-box-arrow-right me-1"></i> Exit
    </a>
@endsection

@section('content')
    @if ($master)
        <form id="mainForm" action="{{ route('item-received.update', $master->received_no_id) }}" method="POST">
            @method('PUT')
        @else
            <form id="mainForm" action="{{ route('item-received.store') }}" method="POST">
    @endif

    @csrf

    @if ($isEdit)
        @method('PUT')
    @endif

    {{-- ═══ MASTER ═══ --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-header-left">
                <i class="bi bi-clipboard-data text-secondary" style="font-size:13px;"></i>
                <span class="section-title">Purchase Order Master</span>
                <span class="section-badge">G_ITEM_RECEIVED_MASTER</span>
            </div>
            <div class="d-flex gap-2">
                <a href="#styleSection" class="btn btn-outline-secondary btn-sm">PO Entry ↓</a>
                <a href="#itemSection" class="btn btn-outline-secondary btn-sm">Item Entry ↓</a>
            </div>
        </div>

        <div class="fields-grid">
            <div>
                <label class="field-label">Received No (Auto)</label>
                <input id="RECEIVED_NO" name="RECEIVED_NO"
                    class="form-control mono"value="{{ old('received_no', $master ? $master->received_no : '') }}" readonly>
            </div>

            <div>
                <label class="field-label">Received ID (PK)</label>
                <input id="RECEIVED_NO_ID" name="RECEIVED_NO_ID" class="form-control mono"
                    value="{{ old('received_no_id', $master ? $master->received_no_id : '') }}" readonly>
            </div>
            <div>
                <label class="field-label">Received Date <span class="req">*</span></label>
                <input type="date" name="RECEIVED_DATE" class="form-control @error('RECEIVED_DATE') is-invalid @enderror"
                    value="{{ old('received_date', $master ? \Carbon\Carbon::parse($master->received_date)->format('Y-m-d') : '') }}"
                    required>
                @error('RECEIVED_DATE')
                    <div class="invalid-feedback" style="font-size:10px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="field-label">Supplier <span class="req">*</span></label>
                <div class="input-group">

                    <input type="text" id="supplier_name" class="form-control" placeholder="Select supplier..."
                        value="{{ old('supplier_name', $master ? $master->supplier_name : '') }}" readonly>

                    <input type="hidden" id="SUPPLIER_NO" name="SUPPLIER_ID"
                        value="{{ old('supplier_id', $master->supplier_id ?? '') }}">

                    <button type="button" class="btn btn-outline-secondary" onclick="openLov('supplier')">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                @error('SUPPLIER_ID')
                    <div class="invalid-feedback" style="font-size:10px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="field-label">Currency Rate</label>
                <input type="number" name="CURRENCY_RATE" class="form-control" value="{{ old('currency_rate', 1) }}"
                    step="0.0001">
            </div>

            <div>
                <label class="field-label">Payment Terms</label>
                <select name="PAYMENT_TERMS" class="form-select">
                    <option value="">— Select —</option>
                    <option value="NET30"
                        {{ old('PAYMENT_TERMS', $master->payment_terms ?? '') == 'NET30' ? 'selected' : '' }}>Net 30
                        Days</option>
                    <option value="NET60"
                        {{ old('PAYMENT_TERMS', $master->payment_terms ?? '') == 'NET60' ? 'selected' : '' }}>Net 60
                        Days</option>
                    <option value="COD"
                        {{ old('PAYMENT_TERMS', $master->payment_terms ?? '') == 'COD' ? 'selected' : '' }}>Cash on
                        Delivery</option>
                </select>
            </div>
            <div>
                <label class="field-label">Ordered By</label>
                <input type="text" name="ORDERED_BY" class="form-control"
                    value="{{ old('ORDERED_BY', $master->ordered_by ?? '') }}" placeholder="Employee name">
            </div>
            <div>
                <label class="field-label">Ref No</label>
                <input type="text" name="ORDER_NO_ID" class="form-control"
                    value="{{ old('ORDER_NO_ID', $master->order_no_id ?? '') }}" placeholder="Ref no">
            </div>
            <div>
                <label class="field-label">Requisition No</label>
                <input type="text" name="REQUISITION_NO" class="form-control"
                    value="{{ old('REQUISITION_NO', $master->requisition_no ?? '') }}">
            </div>
            <div>
                <label class="field-label">PO Type</label>
                <input type="text" name="PO_TYPE" class="form-control"
                    value="{{ old('PO_TYPE', $master->po_type ?? '') }}">
            </div>

            <div>
                <label class="field-label">PO Number</label>
                <div class="input-group">

                    <input type="text" id="FOUR_PO_NO" name="FOUR_PO_NO" class="form-control mono"
                        placeholder="Select PO" value="{{ $master->four_po_no ?? '' }}" readonly>

                    <button type="button" class="btn btn-outline-secondary"
                        onclick="loadPoList(document.getElementById('SUPPLIER_NO').value)">
                        🔍
                    </button>

                </div>
            </div>
            <div>
                <label class="field-label">Four PO No</label>
                <input type="text" id="FOUR_PO_ID" name="FOUR_PO_ID" class="form-control" readonly
                    value="{{ $master->four_po_id ?? '' }}">
            </div>
            <div>
                <label class="field-label">Supplier Challan No</label>
                <input type="text" name="SUPPLIER_CHALLAN_NO" class="form-control"
                    value="{{ old('SUPPLIER_CHALLAN_NO', $master->supplier_challan_no ?? '') }}"
                    placeholder="Challan number">
            </div>
            <div>
                <label class="field-label">Supplier Bill No</label>
                <input type="text" name="SUPP_BILL_NO" class="form-control"
                    value="{{ old('SUPP_BILL_NO', $master->supp_bill_no ?? '') }}">
            </div>
            <div>
                <label class="field-label">Client PI Number</label>
                <input type="text" name="CLIENT_PI_NUMBER" class="form-control"
                    value="{{ old('CLIENT_PI_NUMBER', $master->client_pi_number ?? '') }}">
            </div>

            <div class="span2">
                <label class="field-label">Remarks</label>
                <input type="text" name="REMARKS" class="form-control"
                    value="{{ old('REMARKS', $master->remarks ?? '') }}" placeholder="Remarks">
            </div>
        </div>
    </div>

    {{-- ═══ STYLE / ORDER LINES ═══ --}}
    <div class="section-card" id="styleSection">
        <div class="section-header">
            <div class="section-header-left">
                <i class="bi bi-arrow-repeat text-secondary" style="font-size:13px;"></i>
                <span class="section-title">PO Style / Order Lines</span>
                <span class="section-badge">G_ITEM_RECEIVED_STYLE</span>
            </div>
            <button type="button" class="btn btn-success btn-sm" onclick="addStyleRow()">
                <i class="bi bi-plus-lg me-1"></i> Add Row
            </button>
        </div>

        <div class="grid-table-wrap mt-2">
            <table class="grid-table">
                <thead>
                    <tr>
                        <th width="35">#</th>
                        <th>Purchase Order PK</th>
                        <th>PO Number <span class="text-primary" style="font-weight:400;font-size:9px;">LOV</span>
                        </th>
                        <th>PO Number ID</th>
                        <th>Style / Order No</th>
                        <th>Buyer Name <span class="text-success" style="font-weight:400;font-size:9px;">FORMULA</span>
                        </th>
                        <th>PO Qty</th>
                        <th width="35"></th>
                    </tr>
                </thead>
                <tbody id="styleBody">
                    @php $styleRows = old('styles', $styles->toArray()); @endphp
                    @forelse($styleRows as $i => $s)
                        <tr>
                            <td class="row-no">{{ $i + 1 }}</td>
                            <td><input type="text" name="styles[{{ $i }}][PUR_ORDER_PK]"
                                    class="td-input mono" value="{{ $s['purchase_order_pk'] ?? '' }}"></td>
                            <td><input type="text" name="styles[{{ $i }}][PO_NUMBER]"
                                    class="td-input mono" value="{{ $s['po_number'] ?? '' }}" placeholder="PO Number">
                            </td>
                            <td><input type="text" name="styles[{{ $i }}][PO_NUMBER_ID]"
                                    class="td-input mono" value="{{ $s['po_number_id'] ?? '' }}"></td>
                            <td><input type="text" name="styles[{{ $i }}][STYLE_NO]" class="td-input"
                                    value="{{ $s['style_no'] ?? '' }}" placeholder="Style / Order No"></td>
                            <td><input type="text" name="styles[{{ $i }}][BUYER_NAME]" class="td-input"
                                    value="{{ $s['buyer_name'] ?? '' }}" readonly
                                    style="background:#f8f9fa;color:#6c757d;"></td>
                            <td><input type="number" name="styles[{{ $i }}][PO_QTY]" class="td-input"
                                    value="{{ $s['po_qty'] ?? '' }}" placeholder="0" style="width:80px;"></td>
                            <td><button type="button" class="btn btn-outline-danger btn-xs"
                                    onclick="removeRow(this,'styleBody')"><i class="bi bi-trash"></i></button></td>
                        </tr>
                    @empty
                        <tr id="styleEmpty">
                            <td colspan="8" class="text-center text-muted py-3" style="font-size:12px;">No style
                                rows. Click "+ Add Row" to begin.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="add-row-wrap">
            <button type="button" class="add-row-btn" onclick="addStyleRow()">
                <i class="bi bi-plus-circle me-1"></i> New style row
            </button>
        </div>
    </div>

    {{-- ═══ ITEM DETAILS ═══ --}}
    <div class="section-card" id="itemSection">
        <div class="section-header">
            <div class="section-header-left">
                <i class="bi bi-boxes text-secondary" style="font-size:13px;"></i>
                <span class="section-title">Item Details</span>
                <span class="section-badge">G_ITEM_RECEIVED_DETAILS</span>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-file-earmark-excel me-1"></i> Import Excel
                </button>
                <button type="button" class="btn btn-success btn-sm" onclick="addDetailRow()">
                    <i class="bi bi-plus-lg me-1"></i> Add Item
                </button>
            </div>
        </div>

        <div class="grid-table-wrap mt-2">
            <table class="grid-table">
                <thead>
                    <tr>
                        <th width="30">SL</th>
                        <th>Pur Order PK</th>
                        <th>PO No ID</th>
                        <th>Item ID <span class="text-primary" style="font-weight:400;font-size:9px;">LOV</span></th>
                        <th>Item Name <span class="text-success" style="font-weight:400;font-size:9px;">FORMULA</span>
                        </th>
                        <th>Unit</th>
                        <th>PUR Qty</th>
                        <th>Qty</th>
                        <th>%</th>
                        <th>Rate</th>
                        <th>Curr.</th>
                        <th>Value</th>
                        <th>Remarks</th>
                        <th width="35"></th>
                    </tr>
                </thead>
                <tbody id="detailBody">

                    @php
                        $detailRows = old('details', isset($details) ? $details->toArray() : []);
                        $isView = isset($viewMode);
                    @endphp

                    @forelse($detailRows as $i => $d)
                        <tr>

                            <td class="row-no">{{ $i + 1 }}</td>

                            <td>
                                <input type="text" name="details[{{ $i }}][PUR_ORDER_PK]"
                                    class="td-input mono" value="{{ $d['pur_order_pk'] ?? ($d->pur_order_pk ?? '') }}"
                                    style="width:85px;" {{ $isView ? 'readonly' : '' }}>
                            </td>

                            <td>
                                <input type="text" name="details[{{ $i }}][PO_NUMBER_ID]"
                                    class="td-input mono" value="{{ $d['po_number_id'] ?? ($d->po_number_id ?? '') }}"
                                    style="width:85px;" {{ $isView ? 'readonly' : '' }}>
                            </td>

                            <td>
                                <input type="text" name="details[{{ $i }}][ITEM_NO]" class="td-input mono"
                                    value="{{ $d['item_no'] ?? ($d->item_no ?? '') }}" placeholder="Item ID"
                                    style="width:80px;" required {{ $isView ? 'readonly' : '' }}>
                            </td>

                            <td>
                                <input type="text" name="details[{{ $i }}][ITEM_NAME]" class="td-input"
                                    value="{{ $d['item_name'] ?? ($d->item_name ?? '') }}" placeholder="Item name"
                                    style="width:130px; background:#f8f9fa;" readonly>
                            </td>

                            <td>
                                <input type="text" name="details[{{ $i }}][ITEM_UNIT]" class="td-input"
                                    value="{{ $d['item_unit'] ?? ($d->item_unit ?? '') }}" placeholder="Unit"
                                    style="width:55px;" {{ $isView ? 'readonly' : '' }}>
                            </td>

                            <td>
                                <input type="number" name="details[{{ $i }}][PUR_QTY]"
                                    class="td-input qty-input" value="{{ $d['pur_qty'] ?? ($d->pur_qty ?? '') }}"
                                    placeholder="0" style="width:70px;" step="0.01" min="0"
                                    oninput="updateTotal()" {{ $isView ? 'readonly' : '' }}>
                            </td>

                            <td>
                                <input type="number" name="details[{{ $i }}][ITEM_QTY]"
                                    class="td-input qty-input" value="{{ $d['item_qty'] ?? ($d->item_qty ?? '') }}"
                                    placeholder="0" style="width:70px;" step="0.01" min="0"
                                    oninput="updateTotal()" {{ $isView ? 'readonly' : '' }}>
                            </td>

                            <td>
                                <input type="number" name="details[{{ $i }}][PERCENTAGE]" class="td-input"
                                    value="{{ $d['percentage'] ?? ($d->percentage ?? '') }}" placeholder="0"
                                    style="width:55px;" step="0.01" {{ $isView ? 'readonly' : '' }}>
                            </td>

                            <td>
                                <input type="number" name="details[{{ $i }}][RATE]" class="td-input"
                                    value="{{ $d['rate'] ?? ($d->rate ?? '') }}" placeholder="0.00" style="width:70px;"
                                    step="0.01" oninput="updateValue(this)" {{ $isView ? 'readonly' : '' }}>
                            </td>

                            <td>
                                <input type="text" name="details[{{ $i }}][CURR]" class="td-input mono"
                                    value="{{ $d['curr'] ?? ($d->curr ?? 'USD') }}" style="width:48px;"
                                    {{ $isView ? 'readonly' : '' }}>
                            </td>

                            <td>
                                <input type="number" name="details[{{ $i }}][VALUE]"
                                    class="td-input value-input" value="{{ $d['value'] ?? ($d->value ?? '') }}"
                                    placeholder="0.00" style="width:80px; background:#f8f9fa;" step="0.01" readonly>
                            </td>

                            <td>
                                <input type="text" name="details[{{ $i }}][ITEM_REMARKS]" class="td-input"
                                    value="{{ $d['item_remarks'] ?? ($d->item_remarks ?? '') }}" placeholder="Remarks"
                                    style="width:100px;" {{ $isView ? 'readonly' : '' }}>
                            </td>

                            <td>
                                @if (!$isView)
                                    <button type="button" class="btn btn-outline-danger btn-xs"
                                        onclick="removeRow(this,'detailBody')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr id="detailEmpty">
                            <td colspan="14" class="text-center text-muted py-3">
                                No items. Click "+ Add Item" to begin.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="text-end text-muted"
                            style="font-size:10px;text-transform:uppercase;letter-spacing:.04em;">Total</td>
                        <td><span class="total-val" id="totalQty">0.00</span></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><span class="total-val" id="totalValue">0.00</span></td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="add-row-wrap">
            <button type="button" class="add-row-btn" onclick="addDetailRow()">
                <i class="bi bi-plus-circle me-1"></i> New item row
            </button>
        </div>
    </div>

    </form>



    <!-- MODAL LOV for Supplier Selection -->


    <div class="modal fade" id="lovModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h6 id="lovTitle">LOV</h6>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="text" id="lovSearch" class="form-control mb-2" placeholder="Filter...">

                    <div id="lovList"></div>

                </div>

            </div>
        </div>
    </div>




@endsection

@section('scripts')
    <script>
        let lovType = '';
        let lovIdx = null;
        let activeStyleId = null;
        // =========================
        // MODAL INSTANCE
        // =========================
        let lovModalInstance = null;





        function updateTotal() {

            let totalQty = 0;
            let totalValue = 0;

            // Sum quantities
            document.querySelectorAll('.qty-input').forEach(input => {
                totalQty += parseFloat(input.value) || 0;
            });

            // Sum values
            document.querySelectorAll('.value-input').forEach(input => {
                totalValue += parseFloat(input.value) || 0;
            });

            // Update footer
            document.getElementById('totalQty').innerText = totalQty.toFixed(2);
            document.getElementById('totalValue').innerText = totalValue.toFixed(2);
        }


        function updateValue(el) {

            const row = el.closest('tr');

            const qty = parseFloat(row.querySelector('[name*="[ITEM_QTY]"]').value) || 0;
            const rate = parseFloat(row.querySelector('[name*="[RATE]"]').value) || 0;

            const value = qty * rate;

            const valueField = row.querySelector('[name*="[VALUE]"]');

            if (valueField) {
                valueField.value = value.toFixed(2);
            }

            updateTotal(); // recalc total
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateTotal();
        });


        function getModal() {

            const el = document.getElementById('lovModal');

            if (!lovModalInstance) {
                lovModalInstance = new bootstrap.Modal(el);
            }

            return lovModalInstance;
        }

        // =========================
        // OPEN LOV
        // =========================
        function openLov(type, idx = null) {

            lovType = type;
            lovIdx = idx;

            document.getElementById('lovTitle').textContent = type.toUpperCase();
            document.getElementById('lovSearch').value = '';

            loadLov('');

            getModal().show();

            setTimeout(() => {
                document.getElementById('lovSearch').focus();
            }, 200);
        }

        // =========================
        // LOAD LOV (DB SEARCH)
        // =========================
        function loadLov(keyword = '') {

            const list = document.getElementById('lovList');
            list.innerHTML = 'Loading...';

            const urlMap = {
                supplier: `/item-received/lov/suppliers?q=${keyword}`,
                item: `/item-received/lov/items?q=${keyword}`,
            };

            fetch(urlMap[lovType])
                .then(r => r.json())
                .then(data => {

                    list.innerHTML = '';

                    if (!data.length) {
                        list.innerHTML = '<div class="p-2 text-muted">No Data</div>';
                        return;
                    }

                    data.forEach(row => {

                        const div = document.createElement('div');
                        div.className = 'lov-row';

                        // ===== SUPPLIER =====
                        if (lovType === 'supplier') {

                            div.innerHTML = `
            <div class="lov-id">${row.party_id}</div>
            <div>${row.party_name}</div>
          `;

                            div.onclick = () => {

                                const supplierId = row.party_id;

                                console.log('Supplier selected:', supplierId); // 🔍 debug

                                document.getElementById('SUPPLIER_NO').value = supplierId;
                                document.getElementById('supplier_name').value = row.party_name;

                                // ✅ CLOSE MODAL
                                getModal().hide();

                                // ✅ GUARANTEED CALL
                                setTimeout(() => {
                                    console.log('Calling loadPoList...'); // 🔍 debug
                                    loadPoList(supplierId);
                                }, 300); // ⬅️ IMPORTANT: 300ms (not 150)
                            };
                        }

                        // ===== ITEM =====
                        if (lovType === 'item') {

                            div.innerHTML = `
            <div class="lov-id">${row.item_id}</div>
            <div>${row.item_name}</div>
            <div>${row.unit || ''}</div>
          `;

                            div.onclick = () => {

                                document.getElementById(`dr${lovIdx}_item`).value = row.item_id;
                                document.getElementById(`dr${lovIdx}_name`).value = row.item_name;
                                document.getElementById(`dr${lovIdx}_unit`).value = row.unit || '';

                                getModal().hide();
                            };
                        }

                        list.appendChild(div);
                    });

                });
        }

        // =========================
        // SEARCH (DB BASED)
        // =========================
        document.getElementById('lovSearch').addEventListener('input', function() {

            if (lovType === 'supplier' || lovType === 'item') {
                loadLov(this.value);
            }

            if (lovType === 'po') {
                const supplierId = document.getElementById('SUPPLIER_NO').value;
                loadPoLov(supplierId, this.value);
            }
        });

        // =========================
        // LOAD PO LOV
        // =========================
        function loadPoList(supplierId) {

            if (!supplierId) {
                alert('Select supplier first');
                return;
            }

            lovType = 'po';

            document.getElementById('lovTitle').textContent = 'PO LIST';
            document.getElementById('lovSearch').value = '';

            loadPoLov(supplierId, '');

            getModal().show();
        }

        // =========================
        // LOAD PO DATA FROM DB
        // =========================
        function loadPoLov(supplierId, keyword = '') {

            const list = document.getElementById('lovList');
            list.innerHTML = 'Loading...';

            fetch(`/item-received/lov/po-by-supplier/${supplierId}?q=${keyword}`)
                .then(r => r.json())
                .then(data => {

                    list.innerHTML = '';

                    if (!data.length) {
                        list.innerHTML = '<div class="p-2 text-muted">No PO Found</div>';
                        return;
                    }

                    data.forEach(row => {

                        const div = document.createElement('div');
                        div.className = 'lov-row';

                        div.innerHTML = `
          <div class="lov-id">${row.pur_order_pk}</div>
          <div>${row.po_number}</div>
          <div>${row.buyer_name || ''}</div>
        `;

                        div.onclick = () => {

                            document.getElementById('FOUR_PO_ID').value = row.pur_order_pk;
                            document.getElementById('FOUR_PO_NO').value = row.po_number;

                            loadPoData(row.pur_order_pk);

                            getModal().hide();
                        };

                        list.appendChild(div);
                    });

                });
        }

        // =========================
        // LOAD PO FULL DATA
        // =========================
        async function loadPoData(pk) {

            const res = await fetch(`/item-received/po-full/${pk}`);
            const data = await res.json();

            const styleBody = document.getElementById('styleBody');
            const detailBody = document.getElementById('detailBody');

            styleBody.innerHTML = '';
            detailBody.innerHTML = '';

            let grouped = {};

            data.forEach(row => {

                const key = row.po_number_id;

                if (!grouped[key]) {
                    grouped[key] = {
                        style: row,
                        details: []
                    };
                }

                grouped[key].details.push(row);
            });

            let si = 0;
            let di = 0;

            Object.values(grouped).forEach(group => {

                const s = group.style;

                const tr = document.createElement('tr');

                tr.innerHTML = `
      <td>${++si}</td>
      <td><input name="styles[${si}][PUR_ORDER_PK]" value="${s.pur_order_pk || ''}"></td>
      <td><input name="styles[${si}][PO_NUMBER]" value="${s.po_number || ''}"></td>
      <td><input name="styles[${si}][PO_NUMBER_ID]" value="${s.po_number_id || ''}"></td>
      <td><input name="styles[${si}][STYLE_NO]" value="${s.order_no || ''}"></td>
      <td><input value="${s.buyer_name || '-'}" readonly></td>
      <td><input value="${s.po_qty || ''}"></td>
    `;

                styleBody.appendChild(tr);

                group.details.forEach(d => {

                    const tr2 = document.createElement('tr');

                    tr2.innerHTML = `
        <td>${++di}</td>
       
  <td><input name="details[${di}][PUR_ORDER_PK]" value="${d.pur_order_pk || ''}"></td>

  <td><input name="details[${di}][PO_NUMBER_ID]" value="${d.po_number_id || ''}"></td>

  <td><input name="details[${di}][ITEM_NO]" value="${d.item_id || ''}"></td>

  <td><input name="details[${di}][ITEM_NAME]" value="${d.item_name || ''}" readonly></td>

  <td><input name="details[${di}][ITEM_UNIT]" value="${d.itm_unit || ''}"></td>

  <td><input name="details[${di}][PUR_QTY]" value="${d.quantity || 0}"></td>

  <td><input name="details[${di}][ITEM_QTY]" value="${d.quantity || 0}"></td>

  <td><input name="details[${di}][RATE]" value="${d.item_rate || ''}"></td>

  <td><input name="details[${di}][VALUE]" value="${d.value || ''}" readonly></td>
      `;

                    detailBody.appendChild(tr2);
                });

            });
            setTimeout(() => {
                attachStyleEvents();
                autoSelectFirstStyle();
            }, 100);

        }

        function attachStyleEvents() {

            document.querySelectorAll('#styleBody tr').forEach(tr => {

                const styleIdInput = tr.querySelector('[name*="[PO_NUMBER_ID]"]');
                if (!styleIdInput) return;

                const styleId = styleIdInput.value;

                tr.setAttribute('data-style-id', styleId);

                tr.onclick = function() {

                    activeStyleId = styleId;

                    // highlight
                    document.querySelectorAll('#styleBody tr').forEach(r => r.classList.remove('active'));
                    this.classList.add('active');

                    // filter details
                    filterDetails(styleId);
                };
            });

        }

        function filterDetails(styleId) {

            document.querySelectorAll('#detailBody tr').forEach(row => {

                const input = row.querySelector('[name*="[PO_NUMBER_ID]"]');
                if (!input) return;

                const rowStyleId = input.value;

                row.style.display = (rowStyleId === styleId) ? '' : 'none';
            });

        }

        function autoSelectFirstStyle() {

            const first = document.querySelector('#styleBody tr');

            if (first) {
                first.click();
            }
        }

        function addDetailRow() {

            if (!activeStyleId) {
                alert('Select a style first');
                return;
            }

            const tbody = document.getElementById('detailBody');
            const index = tbody.querySelectorAll('tr').length + 1;

            const tr = document.createElement('tr');

            tr.innerHTML = `
    <td>${index}</td>

    <td><input name="details[${index}][PUR_ORDER_PK]"></td>

    <td>
      <input name="details[${index}][PO_NUMBER_ID]" value="${activeStyleId}">
    </td>

    <td>
      <input name="details[${index}][ITEM_NO]" onclick="openLov('item', ${index})">
    </td>

    <td><input name="details[${index}][ITEM_NAME]" readonly></td>

    <td><input name="details[${index}][ITEM_UNIT]"></td>

    <td><input name="details[${index}][PUR_QTY]"></td>

    <td><input name="details[${index}][ITEM_QTY]"></td>

    <td><input name="details[${index}][RATE]"></td>

    <td><input name="details[${index}][VALUE]" readonly></td>
  `;

            tbody.appendChild(tr);

            // keep filter active
            filterDetails(activeStyleId);
        }


        // =========================
        // GENERATE PK
        // =========================
        document.querySelector('[name="RECEIVED_DATE"]').addEventListener('change', async function() {

            const date = this.value;
            if (!date) return;

            const res = await fetch(`/item-received/generate-pk?date=${date}`);
            const data = await res.json();

            document.getElementById('RECEIVED_NO_ID').value = data.id || '';
            document.getElementById('RECEIVED_NO').value = data.no || '';
        });
    </script>
    @if ($isView)
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                document.querySelectorAll('input, select, textarea').forEach(el => {
                    el.setAttribute('readonly', true);
                });

                document.querySelectorAll('button').forEach(btn => {
                    btn.disabled = true;
                });

            });
        </script>
    @endif
@endsection
