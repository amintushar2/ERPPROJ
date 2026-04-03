@extends('item-received.layout')

@section('title', 'View — ' . $master->received_no)

@section('nav-title') Item Received — View @endsection
@section('nav-badge')
  <span class="badge bg-primary mono">{{ $master->received_no }}</span>
@endsection

@section('nav-actions')
  <a href="{{ route('item-received.index') }}" class="btn btn-app-exit btn-sm">
    <i class="bi bi-arrow-left me-1"></i> Back
  </a>
  <a href="{{ route('item-received.edit', $master->received_no_id) }}" class="btn btn-warning btn-sm text-white">
    <i class="bi bi-pencil me-1"></i> Edit
  </a>
  <form method="POST" action="{{ route('item-received.destroy', $master->received_no_id) }}"
    style="display:inline" onsubmit="return confirm('Delete this record?')">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">
      <i class="bi bi-trash me-1"></i> Delete
    </button>
  </form>
  <button class="btn btn-secondary btn-sm" onclick="window.print()">
    <i class="bi bi-printer me-1"></i> Print
  </button>
@endsection

@section('content')

{{-- MASTER --}}
<div class="section-card">
  <div class="section-header">
    <div class="section-header-left">
      <i class="bi bi-clipboard-data text-secondary" style="font-size:13px;"></i>
      <span class="section-title">Item Received Master</span>
      <span class="section-badge">G_ITEM_RECEIVED_MASTER</span>
    </div>
  </div>
  <div class="row g-0" style="font-size:12px;">
    @php
    $fields = [
      'Received No'       => ['value' => $master->received_no,          'badge' => true],
      'Received Date'     => ['value' => $master->received_date ? \Carbon\Carbon::parse($master->received_date)->format('d-M-Y') : '—'],
      'Supplier ID'       => ['value' => $master->supplier_id,          'mono' => true],
      'Challan No'        => ['value' => $master->supplier_challan_no ?: '—', 'mono' => true],
      'PO Number'         => ['value' => $master->po_number ?: '—',     'mono' => true],
      'Four PO No'        => ['value' => $master->four_po_no ?: '—',    'mono' => true],
      'Four PO ID'        => ['value' => $master->four_po_id ?: '—',    'mono' => true],
      'Supplier Bill No'  => ['value' => $master->supp_bill_no ?: '—',  'mono' => true],
      'Client PI Number'  => ['value' => $master->client_pi_number ?: '—'],
      'Order No ID'       => ['value' => $master->order_no_id ?: '—',   'mono' => true],
      'Insert By / Date'  => ['value' => ($master->insert_by ?? '') . '  ·  ' . ($master->insert_date ? \Carbon\Carbon::parse($master->insert_date)->format('d-M-Y H:i') : ''), 'mono' => true],
      'Update By / Date'  => ['value' => ($master->update_by ?: '—') . ($master->update_date ? '  ·  '.\Carbon\Carbon::parse($master->update_date)->format('d-M-Y H:i') : ''), 'mono' => true],
    ];
    @endphp
    @foreach($fields as $label => $f)
    <div class="col-md-2 col-sm-4 border-bottom border-end p-2">
      <div style="font-size:9px;font-weight:600;color:#6c757d;text-transform:uppercase;letter-spacing:.05em;margin-bottom:3px;">{{ $label }}</div>
      @if(!empty($f['badge']))
        <span class="badge bg-primary-subtle text-primary mono">{{ $f['value'] }}</span>
      @else
        <div class="{{ !empty($f['mono']) ? 'mono' : '' }}" style="color:#212529;">{{ $f['value'] }}</div>
      @endif
    </div>
    @endforeach
    <div class="col-12 border-bottom p-2">
      <div style="font-size:9px;font-weight:600;color:#6c757d;text-transform:uppercase;letter-spacing:.05em;margin-bottom:3px;">Remarks</div>
      <div>{{ $master->REMARKS ?: '—' }}</div>
    </div>
  </div>
</div>

{{-- STYLES --}}
<div class="section-card">
  <div class="section-header">
    <div class="section-header-left">
      <i class="bi bi-arrow-repeat text-secondary" style="font-size:13px;"></i>
      <span class="section-title">Style / Order Lines</span>
      <span class="section-badge">{{ $styles->count() }} row(s)</span>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered data-table mb-0">
      <thead>
        <tr>
          <th>#</th><th>PO Number</th><th>Style No</th><th>Order No</th>
          <th>Order No ID</th><th>Inserted By</th><th>Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse($styles as $i => $s)
        <tr>
          <td class="mono">{{ $i+1 }}</td>
          <td class="mono">{{ $s->po_number ?: '—' }}</td>
          <td class="mono">{{ $s->style_no ?: '—' }}</td>
          <td class="mono">{{ $s->order_no ?: '—' }}</td>
          <td class="mono">{{ $s->order_no_id ?: '—' }}</td>
          <td class="mono">{{ $s->insert_by ?: '—' }}</td>
          <td class="mono">{{ $s->insert_date ? \Carbon\Carbon::parse($s->insert_date)->format('d-M-Y') : '' }}</td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-3">No style rows</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- DETAILS --}}
<div class="section-card">
  <div class="section-header">
    <div class="section-header-left">
      <i class="bi bi-boxes text-secondary" style="font-size:13px;"></i>
      <span class="section-title">Item Details</span>
      <span class="section-badge">{{ $details->count() }} item(s)</span>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered data-table mb-0">
      <thead>
        <tr>
          <th>SL</th><th>PO No ID</th><th>Item No</th><th>Unit</th>
          <th>Qty</th><th>%</th><th>Pur Qty</th><th>Prev Rcvd</th>
          <th>PO Number</th><th>Remarks</th>
        </tr>
      </thead>
      <tbody>
        @forelse($details as $i => $d)
        <tr>
          <td class="mono">{{ $i+1 }}</td>
          <td class="mono">{{ $d->po_number_id ?: '—' }}</td>
          <td class="mono fw-semibold">{{ $d->item_no }}</td>
          <td>{{ $d->item_unit ?: '—' }}</td>
          <td class="mono text-primary fw-semibold">{{ number_format($d->item_qty, 2) }}</td>
          <td class="mono">{{ $d->percentage !== null ? number_format($d->percentage,2) : '—' }}</td>
          <td class="mono">{{ $d->pur_qty !== null ? number_format($d->pur_qty,2) : '—' }}</td>
          <td class="mono">{{ $d->previous_received !== null ? number_format($d->previous_received,2) : '—' }}</td>
          <td class="mono">{{ $d->po_number ?: '—' }}</td>
          <td>{{ $d->item_remarks ?: '—' }}</td>
        </tr>
        @empty
        <tr><td colspan="10" class="text-center text-muted py-3">No item details</td></tr>
        @endforelse
      </tbody>
      @if($details->count())
      <tfoot>
        <tr class="table-light fw-semibold">
          <td colspan="4" class="text-end text-muted" style="font-size:10px;text-transform:uppercase;letter-spacing:.04em;">Total Qty</td>
          <td class="text-primary mono">{{ number_format($details->sum('item_qty'), 2) }}</td>
          <td colspan="5"></td>
        </tr>
      </tfoot>
      @endif
    </table>
  </div>
</div>

@endsection
