{{-- resources/views/admin/pharmacy/prescriptions/bill.blade.php --}}

@extends('layouts.admin')

@section('title','Pharmacy Bill')

@section('content')

<div class="container-fluid">

<!-- Page Header -->

<div class="d-flex justify-content-between align-items-center mb-3">

<div>
<h4 class="mb-0">Pharmacy Bill</h4>
<small class="text-muted">Pharmacy → Billing</small>
</div>

<div>

<button onclick="window.print()" class="btn btn-primary">
Print Bill
</button>

<a href="{{ route('admin.prescriptions.index') }}" class="btn btn-secondary">
Back
</a>

</div>

</div>



<!-- Bill Card -->

<div class="card">

<div class="card-body">


<!-- Bill Header -->

<div class="row mb-4">

<div class="col-md-6">

<h5>Hospital Pharmacy</h5>

<p>
Prescription No: {{ $bill->prescription->prescription_number }}<br>
Bill No: {{ $bill->bill_number }}<br>
Bill Date: {{ $bill->created_at }}
</p>

</div>


<div class="col-md-6 text-end">

<p>

Patient: {{ $bill->patient->name }} <br>
Phone: {{ $bill->patient->phone ?? '-' }}

</p>

</div>

</div>



<!-- Medicine Table -->

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
$total = $item->quantity * $item->price;
$subtotal += $total;
@endphp

<tr>

<td>{{ $key+1 }}</td>

<td>{{ $item->medicine->name }}</td>

<td>{{ $item->quantity }}</td>

<td>{{ $item->price }}</td>

<td>{{ $total }}</td>

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
<td>{{ $subtotal }}</td>
</tr>

<tr>
<th>GST (5%)</th>
<td>{{ $subtotal * 0.05 }}</td>
</tr>

<tr>
<th>Total Amount</th>
<td>
<strong>
{{ $subtotal + ($subtotal * 0.05) }}
</strong>
</td>
</tr>

</table>

</div>

</div>


</div>

</div>

</div>

@endsection