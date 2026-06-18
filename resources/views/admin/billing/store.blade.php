@extends('layouts.admin')

@section('content')

<div class="container">
<div class="card">

<div class="card-header">
<h4>Invoice Details</h4>
</div>

<div class="card-body">

<p><strong>Receipt No:</strong> {{ $billing->receipt_no }}</p>
<p><strong>Patient:</strong> {{ $billing->patient->name }}</p>
<p><strong>Amount:</strong> ₹ {{ $billing->amount }}</p>
<p><strong>Payment Mode:</strong> {{ $billing->payment_mode }}</p>
<p><strong>Date:</strong> {{ $billing->created_at }}</p>

<a href="{{ route('admin.billing.receipt', $billing->id) }}" class="btn btn-success">
Download Receipt
</a>

</div>
</div>
</div>

@endsection