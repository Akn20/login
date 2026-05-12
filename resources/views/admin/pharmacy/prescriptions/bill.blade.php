{{-- resources/views/admin/pharmacy/prescriptions/bill.blade.php --}}

@extends('layouts.admin')

@section('title','Pharmacy Bill')

@section('content')

<style>

/* PRINT STYLING */
@media print{

body *{
    visibility:hidden;
}

#printArea, #printArea *{
    visibility:visible;
}

#printArea{
    position:absolute;
    left:0;
    top:0;
    width:100%;
}

.btn,
.navbar,
.sidebar,
header,
footer{
    display:none !important;
}

}

</style>

<div class="container-fluid">

<!-- Page Header -->

<div class="d-flex justify-content-between align-items-center mb-3">

<div>
<h4 class="mb-0">Pharmacy Bill</h4>
<small class="text-muted">Pharmacy → Billing</small>
</div>

<div class="d-flex gap-2">

<button onclick="window.print()" class="btn btn-primary">
Print Bill
</button>

<a href="{{ route('admin.prescriptions.dispense',$bill->prescription_id) }}" class="btn btn-secondary">
Back
</a>

</div>

</div>

<!-- PRINT AREA -->

<div id="printArea">

<div class="card">

<div class="card-body">

<!-- Invoice Header -->

<div class="row mb-4">

<div class="col-md-12 text-center">

<h3 class="fw-bold text-primary">
Hospital Pharmacy Invoice
</h3>

</div>

<div class="col-md-6">

<p>

Prescription No:{{ $bill->prescription_number }} <br>

Bill No: {{ $bill->bill_number }} <br>

Bill Date: {{ $bill->created_at }}

</p>

</div>

<div class="col-md-6 text-end">

<p>

Patient: {{ $bill->patient->patient_name ?? '-' }} <br>

Phone: {{ $bill->patient->phone ?? '-' }}

</p>

</div>

</div>

<!-- Medicines Table -->

<div class="table-responsive">

<table class="table table-bordered">

<thead>

<tr>
<th>#</th>
<th>Medicine</th>
<th>Quantity</th>
<th>Unit Price</th>
<th>Total</th>
</tr>

</thead>

<tbody>

@php
$subtotal = 0;
@endphp

@foreach($bill->items as $key => $item)

@php
$total = $item->quantity * $item->unit_price;
$subtotal += $total;
@endphp

<tr>

<td>{{ $key + 1 }}</td>

<td>{{ $item->medicine_name ?? '-' }}</td>

<td>{{ $item->quantity }}</td>

<td>{{ number_format($item->unit_price,2) }}</td>

<td>₹ {{ number_format($total,2) }}</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<!-- Bill Summary -->

<div class="row mt-4">

<div class="col-md-6"></div>

<div class="col-md-6">

<table class="table">

<tr>

<th>Subtotal</th>

<td>₹ {{ number_format($subtotal,2) }}</td>

</tr>

<tr>

<th>GST (5%)</th>

<td>₹ {{ number_format($subtotal * 0.05,2) }}</td>

</tr>

<tr>

<th>Total Amount</th>

<td>

<strong>

₹ {{ number_format($subtotal + ($subtotal * 0.05),2) }}

</strong>

</td>

</tr>

</table>

</div>

</div>

</div>

</div>

</div>

</div>

@endsection
