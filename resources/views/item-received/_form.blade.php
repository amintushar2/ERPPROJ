{{--
    Shared form partial for Create & Edit.
    Variables expected:
      $master    – ItemReceivedMaster|null  (null on create)
      $suppliers – Collection of supplier rows
      $formAction – string  (route URL)
      $formMethod – 'POST'|'PUT'
      $pageTitle  – string
--}}
@extends('item-received.layout')
@section('title', $pageTitle)

@section('content')
<form id="grnForm" method="POST" action="{{ $formAction }}">
    @csrf
    @if($formMethod === 'PUT')
        @method('PUT')
    @endif

    {{-- ══════════════════════════════════════════
         TOP BAR
    ══════════════════════════════════════════ --}}
    <div class="top-bar">
        <i class="fa-solid fa-clipboard-list page-icon"></i>
        <h1>Item Received Entry</h1>
        <span class="breadcrumb">grn_entry.fmb → Laravel</span>
        <span class="canvas-badge">CANVAS_MAIN</span>
        <div class="top-bar-actions">
            @if($master)
            <button type="button" class="btn btn-danger" onclick="deleteGrn()">
                <i class="fa-solid fa-trash"></i> Delete Full GRN
            </button>
            @endif
            <a href="{{ route('item-received.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-magnifying-glass"></i> Search
            </a>
            <button type="button" class="btn btn-warning" onclick="checkGrn()">
                <i class="fa-solid fa-circle-check"></i> GRN Check
            </button>
            <button type="button" class="btn btn-info" onclick="summary()">
                <i class="fa-solid fa-file-lines"></i> Summary
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Save
            </button>
            <a href="{{ route('item-received.index') }}" class="btn btn-outline">
                <i class="fa-solid fa-right-from-bracket"></i> Exit
            </a>
        </div>
    </div>

    <div class="page-body">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger"><i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fa-solid fa-circle-xmark"></i>
                <div>
                    @foreach($errors->all() as $e)
                        <div>{{ $e }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ══════════════════════════════════════════
             SECTION 1 – GRN MASTER
        ══════════════════════════════════════════ --}}
        <div class="section-card">
            <div class="section-header">
                <i class="fa-solid fa-rectangle-list sec-icon"></i>
                <span class="sec-title">Item Received Master</span>
                <span class="sec-tag">G_ITEM_RECEIVED_MASTER</span>
                <div class="section-actions">
                    <button type="button" class="btn btn-outline btn-sm">
                        <i class="fa-solid fa-arrow-down"></i> GRN Entry
                    </button>
                    <button type="button" class="btn btn-outline btn-sm">
                        <i class="fa-solid fa-arrow-down"></i> Item Entry
                    </button>
                </div>
            </div>
            <div class="section-body">
                <div class="form-grid form-grid-6">

                    {{-- Row 1 --}}
                    <div class="form-group">
                        <label>Received No <span class="sub-label">(auto)</span></label>
                        <input type="text" class="form-control auto-field"
                               value="{{ $master->RECEIVED_NO ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Received Date <span class="required">*</span></label>
                        <input type="date" name="RECEIVED_DATE" class="form-control"
                               value="{{ old('RECEIVED_DATE', $master->RECEIVED_DATE ? \Carbon\Carbon::parse($master->RECEIVED_DATE)->format('Y-m-d') : '') }}"
                               required>
                    </div>
                    <div class="form-group" style="grid-column: span 2">
                        <label>Supplier <span class="required">*</span></label>
                        <div class="input-group">
                            <select name="SUPPLIER_ID" id="supplierId" class="form-control" required>
                                <option value="">— Select supplier —</option>
                                @foreach($suppliers as $sup)
                                    <option value="{{ $sup->SUPPLIER_ID }}"
                                        {{ old('SUPPLIER_ID', $master->SUPPLIER_ID ?? '') == $sup->SUPPLIER_ID ? 'selected' : '' }}>
                                        {{ $sup->SUPPLIER_NAME }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn-input-action" title="Search supplier">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Supplier Challan No</label>
                        <input type="text" name="SUPPLIER_CHALLAN_NO" class="form-control"
                               value="{{ old('SUPPLIER_CHALLAN_NO', $master->SUPPLIER_CHALLAN_NO ?? '') }}"
                               placeholder="Challan no...">
                    </div>
                    <div class="form-group">
                        <label>Supplier Bill No</label>
                        <input type="text" name="SUPP_BILL_NO" class="form-control"
                               value="{{ old('SUPP_BILL_NO', $master->SUPP_BILL_NO ?? '') }}"
                               placeholder="Bill no...">
                    </div>

                    {{-- Row 2 --}}
                    <div class="form-group">
                        <label>PO Number</label>
                        <input type="text" name="PO_NUMBER" id="poNumber" class="form-control"
                               value="{{ old('PO_NUMBER', $master->PO_NUMBER ?? '') }}"
                               placeholder="PO number...">
                    </div>
                    <div class="form-group">
                        <label>Order No ID</label>
                        <input type="text" name="ORDER_NO_ID" class="form-control"
                               value="{{ old('ORDER_NO_ID', $master->ORDER_NO_ID ?? '') }}"
                               placeholder="Order No ID...">
                    </div>
                    <div class="form-group">
                        <label>4-PO No</label>
                        <input type="text" name="FOUR_PO_NO" class="form-control"
                               value="{{ old('FOUR_PO_NO', $master->FOUR_PO_NO ?? '') }}"
                               placeholder="Four PO no...">
                    </div>
                    <div class="form-group">
                        <label>4-PO ID</label>
                        <input type="text" name="FOUR_PO_ID" class="form-control"
                               value="{{ old('FOUR_PO_ID', $master->FOUR_PO_ID ?? '') }}"
                               placeholder="Four PO ID...">
                    </div>
                    <div class="form-group">
                        <label>Client PI Number</label>
                        <input type="text" name="CLIENT_PI_NUMBER" class="form-control"
                               value="{{ old('CLIENT_PI_NUMBER', $master->CLIENT_PI_NUMBER ?? '') }}"
                               placeholder="PI number...">
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <input type="text" name="REMARKS" class="form-control"
                               value="{{ old('REMARKS', $master->REMARKS ?? '') }}"
                               placeholder="Remarks...">
                    </div>

                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             SECTION 2 – STYLE / ORDER LINES
        ══════════════════════════════════════════ --}}
        <div class="section-card">
            <div class="section-header">
                <i class="fa-solid fa-arrows-rotate sec-icon"></i>
                <span class="sec-title">Style / Order Lines</span>
                <span class="sec-tag">G_ITEM_RECEIVED_STYLE</span>
                <div class="section-actions">
                    <button type="button" class="btn btn-success btn-sm" onclick="addStyleRow()">
                        <i class="fa-solid fa-plus"></i> Add Row
                    </button>
                </div>
            </div>
            <div style="overflow-x:auto">
                <table class="grid-table" id="styleTable">
                    <thead>
                        <tr>
                            <th class="td-seq">#</th>
                            <th>PO Number</th>
                            <th>Style No</th>
                            <th>Order No</th>
                            <th>Order No ID</th>
                            <th class="td-actions"></th>
                        </tr>
                    </thead>
                    <tbody id="styleBody">
                        @php $styles = $master ? $master->styles : collect() @endphp
                        @if($styles->count())
                            @foreach($styles as $i => $s)
                            <tr data-style-row>
                                <td class="td-seq">{{ $i+1 }}</td>
                                <td><input type="text" name="styles[{{ $i }}][PO_NUMBER]"
                                           class="form-control" value="{{ $s->PO_NUMBER }}"></td>
                                <td><input type="text" name="styles[{{ $i }}][STYLE_NO]"
                                           class="form-control" value="{{ $s->STYLE_NO }}" required></td>
                                <td><input type="text" name="styles[{{ $i }}][ORDER_NO]"
                                           class="form-control" value="{{ $s->ORDER_NO }}"></td>
                                <td><input type="text" name="styles[{{ $i }}][ORDER_NO_ID]"
                                           class="form-control" value="{{ $s->ORDER_NO_ID }}"></td>
                                <td class="td-actions">
                                    <button type="button" class="btn btn-danger btn-sm btn-icon-only"
                                            onclick="removeRow(this)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div style="text-align:center;padding:14px" id="styleEmptyMsg"
                     style="{{ ($styles->count() ? 'display:none' : '') }}">
                    <button type="button" class="btn btn-outline btn-sm" onclick="addStyleRow()">
                        <i class="fa-solid fa-plus"></i> New style row
                    </button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             SECTION 3 – ITEM DETAILS
        ══════════════════════════════════════════ --}}
        <div class="section-card">
            <div class="section-header">
                <i class="fa-solid fa-list-ul sec-icon"></i>
                <span class="sec-title">Item Details</span>
                <span class="sec-tag">G_ITEM_RECEIVED_DETAILS</span>
                <div class="section-actions">
                    <button type="button" class="btn btn-outline btn-sm">
                        <i class="fa-solid fa-file-excel"></i> Import Excel
                    </button>
                    <button type="button" class="btn btn-success btn-sm" onclick="addItemRow()">
                        <i class="fa-solid fa-plus"></i> Add Item
                    </button>
                </div>
            </div>
            <div style="overflow-x:auto">
                <table class="grid-table" id="itemTable">
                    <thead>
                        <tr>
                            <th class="td-seq">SL</th>
                            <th>Item No <span class="col-badge">LOV</span></th>
                            <th>Item Name <span class="col-badge">FORMULA</span></th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>%</th>
                            <th>Pur Qty</th>
                            <th>Prev. Recv</th>
                            <th>PO Number</th>
                            <th>PO No ID</th>
                            <th>Remarks</th>
                            <th class="td-actions"></th>
                        </tr>
                    </thead>
                    <tbody id="itemBody">
                        @php $details = $master ? $master->details : collect() @endphp
                        @foreach($details as $i => $d)
                        <tr data-item-row>
                            <td class="td-seq row-num">{{ $i+1 }}</td>
                            <td><input type="text" name="details[{{ $i }}][ITEM_NO]"
                                       class="form-control item-no" value="{{ $d->ITEM_NO }}" required style="min-width:90px"></td>
                            <td><input type="text" class="form-control item-name-display"
                                       placeholder="Auto-populated" readonly style="min-width:120px;background:#F8FAFC"></td>
                            <td><input type="text" name="details[{{ $i }}][ITEM_UNIT]"
                                       class="form-control" value="{{ $d->ITEM_UNIT }}" required style="width:70px"></td>
                            <td><input type="number" name="details[{{ $i }}][ITEM_QTY]"
                                       class="form-control item-qty td-num" value="{{ $d->ITEM_QTY }}"
                                       step="0.001" min="0" required style="width:80px"
                                       oninput="updateTotal()"></td>
                            <td><input type="number" name="details[{{ $i }}][PERCENTAGE]"
                                       class="form-control" value="{{ $d->PERCENTAGE }}"
                                       step="0.01" style="width:60px"></td>
                            <td><input type="number" name="details[{{ $i }}][PUR_QTY]"
                                       class="form-control" value="{{ $d->PUR_QTY }}"
                                       step="0.001" style="width:80px"></td>
                            <td><input type="number" name="details[{{ $i }}][PREVIOUS_RECEIVED]"
                                       class="form-control" value="{{ $d->PREVIOUS_RECEIVED }}"
                                       step="0.001" style="width:80px"></td>
                            <td><input type="text" name="details[{{ $i }}][PO_NUMBER]"
                                       class="form-control" value="{{ $d->PO_NUMBER }}" style="min-width:90px"></td>
                            <td><input type="text" name="details[{{ $i }}][PO_NUMBER_ID]"
                                       class="form-control" value="{{ $d->PO_NUMBER_ID }}" style="min-width:90px"></td>
                            <td><input type="text" name="details[{{ $i }}][ITEM_REMARKS]"
                                       class="form-control" value="{{ $d->ITEM_REMARKS }}" style="min-width:100px"></td>
                            <td class="td-actions">
                                <button type="button" class="btn btn-danger btn-sm btn-icon-only"
                                        onclick="removeRow(this)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right fw-bold" style="padding-right:12px">TOTAL</td>
                            <td class="td-num total-value" id="grandTotal">
                                {{ number_format($details->sum('ITEM_QTY'), 3) }}
                            </td>
                            <td colspan="7"></td>
                        </tr>
                    </tfoot>
                </table>
                <div style="text-align:center;padding:14px">
                    <button type="button" class="btn btn-outline btn-sm" onclick="addItemRow()">
                        <i class="fa-solid fa-plus"></i> New item row
                    </button>
                </div>
            </div>
        </div>

    </div>
</form>

{{-- Hidden delete form --}}
@if($master)
<form id="deleteForm" method="POST"
      action="{{ route('item-received.destroy', $master->RECEIVED_NO_ID) }}" style="display:none">
    @csrf @method('DELETE')
</form>
@endif

@push('scripts')
<script>
// ── Row counters ──
let styleIdx = {{ $master ? $master->styles->count() : 0 }};
let itemIdx  = {{ $master ? $master->details->count() : 0 }};

// ── Style rows ──
function addStyleRow() {
    const i = styleIdx++;
    const tr = document.createElement('tr');
    tr.setAttribute('data-style-row', '');
    tr.innerHTML = `
        <td class="td-seq">${document.querySelectorAll('[data-style-row]').length + 1}</td>
        <td><input type="text" name="styles[${i}][PO_NUMBER]"  class="form-control" placeholder="PO number"></td>
        <td><input type="text" name="styles[${i}][STYLE_NO]"   class="form-control" placeholder="Style no" required></td>
        <td><input type="text" name="styles[${i}][ORDER_NO]"   class="form-control" placeholder="Order no"></td>
        <td><input type="text" name="styles[${i}][ORDER_NO_ID]" class="form-control" placeholder="Order no ID"></td>
        <td class="td-actions">
            <button type="button" class="btn btn-danger btn-sm btn-icon-only" onclick="removeRow(this)">
                <i class="fa-solid fa-trash"></i>
            </button>
        </td>`;
    document.getElementById('styleBody').appendChild(tr);
    reindexSeq('[data-style-row]');
    document.getElementById('styleEmptyMsg').style.display = 'none';
}

// ── Item rows ──
function addItemRow() {
    const i = itemIdx++;
    const tr = document.createElement('tr');
    tr.setAttribute('data-item-row', '');
    tr.innerHTML = `
        <td class="td-seq row-num">${document.querySelectorAll('[data-item-row]').length + 1}</td>
        <td><input type="text" name="details[${i}][ITEM_NO]" class="form-control item-no" placeholder="Item no" required style="min-width:90px"></td>
        <td><input type="text" class="form-control item-name-display" placeholder="Auto-populated" readonly style="min-width:120px;background:#F8FAFC"></td>
        <td><input type="text" name="details[${i}][ITEM_UNIT]" class="form-control" placeholder="Unit" required style="width:70px"></td>
        <td><input type="number" name="details[${i}][ITEM_QTY]" class="form-control item-qty td-num"
                   placeholder="0.000" step="0.001" min="0" required style="width:80px" oninput="updateTotal()"></td>
        <td><input type="number" name="details[${i}][PERCENTAGE]" class="form-control" placeholder="%" step="0.01" style="width:60px"></td>
        <td><input type="number" name="details[${i}][PUR_QTY]" class="form-control" placeholder="0.000" step="0.001" style="width:80px"></td>
        <td><input type="number" name="details[${i}][PREVIOUS_RECEIVED]" class="form-control" placeholder="0.000" step="0.001" style="width:80px"></td>
        <td><input type="text" name="details[${i}][PO_NUMBER]" class="form-control" placeholder="PO number" style="min-width:90px"></td>
        <td><input type="text" name="details[${i}][PO_NUMBER_ID]" class="form-control" placeholder="PO No ID" style="min-width:90px"></td>
        <td><input type="text" name="details[${i}][ITEM_REMARKS]" class="form-control" placeholder="Remarks" style="min-width:100px"></td>
        <td class="td-actions">
            <button type="button" class="btn btn-danger btn-sm btn-icon-only" onclick="removeRow(this)">
                <i class="fa-solid fa-trash"></i>
            </button>
        </td>`;
    document.getElementById('itemBody').appendChild(tr);
    reindexSeq('[data-item-row]');
    // Focus first input
    tr.querySelector('input').focus();
}

function removeRow(btn) {
    const tr = btn.closest('tr');
    const isStyle = tr.hasAttribute('data-style-row');
    tr.remove();
    reindexSeq(isStyle ? '[data-style-row]' : '[data-item-row]');
    if (isStyle && !document.querySelectorAll('[data-style-row]').length) {
        document.getElementById('styleEmptyMsg').style.display = '';
    }
    if (!isStyle) updateTotal();
}

function reindexSeq(selector) {
    document.querySelectorAll(selector).forEach((tr, i) => {
        const numEl = tr.querySelector('.td-seq, .row-num');
        if (numEl) numEl.textContent = i + 1;
    });
}

// ── Grand total ──
function updateTotal() {
    let total = 0;
    document.querySelectorAll('.item-qty').forEach(inp => {
        total += parseFloat(inp.value) || 0;
    });
    document.getElementById('grandTotal').textContent = total.toFixed(3);
}

// ── Actions ──
function deleteGrn() {
    if (confirm('Delete this full GRN? All styles and item details will be removed. This cannot be undone.')) {
        document.getElementById('deleteForm').submit();
    }
}
function checkGrn()  { alert('GRN Check: validation feature – implement as needed.'); }
function summary()   { alert('Summary: reporting feature – implement as needed.'); }

// Initial total
updateTotal();
</script>
@endpush
@endsection
