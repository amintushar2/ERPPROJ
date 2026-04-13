@forelse($vouchers as $v)
    @php
        $dr = $v->details->sum('debit_amount');
        $cr = $v->details->sum('credit_amount');
        $st = $v->entry_status ?? 'Draft';

        $badge = match ($st) {
            'Approved' => 'success',
            'Submitted' => 'warning',
            'Complete' => 'primary',
            default => 'secondary',
        };
    @endphp

    <tr>
        <td class="fw-semibold text-primary">{{ $v->voucher_id }}</td>
        <td>{{ $v->voucher_type }}</td>
        <td>{{ $v->voucher_date }}</td>
        <td>{{ $v->receive_pay_to }}</td>
        <td>{{ $v->company->company_name ?? $v->company_id }}</td>
        <td class="text-end">{{ number_format($dr, 2) }}</td>
        <td class="text-end">{{ number_format($cr, 2) }}</td>

        <td>
            <span class="badge bg-{{ $badge }}">{{ $st }}</span>
        </td>

        <td>{{ $v->prepared_by }}</td>
        <td>
            <a href="{{ route('vouchers.show', $v->voucher_id) }}" class="btn btn-outline-primary btn-sm" title="View">
                <i class="bi bi-eye"></i>
            </a>
        </td>
    </tr>

@empty
    <tr>
        <td colspan="10" class="text-center text-muted">No data</td>
    </tr>
@endforelse

{{-- PAGINATION --}}
<tr>
    <td colspan="10">
        {!! $vouchers->links() !!}
    </td>
</tr>
