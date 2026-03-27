@extends('layouts.purchase')

@section('title', 'Purchase Order Entry')

@section('content')

{{-- ── Search Bar ── --}}
<div id="searchBar" class="alert alert-light border mb-3 py-2">
  <div class="row g-2 align-items-end">
    <div class="col">
      <label class="form-label">
        Search PO Number
        <small class="text-muted fw-normal text-lowercase">(WHERE PUR_ORDER_PK LIKE '%...%')</small>
      </label>
      <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="PU-102023...">
    </div>
    <div class="col-auto d-flex gap-2">
      <button class="btn btn-primary btn-sm" onclick="doSearch()">
        <i class="bi bi-search me-1"></i>Execute Query
      </button>
      <button class="btn btn-outline-secondary btn-sm" onclick="toggleSearch()">Cancel</button>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════
     MASTER BLOCK — PUR_ORDER_MASTER
══════════════════════════════════════════ --}}
<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-2">
      <i class="bi bi-journal-text text-primary"></i>
      Purchase Order Master
      <span class="block-badge">PUR_ORDER_MASTER</span>
    </div>
    <div class="d-flex gap-4 left-div ms-auto">
      <button class="btn btn-outline-secondary btn-sm"
              onclick="document.getElementById('block-style').scrollIntoView({behavior:'smooth'})">
        PO Entry <i class="bi bi-arrow-down"></i>
      </button>
      <button class="btn btn-outline-secondary btn-sm"
              onclick="document.getElementById('block-detail').scrollIntoView({behavior:'smooth'})">
        Item Entry <i class="bi bi-arrow-down"></i>
      </button>
    </div>
  </div>
  <div class="card-body">
    <div class="row g-3">

      <div class="col-md-2">
        <label class="form-label">PO Number <small class="text-muted fw-normal text-lowercase">(auto)</small></label>
        <input type="text" class="form-control form-control-sm" id="PUR_ORDER_PK" readonly>
      </div>

      <div class="col-md-2">
        <label class="form-label">PO Ref No. <small class="text-muted fw-normal text-lowercase">(auto)</small></label>
        <input type="text" class="form-control form-control-sm" id="PUR_ORDER_NO" readonly>
      </div>

      <div class="col-md-2">
        <label class="form-label">PO Date <span class="text-danger">*</span></label>
        <input type="date" class="form-control form-control-sm" id="PUR_ORDER_DATE" onchange="generatePK()">
        <div class="invalid-feedback">Date cannot be in the future.</div>
      </div>

      <div class="col-md-3">
        <label class="form-label">Supplier <span class="text-danger">*</span></label>
        <div class="input-group input-group-sm">
          <input type="text" class="form-control" id="SUPPLIER_NAME" readonly placeholder="Select supplier...">
          <button class="btn btn-outline-secondary" onclick="openLov('supplier')" title="LOV — PARTY_PROFILE">
            <i class="bi bi-search"></i>
          </button>
        </div>
        <input type="hidden" id="SUPPLIER_NO">
      </div>

      <div class="col-md-2">
        <label class="form-label">Currency Rate</label>
        <input type="number" class="form-control form-control-sm" id="CURRENCY_RATE" value="1" step="0.0001" onchange="recalcAll()">
      </div>

      <div class="col-md-3">
        <label class="form-label">
          Payment Terms
          <small class="text-muted fw-normal text-lowercase">← PAY_TRAMS</small>
        </label>
        <select class="form-select form-select-sm" id="PAY_TERMS">
          <option value="">— Select —</option>
          <option>Net 30 Days</option>
          <option>Net 60 Days</option>
          <option>Advance Payment</option>
          <option>LC at Sight</option>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Ordered By</label>
        <input type="text" class="form-control form-control-sm" id="ORDER_BY" placeholder="Employee name">
      </div>

      <div class="col-md-2">
        <label class="form-label">Ref. No.</label>
        <input type="text" class="form-control form-control-sm" id="PUR_REF_NO">
      </div>

      <div class="col-md-2">
        <label class="form-label">Requisition No.</label>
        <input type="text" class="form-control form-control-sm" id="PUR_REQU_NO">
      </div>

      <div class="col-md-2">
        <label class="form-label">PO Type</label>
        <input type="text" class="form-control form-control-sm" id="PUR_TYPE">
      </div>

    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════
     STYLE BLOCK — PUR_ORDER_STYLE
══════════════════════════════════════════ --}}
<div class="card" id="block-style">
  <div class="card-header d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-2">
      <i class="bi bi-layers text-success"></i>
      PO Style / Order Lines
      <span class="block-badge">PUR_ORDER_STYLE</span>
    </div>
    <button class="btn btn-success btn-sm ms-auto" onclick="addStyleRow()">
      <i class="bi bi-plus-lg me-1"></i>Add Row
    </button>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th style="width:36px">#</th>
          <th style="width:130px">Purchase Order PK</th>
          <th style="width:160px">
            PO Number <span class="text-primary" style="font-size:9px">LOV</span>
          </th>
          <th style="width:130px">PO Number ID</th>
          <th style="width:140px">Style / Order No.</th>
          <th style="width:160px">
            Buyer Name <span class="text-muted" style="font-size:9px">FORMULA</span>
          </th>
          <th style="width:90px">PO Qty</th>
          <th style="width:44px"></th>
        </tr>
      </thead>
      <tbody id="styleRows"></tbody>
    </table>
  </div>

  <div class="card-footer text-center py-2">
    <button class="btn btn-outline-success btn-sm" onclick="addStyleRow()">
      <i class="bi bi-plus-circle me-1"></i>New style row
    </button>
  </div>
</div>

{{-- ══════════════════════════════════════════
     DETAILS BLOCK — PUR_ORDER_DETAILS
══════════════════════════════════════════ --}}
<div class="card" id="block-detail">
  <div class="card-header d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-2">
      <i class="bi bi-list-ul text-info"></i>
      Item Details
      <span class="block-badge">PUR_ORDER_DETAILS</span>
      <span id="dupWarningBadge" class="badge bg-warning text-dark d-none">
        <i class="bi bi-exclamation-triangle me-1"></i>Duplicate item detected
      </span>
    </div>
    <div class="d-flex gap-2 ms-auto">
      <button class="btn btn-outline-info btn-sm ms-auto"
              onclick="showToast('XL import — XL_BIND_UP → PUR_ORDER_DETAILS', 'info')">
        <i class="bi bi-file-earmark-excel me-1"></i>Import Excel
      </button>
      <button class="btn btn-success btn-sm ms-auto" onclick="addDetailRow()">
        <i class="bi bi-plus-lg me-1"></i>Add Item
      </button>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover" id="detailTable">
      <thead>
        <tr>
          <th style="width:36px">SL</th>
          <th style="width:120px">PUR Order PK</th>
          <th style="width:110px">PO No. ID</th>
          <th style="width:120px">
            Item ID <span class="text-primary" style="font-size:9px">LOV</span>
          </th>
          <th style="width:155px">
            Item Name <span class="text-muted" style="font-size:9px">FORMULA</span>
          </th>
          <th style="width:70px">Unit</th>
          <th style="width:72px">Qty</th>
          <th style="width:58px">%</th>
          <th style="width:82px">Rate</th>
          <th style="width:68px">Curr.</th>
          <th style="width:95px">Value</th>
          <th>Remarks</th>
          <th style="width:44px"></th>
        </tr>
      </thead>
      <tbody id="detailRows"></tbody>
      <tfoot>
        <tr>
          <td colspan="10" class="text-end fw-bold text-secondary">TOTAL</td>
          <td id="totalValue" class="val-cell fw-bold">0.00</td>
          <td colspan="2"></td>
        </tr>
      </tfoot>
    </table>
  </div>

  <div class="card-footer text-center py-2">
    <button class="btn btn-outline-success btn-sm" onclick="addDetailRow()">
      <i class="bi bi-plus-circle me-1"></i>New item row
    </button>
  </div>
</div>

{{-- ══════════════════════════════════════════
     TERMS BLOCK — PUR_ORDER_TERMS
══════════════════════════════════════════ --}}
<div class="card">
  <div class="card-header d-flex align-items-center gap-2">
    <i class="bi bi-file-ruled text-secondary"></i>
    Payment Terms
    <span class="block-badge">PUR_ORDER_TERMS</span>
    <small class="text-muted fw-normal" style="font-size:10px">
      auto-populated from PURCHASE_TERMS on commit
    </small>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th style="width:140px">Terms ID</th>
          <th>Terms Description</th>
          <th style="width:44px"></th>
        </tr>
      </thead>
      <tbody id="termsRows"></tbody>
    </table>
  </div>
</div>

{{-- ── Action Buttons ── --}}
<div class="d-flex gap-2 mb-5 justify-content-center">
  <button class="btn btn-primary" onclick="saveOrder()">
    <i class="bi bi-check-lg me-1"></i>Save (Commit)
  </button>
  <button class="btn btn-outline-secondary" onclick="showToast('Exit — exit_form(no_commit)', 'warning')">
    <i class="bi bi-x-lg me-1"></i>Exit
  </button>
</div>

@endsection

@push('scripts')
<script>
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ── Global State ─────────────────────────────────────────────
let CURRENT_MASTER_ID = null;
let CURRENT_PO_ID     = null;
let CURRENT_STYLE     = null;
let detailIdx         = 0;
let lovActiveType     = null;
let lovActiveIdx      = null;

// ── On Load ───────────────────────────────────────────────────
window.addEventListener('load', () => {
  generatePK();
  seedTerms();
});

// ── Auto-generate PK & PO_NO ─────────────────────────────────
async function generatePK() {
  const date = document.getElementById('PUR_ORDER_DATE').value;
  if (!date) return;

  try {
    const [pkRes, noRes] = await Promise.all([
      fetch(`/purchase-orders/generate-pk?date=${date}`),
      fetch(`/purchase-orders/generate-po-no?date=${date}`)
    ]);
    const pkData = await pkRes.json();
    const noData = await noRes.json();

    document.getElementById('PUR_ORDER_PK').value = pkData.pk;
    document.getElementById('PUR_ORDER_NO').value = noData.po_no;
    CURRENT_MASTER_ID = pkData.pk;
  } catch (e) {
    console.warn('generatePK error:', e);
  }
}

function toggleSearch() {
  document.getElementById('searchBar').classList.toggle('visible');
}

// function doSearch() {
//   const v = document.getElementById('searchInput').value;
//   showToast(`Executing query: WHERE PUR_ORDER_PK LIKE '%${v}%'`, 'info');
//   toggleSearch();
// }
async function doSearch() {

  const pk = document.getElementById('searchInput').value;

  if (!pk) {
    showToast('Enter PO Number', 'danger');
    return;
  }

  try {

    const res = await fetch(`/purchase-orders/${pk}`);
    const data = await res.json();

    if (!data) {
      showToast('No record found', 'warning');
      return;
    }

    console.log('LOADED DATA:', data);

   let record = data;

// handle array
if (Array.isArray(data)) {
  record = data[0];
}

// handle wrapped response
if (data.data) {
  record = data.data;
}

console.log('FINAL RECORD:', record);

loadMaster(record);
loadStylesAndDetails(record);

    showToast('Record loaded', 'success');

  } catch (e) {
    console.error(e);
    showToast('Search failed', 'danger');
  }
}

function loadMaster(data) {

  document.getElementById('PUR_ORDER_PK').value = data.pur_order_pk;
  document.getElementById('PUR_ORDER_NO').value = data.pur_order_no;
  document.getElementById('SUPPLIER_NO').value  = data.supplier_no;

  // ✅ ONLY SAFE DATE HANDLING
  const dateInput = document.getElementById('PUR_ORDER_DATE');
  let rawDate = data.pur_order_date;

  console.log('RAW DATE FROM BACKEND:', rawDate);

  if (!rawDate || rawDate === 'undefined') {
    dateInput.value = '';
  } else {
    if (/^\d{4}-\d{2}-\d{2}$/.test(rawDate)) {
      dateInput.value = rawDate;
    } else {
      const d = new Date(rawDate);
      if (!isNaN(d.getTime())) {
        dateInput.value =
          d.getFullYear() + '-' +
          String(d.getMonth() + 1).padStart(2, '0') + '-' +
          String(d.getDate()).padStart(2, '0');
      } else {
        dateInput.value = '';
      }
    }
  }

  CURRENT_MASTER_ID = data.PUR_ORDER_PK;
}

async function loadStylesAndDetails(master) {

  console.log('MASTER RECEIVED:', master);

  const pk = master.pur_order_pk;

  if (!pk) {
    console.error('PK is undefined ❌', master);
    return;
  }

  // CLEAR OLD
  document.getElementById('styleRows').innerHTML = '';
  document.getElementById('detailRows').innerHTML = '';

  // FETCH ITEMS
  const res = await fetch(`/purchase-orders/${pk}/items`);
  const items = await res.json();

  console.log('ITEMS RESPONSE:', items);

  if (!items.length) {
    console.warn('No items found');
    return;
  }

  let grouped = {};

  items.forEach(d => {
    const poId = d.PO_NUMBER_ID || d.po_number_id;

    if (!grouped[poId]) {
      grouped[poId] = [];
    }

    grouped[poId].push(d);
  });

  Object.keys(grouped).forEach((poId, idx) => {

    addStyleRow({
      po_number_id: poId,
      order_no: grouped[poId][0].ORDER_NO || grouped[poId][0].order_no || '',
      buyer_name: grouped[poId][0].BUYER_NAME || '',
      po_quantity: grouped[poId][0].PO_QTY || ''
    });

    const tr = document.getElementById(`sr-${idx}`);
    tr.click();

    grouped[poId].forEach(d => {

      addDetailRow({
        item_id: d.ITEM_ID || d.item_id,
        item_name: d.ITEM_NAME || d.item_name,
        quantity: d.quantity || d.quantity,
        item_rate: d.RATE || d.rate
      });

    });

  });
}



// ── Style Rows ────────────────────────────────────────────────
function addStyleRow(data = {}) {
  const tbody = document.getElementById('styleRows');
  const idx   = tbody.querySelectorAll('tr').length;

  const tr  = document.createElement('tr');
  tr.id     = `sr-${idx}`;
  tr.innerHTML = `
    <td class="text-center text-muted">${idx + 1}</td>

    <td>
      <input type="text" class="form-control form-control-sm font-monospace"
             id="sr${idx}_master" value="${CURRENT_MASTER_ID || ''}" readonly style="font-size:11px">
    </td>

    <td>
      <div class="input-group input-group-sm">
        <input type="text" class="form-control" id="sr${idx}_po"
               value="${data.po_number || ''}" readonly placeholder="Select PO...">
        <button class="btn btn-outline-secondary" onclick="openLov('po', ${idx})" title="LOV — ORDER_PO_NUMBER">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </td>

    <td>
      <input type="text" class="form-control form-control-sm" id="sr${idx}_poi"
             value="${data.po_number_id || ''}" readonly>
    </td>
    <td>
      <input type="text" class="form-control form-control-sm" id="sr${idx}_order"
             value="${data.order_no || ''}" readonly>
    </td>
    <td>
      <input type="text" class="form-control form-control-sm" id="sr${idx}_buyer"
             value="${data.buyer_name || ''}" readonly>
    </td>
    <td>
      <input type="number" class="form-control form-control-sm" id="sr${idx}_qty"
             value="${data.po_quantity || ''}">
    </td>

    <td class="text-center">
      <button class="btn btn-outline-danger btn-sm" onclick="removeStyleRow(${idx})">
        <i class="bi bi-trash"></i>
      </button>
    </td>`;

  tbody.appendChild(tr);

  // Row click — select style (Oracle ON-POPULATE-DETAILS behaviour)
  tr.addEventListener('click', function () {
    document.querySelectorAll('#styleRows tr').forEach(r => r.classList.remove('selected-style'));
    tr.classList.add('selected-style');

    const poi = document.getElementById(`sr${idx}_poi`)?.value || '';
    CURRENT_PO_ID = poi;
    CURRENT_STYLE = { po_id: poi, row: tr };

    filterDetailsByStyle();
  });
}

function removeStyleRow(idx) {
  document.getElementById(`sr-${idx}`)?.remove();
}

function filterDetailsByStyle() {
  if (!CURRENT_STYLE) return;
  document.querySelectorAll('#detailRows tr').forEach(tr => {
    const poi = tr.querySelector('[id$="_poi"]');
    if (!poi) return;
    tr.style.display = poi.value === CURRENT_STYLE.po_id ? '' : 'none';
  });
}

// ── Detail Rows ───────────────────────────────────────────────
function addDetailRow(data = {}) {
  if (!CURRENT_STYLE) {
    showToast('Please select a style row first.', 'danger');
    return;
  }

  const idx   = detailIdx++;
  const tbody = document.getElementById('detailRows');
  const sl    = tbody.querySelectorAll('tr').length + 1;

  const tr  = document.createElement('tr');
  tr.id     = `dr-${idx}`;
  tr.innerHTML = `
    <td class="text-center text-muted">${sl}</td>

    <td>
      <input type="text" class="form-control form-control-sm font-monospace"
             id="dr${idx}_master" value="${CURRENT_MASTER_ID || ''}" readonly style="font-size:11px">
    </td>

    <td>
    <input id="dr${idx}_poi" class="form-control form-control-sm"  value="${CURRENT_STYLE.po_id}" readonly>
     
    </td>
 <td>
         <input type="hidden" id="dr${idx}_item" value="${data.item_id || ''}">
    </td>

    <td>
      <div class="input-group input-group-sm">
        <input type="text" class="form-control" id="dr${idx}_name"
               value="${data.item_name || ''}" readonly placeholder="Select item...">
                <button class="btn btn-outline-secondary" onclick="openLov('item', ${idx})" title="LOV — ITEMDT">
          <i class="bi bi-search"></i>
        </button>
      </div>
   
    </td>

   
    <td>
      <select class="form-select form-select-sm" id="dr${idx}_unit">
        <option>PCS</option><option>MTR</option><option>SET</option><option>KG</option><option>DOZ</option>
      </select>
    </td>

    <td>
      <input type="number" class="form-control form-control-sm" id="dr${idx}_qty"
             value="${data.quantity || 0}" step="1" oninput="recalcLine(${idx})">
    </td>

    <td>
      <input type="number" class="form-control form-control-sm" id="dr${idx}_percent"
             value="0" step="0.01" oninput="recalcLine(${idx})">
    </td>

    <td>
      <input type="number" class="form-control form-control-sm" id="dr${idx}_rate"
             value="${data.item_rate || 0}" step="0.0001" oninput="recalcLine(${idx})">
    </td>

    <td>
      <select class="form-select form-select-sm" id="dr${idx}_currency">
        <option>USD</option><option>BDT</option><option>EUR</option>
      </select>
    </td>

    <td>
      <input type="text" class="form-control form-control-sm val-cell"
             id="dr${idx}_val" value="0.00" readonly>
    </td>

    <td>
      <input type="text" class="form-control form-control-sm"
             id="dr${idx}_remarks" value="">
    </td>

    <td class="text-center">
      <button class="btn btn-outline-danger btn-sm" onclick="removeDetailRow(${idx})">
        <i class="bi bi-trash"></i>
      </button>
    </td>`;

  tbody.appendChild(tr);
  recalcTotals();
}

function removeDetailRow(idx) {
  document.getElementById(`dr-${idx}`)?.remove();
  recalcTotals();
}

// ── Recalc ────────────────────────────────────────────────────
function recalcLine(idx) {
  const qty     = parseFloat(document.getElementById(`dr${idx}_qty`)?.value     || 0);
  const rate    = parseFloat(document.getElementById(`dr${idx}_rate`)?.value    || 0);
  const percent = parseFloat(document.getElementById(`dr${idx}_percent`)?.value || 0);

  let val = qty * rate;
  if (percent > 0) val += val * percent / 100;

  const vEl = document.getElementById(`dr${idx}_val`);
  if (vEl) vEl.value = val.toFixed(2);

  recalcTotals();
}

function recalcAll() {
  for (let i = 0; i < detailIdx; i++) {
    if (document.getElementById(`dr${i}_val`)) recalcLine(i);
  }
}

function recalcTotals() {
  let total = 0;
  for (let i = 0; i < detailIdx; i++) {
    total += parseFloat(document.getElementById(`dr${i}_val`)?.value || 0);
  }
  document.getElementById('totalValue').textContent = total.toFixed(2);
}

// ── LOV ───────────────────────────────────────────────────────
function openLov(type, idx = null) {
  lovActiveType = type;
  lovActiveIdx  = idx;

  document.getElementById('lovSearch').value = '';

  const urlMap = {
    item:     '/purchase-orders/lov/items',
    supplier: '/purchase-orders/lov/suppliers',
    po:       '/purchase-orders/lov/po-numbers',
  };

  const titleMap = {
    item:     'LOV — Items (BUYER_ACCESORIES_LIST)',
    supplier: 'LOV — Suppliers (PARTY_PROFILE)',
    po:       'LOV — PO Numbers (ORDER_PO_NUMBER)',
  };

  document.getElementById('lovTitle').textContent = titleMap[type] || 'List of Values';

  fetch(urlMap[type])
    .then(r => r.json())
    .then(data => {
      const list = document.getElementById('lovList');
      list.innerHTML = '';

      if (!data.length) {
        list.innerHTML = '<div class="p-3 text-muted small">No records found.</div>';
        bsLovModal.show();
        return;
      }

      data.forEach(row => {
        const div = document.createElement('div');
        div.className = 'lov-row';

        if (type === 'item') {
          div.innerHTML = `
            <div class="lov-id">${row.item_id}</div>
            <div>${row.item_name}</div>
            <div class="lov-qty">${row.unit || ''}</div>`;
          div.onclick = () => selectLov('item', idx, row.item_id, row.item_name);

        } else if (type === 'supplier') {
          div.innerHTML = `
            <div class="lov-id">${row.party_id}</div>
            <div>${row.party_name}</div>
            <div class="lov-qty"></div>`;
          div.onclick = () => selectLov('supplier', idx, row.party_id, row.party_name);

        } else if (type === 'po') {
          div.innerHTML = `
            <div class="lov-id">${row.po_number}</div>
            <div>${row.buyer_name || ''}</div>
            <div class="lov-qty">${row.po_quantity ? row.po_quantity.toLocaleString() : ''}</div>`;
          div.onclick = () => selectLov('po', idx, null, null, row);
        }

        list.appendChild(div);
      });

      bsLovModal.show();
    })
    .catch(err => {
      console.error('LOV fetch error:', err);
      showToast('Failed to load LOV data.', 'danger');
    });
}

function selectLov(type, idx, id, name, rowData = null) {

  if (type === 'item') {
    document.getElementById(`dr${idx}_item`).value     = id;
    document.getElementById(`dr${idx}_name`).value     = name;
    // document.getElementById(`dr${idx}_itemname`).value = name;
  }

  if (type === 'supplier') {
    document.getElementById('SUPPLIER_NO').value   = id;
    document.getElementById('SUPPLIER_NAME').value = name;
  }

  ///////


if (type === 'po' && rowData) {

  CURRENT_PO_ID = rowData.po_number_id;

  const setVal = (elId, val) => {
    const el = document.getElementById(elId);
    if (el) el.value = val ?? '';
  };

  setVal(`sr${idx}_po`,     rowData.po_number);
  setVal(`sr${idx}_poi`,    rowData.po_number_id);
  setVal(`sr${idx}_order`,  rowData.order_no);
  setVal(`sr${idx}_buyer`,  rowData.buyer_name);
  setVal(`sr${idx}_qty`,    rowData.po_quantity);

  // ===============================
  // ✅ ADD THIS BLOCK HERE
  // ===============================
  const tr = document.getElementById(`sr-${idx}`);

  document.querySelectorAll('#styleRows tr')
    .forEach(r => r.classList.remove('selected-style'));

  tr.classList.add('selected-style');

  CURRENT_STYLE = {
    po_id: rowData.po_number_id,
    row: tr
  };

  filterDetailsByStyle();
}
  ////

  bsLovModal.hide();
}

// ── Terms ─────────────────────────────────────────────────────
const STD_TERMS = [
  { id: 'TRM-01', terms: 'Payment within 30 days of invoice date.' },
  { id: 'TRM-02', terms: 'Goods must conform to approved samples.' },
  { id: 'TRM-03', terms: 'Supplier bears all inspection costs.' },
];

function seedTerms() {
  const tbody = document.getElementById('termsRows');
  tbody.innerHTML = '';
  STD_TERMS.forEach(t => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>
        <input type="text" class="form-control form-control-sm font-monospace"
               value="${t.id}" readonly style="font-size:11px">
      </td>
      <td>
        <input type="text" class="form-control form-control-sm" value="${t.terms}">
      </td>
      <td class="text-center">
        <button class="btn btn-outline-danger btn-sm" onclick="this.closest('tr').remove()">
          <i class="bi bi-trash"></i>
        </button>
      </td>`;
    tbody.appendChild(tr);
  });
}

// ── Collect & Save ────────────────────────────────────────────
function collectFormData() {
  const details = [];
  const styles  = [];

  document.querySelectorAll('#detailRows tr').forEach(tr => {
    const itemId = tr.querySelector('[id$="_item"]');
    if (!itemId || !itemId.value) return;
    details.push({
      PO_NUMBER_ID: tr.querySelector('[id$="_poi"]')?.value     || null,
      ITEM_ID:      itemId.value,
      ITEM_NAME:    tr.querySelector('[id$="_itemname"]')?.value || '',
      QUANTITY:     tr.querySelector('[id$="_qty"]')?.value      || 0,
      ITEM_RATE:    tr.querySelector('[id$="_rate"]')?.value     || 0,
    });
  });

  document.querySelectorAll('#styleRows tr').forEach(tr => {
    const poi = tr.querySelector('[id$="_poi"]')?.value;
    if (!poi) return;
    styles.push({
      PO_NUMBER:    tr.querySelector('[id$="_po"]')?.value    || '',
      PO_NUMBER_ID: poi,
      ORDER_NO:     tr.querySelector('[id$="_order"]')?.value || '',
      BUYER_NAME:   tr.querySelector('[id$="_buyer"]')?.value || '',
      PO_QTY:       tr.querySelector('[id$="_qty"]')?.value   || 0,
      details:      details.filter(d => String(d.PO_NUMBER_ID).trim() === String(poi).trim()),
    });
  });

  return {
    master: {
      PUR_ORDER_PK:   document.getElementById('PUR_ORDER_PK').value,
      PUR_ORDER_NO:   document.getElementById('PUR_ORDER_NO').value,
      PUR_ORDER_DATE: document.getElementById('PUR_ORDER_DATE').value,
      SUPPLIER_NO:    document.getElementById('SUPPLIER_NO').value,
      CURRENCY_RATE:  document.getElementById('CURRENCY_RATE').value || 1,
    },
    styles,
  };
}

async function saveOrder() {
  if (!CURRENT_PO_ID) {
    showToast('Please select a PO before saving.', 'danger');
    return;
  }

  const payload = collectFormData();

  try {
    const res  = await fetch('/purchase-orders', {
      method:  'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
      body:    JSON.stringify(payload),
    });
    const data = await res.json();

    if (res.ok) {
      showToast(data.message || 'Record(s) successfully Saved.', 'success');
      seedTerms();
    } else {
      showToast(data.message || 'Save failed.', 'danger');
    }
  } catch (err) {
    console.error(err);
    showToast('Network error — save failed.', 'danger');
  }
}
</script>
@endpush

<script src="{{ URL::asset('mainjs/jquery.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('dist/js/adminlte.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('mainjs/buttons.bootstrap5.min.js') }}"></script>