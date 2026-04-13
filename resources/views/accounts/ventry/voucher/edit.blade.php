@extends('layouts.app')
@section('content')

<div class="card">
<div class="card-header">Edit Voucher</div>

<div class="card-body">

<form method="POST" action="{{ route('vouchers.update',$voucher->VOUCHER_ID) }}">
@csrf
@method('PUT')

<div class="row g-2">
<div class="col-md-3">
<label>Type</label>
<input type="text" class="form-control" value="{{ $voucher->VOUCHER_TYPE }}" readonly>
</div>

<div class="col-md-3">
<label>Date</label>
<input type="date" name="VOUCHER_DATE" value="{{ $voucher->VOUCHER_DATE }}" class="form-control">
</div>

<div class="col-md-6">
<label>Pay To</label>
<input type="text" name="RECEIVE_PAY_TO" value="{{ $voucher->RECEIVE_PAY_TO }}" class="form-control">
</div>
</div>

<hr>

<button class="btn btn-success btn-sm">Update</button>
<a href="{{ route('vouchers.show',$voucher->VOUCHER_ID) }}" class="btn btn-secondary btn-sm">Back</a>

</form>

</div>
</div>

@endsection
