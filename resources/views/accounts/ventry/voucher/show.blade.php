@extends('layouts.app')
@section('content')

<div class="card">
<div class="card-header d-flex justify-content-between">
Voucher Details
<a href="{{ route('vouchers.index') }}" class="btn btn-secondary btn-sm">Back</a>
</div>

<div class="card-body">

<table class="table">
<tr><th>ID</th><td>{{ $voucher->VOUCHER_ID }}</td></tr>
<tr><th>Type</th><td>{{ $voucher->VOUCHER_TYPE }}</td></tr>
<tr><th>Date</th><td>{{ $voucher->VOUCHER_DATE }}</td></tr>
<tr><th>Pay To</th><td>{{ $voucher->RECEIVE_PAY_TO }}</td></tr>
</table>

<hr>

<h6>Details</h6>

<table class="table table-bordered">
<tr>
<th>Account</th>
<th>Debit</th>
<th>Credit</th>
</tr>

@foreach($voucher->details as $d)
<tr>
<td>{{ $d->ACCOUNT_HEAD_ID }}</td>
<td>{{ $d->DEBIT_AMOUNT }}</td>
<td>{{ $d->CREDIT_AMOUNT }}</td>
</tr>
@endforeach

</table>

</div>
</div>

@endsection
