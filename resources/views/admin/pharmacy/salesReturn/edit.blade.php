@extends('layouts.admin')

@section('title', 'Edit Sales Return')

@section('content')
<div class="container-fluid">

<h4>Edit Sales Return</h4>

{{-- HEADER INFO --}}
<div class="card mb-3">
<div class="card-body">
<div class="row">

<div class="col-md-3">
<small>Return No</small><br>
<strong>{{ $salesReturn->return_number }}</strong>
</div>

<div class="col-md-3">
<small>Bill No</small><br>
<strong>{{ $salesReturn->bill->bill_number ?? '-' }}</strong>
</div>

<div class="col-md-3">
<small>Patient</small><br>
<strong>{{ $salesReturn->patient_id ?? '-' }}</strong>
</div>

<div class="col-md-3">
<small>Status</small><br>
<span class="badge bg-secondary">
{{ $salesReturn->status }}
</span>
</div>

</div>
</div>
</div>


<form method="POST" action="{{ route('admin.salesReturn.update',$salesReturn->id) }}">
@csrf
@method('PUT')


{{-- RETURN ITEMS --}}
<div class="card mb-3">
<div class="card-header">
Edit Returned Items
</div>

<div class="card-body">

<table class="table table-bordered">

<thead>
<tr>
<th>#</th>
<th>Medicine</th>
<th>Batch</th>
<th>Return Qty</th>
<th>Unit Price</th>
<th>Refund</th>
<th>Reason</th>
</tr>
</thead>

<tbody>

@foreach($salesReturn->items as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item->medicine->medicine_name ?? '-' }}</td>

<td>{{ $item->batch->batch_number ?? '-' }}</td>


{{-- RETURN QTY --}}
<td>

<input type="number"
name="items[{{ $item->id }}][return_qty]"
value="{{ $item->quantity }}"
class="form-control qty-input"
data-sold="{{ $item->quantity }}"
min="0"
@if($salesReturn->status=='Approved') disabled @endif
>

</td>


{{-- UNIT PRICE --}}
<td>

₹ {{ $item->quantity ? $item->refund_amount / $item->quantity : 0 }}

<input type="hidden"
class="unit-price"
name="items[{{ $item->id }}][unit_price]"
value="{{ $item->quantity ? $item->refund_amount / $item->quantity : 0 }}">

</td>


{{-- REFUND --}}
<td>

<input type="text"
class="form-control refund-amount"
value="{{ number_format($item->refund_amount,2) }}"
readonly>

</td>


{{-- REASON --}}
<td>

<input type="text"
name="items[{{ $item->id }}][reason]"
value="{{ $item->reason ?? '' }}"
class="form-control"
@if($salesReturn->status=='Approved') disabled @endif
>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>
</div>


{{-- REFUND DETAILS --}}
<div class="card mb-3">

<div class="card-header">
Refund Details
</div>

<div class="card-body">

<div class="row">

<div class="col-md-4">

<label>Refund Mode</label>

<select name="refund_mode" class="form-select">

<option value="Cash" {{ $salesReturn->refund_mode=='Cash'?'selected':'' }}>Cash</option>
<option value="Card" {{ $salesReturn->refund_mode=='Card'?'selected':'' }}>Card</option>
<option value="UPI" {{ $salesReturn->refund_mode=='UPI'?'selected':'' }}>UPI</option>
<option value="Wallet" {{ $salesReturn->refund_mode=='Wallet'?'selected':'' }}>Wallet</option>

</select>

</div>


<div class="col-md-4">

<label>Reference</label>

<input type="text"
name="refund_reference"
value="{{ $salesReturn->refund_reference }}"
class="form-control">

</div>


<div class="col-md-4">

<label>Remarks</label>

<input type="text"
name="remarks"
value="{{ $salesReturn->remarks }}"
class="form-control">

</div>


</div>
</div>
</div>


{{-- BUTTONS --}}
<div class="text-end d-flex justify-content-end gap-2">

<button type="submit"
name="status"
value="Draft"
class="btn btn-secondary">

Update Draft

</button>


<button type="submit"
name="status"
value="Submitted"
class="btn btn-success">

Submit

</button>

</div>

</form>

</div>


{{-- SCRIPT --}}
<script>

document.addEventListener("DOMContentLoaded",function(){

document.querySelectorAll(".qty-input").forEach(function(input){

const row=input.closest("tr");

const price=row.querySelector(".unit-price");

const refund=row.querySelector(".refund-amount");

const soldQty=parseFloat(input.dataset.sold)||0;

input.addEventListener("input",function(){

let qty=parseFloat(this.value)||0;

let unitPrice=parseFloat(price.value)||0;


if(qty>soldQty){

alert("Return quantity cannot exceed sold quantity ("+soldQty+")");

this.value=soldQty;

qty=soldQty;

}


if(qty<0){

this.value=0;

qty=0;

}


refund.value=(qty*unitPrice).toFixed(2);

});

});

});

</script>

@endsection