@extends('item-received.layout')

@section('title', 'Item Received — List')

@section('nav-title') Item Received Entry @endsection
@section('nav-badge')
    <span class="badge bg-primary text-white">G_ITEM_RECEIVED_MASTER</span>
@endsection

@section('nav-actions')
    <a href="{{ route('item-received.create') }}" class="btn btn-outline-info btn-sm">
        <i class="bi bi-plus-lg me-1"></i> New Entry
    </a>
@endsection

@section('content')
    <div class="section-card">
        <div class="section-header">
            <div class="section-header-left">
                <i class="bi bi-table text-secondary" style="font-size:13px;"></i>
                <span class="section-title">All Records</span>
                <span class="section-badge">Total: {{ $records->total() }}</span>
            </div>
        </div>

        <div class="toolbar">
            <form method="GET" class="d-flex gap-2 align-items-center flex-grow-1">
                <div class="input-group" style="max-width:340px;">
                    <span class="input-group-text bg-white" style="padding:4px 8px;font-size:12px;"><i
                            class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                        placeholder="Search GRN No, PO, Supplier, Challan...">
                    <button class="btn btn-outline-secondary btn-sm" type="submit">Search</button>
                </div>
                @if (request('search'))
                    <a href="{{ route('item-received.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x-lg"></i> Clear
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table mono table-bordered data-table mb-0">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>Received No</th>
                        <th>Received Date</th>
                        <th>Supplier ID</th>
                        <th>PO Number</th>
                        <th>Challan No</th>
                        <th>Bill No</th>
                        <th>Client PI</th>
                        <th>Remarks</th>
                        <th>Insert By</th>
                        <th class="text-center" width="130">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $i => $row)
                        <tr>
                            <td class="mono text-muted">{{ $records->firstItem() + $i }}</td>
                            <td><span class="badge bg-primary-subtle text-primary mono">{{ $row->received_no }}</span></td>
                            <td>{{ $row->received_date ? \Carbon\Carbon::parse($row->received_date)->format('d-M-Y') : '—' }}
                            </td>
                            <td class="mono">{{ $row->supplier_id }}</td>
                            <td class="mono">{{ $row->po_number ?: '—' }}</td>
                            <td class="mono">{{ $row->supplier_challan_no ?: '—' }}</td>
                            <td class="mono">{{ $row->supp_bill_no ?: '—' }}</td>
                            <td class="mono">{{ $row->client_pi_no ?: '—' }}</td>
                            <td>{{ Str::limit($row->remarks, 35) ?: '—' }}</td>
                            <td class="mono">{{ $row->insert_by ?: '—' }}</td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('item-received.view', $row->received_no_id) }}?view=1"
                                        class="btn btn-primary btn-xs">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ route('item-received.edit', $row->received_no_id) }}"
                                        class="btn btn-warning btn-xs text-white">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <form method="POST"
                                        action="{{ route('item-received.destroy', $row->received_no_id) }}"
                                        onsubmit="return confirm('Delete this record?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">
                                            <i class="bi bi-trash"></i> Del
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">
                                No records found.
                                <a href="{{ route('item-received.create') }}" class="text-primary">Create the first entry
                                    →</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($records->hasPages())
            <div class="pagination-wrap">
                <span class="page-info">
                    Showing {{ $records->firstItem() }}–{{ $records->lastItem() }} of {{ $records->total() }} records
                </span>
                {{ $records->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
@endsection
