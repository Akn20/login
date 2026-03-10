{{-- resources/views/admin/pharmacy/prescriptions/dispense.blade.php --}}

@extends('layouts.admin')

@section('title','Dispense Medicines')

@section('content')

<div class="container-fluid">

<!-- Page Header -->

<div class="d-flex justify-content-between align-items-center mb-3">

<div>
<h4 class="mb-0">Dispense Medicines</h4>
<small class="text-muted">Pharmacy → Prescription → Dispense</small>
</div>

<a href="{{ route('admin.prescriptions.index') }}" class="btn btn-secondary">
Back
</a>

</div>


<!-- Prescription Summary -->

<div class="card mb-3">

<div class="card-header">
<strong>Prescription Information</strong>
</div>

<div class="card-body">

<div class="row">

<div class="col-md-4">
<strong>Prescription No:</strong>
{{ $prescription->prescription_number ?? '-' }}
</div>

<div class="col-md-4">
<strong>Patient Name:</strong>
{{ $prescription->patient->name ?? '-' }}
</div>

<div class="col-md-4">
<strong>Doctor:</strong>
{{ $prescription->doctor->name ?? 'Offline Doctor' }}
</div>

</div>

</div>

</div>



<form action="{{ route('admin.prescriptions.dispense.store',$prescription->id ?? 0) }}" method="POST">

@csrf


<!-- Medicines Table -->

<div class="card">

<div class="card-header">
<strong>Medicines to Dispense</strong>
</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered">

<thead>

<tr>
<th>#</th>
<th>Medicine</th>
<th>Required Qty</th>
<th>Select Batch</th>
<th>Available Stock</th>
<th>Dispense Qty</th>
</tr>

</thead>


<tbody>

@forelse($prescription->items ?? [] as $key => $item)

<tr>

<td>{{ $key+1 }}</td>

<td>{{ $item->medicine->name ?? '-' }}</td>

<td>{{ $item->quantity ?? 0 }}</td>


<td>

<select name="batch_id[]" class="form-control batchSelect">

<option value="">Select Batch</option>

@foreach($item->medicine->batches ?? [] as $batch)

<option value="{{ $batch->id }}"
data-stock="{{ $batch->quantity_available }}"
data-expiry="{{ $batch->expiry_date }}">

{{ $batch->batch_number }} | Exp: {{ $batch->expiry_date }}

</option>

@endforeach

</select>

</td>


<td class="stockCell">0</td>

<td>

<input type="number"
name="dispense_qty[]"
class="form-control qtyInput"
max="{{ $item->quantity ?? 0 }}"
>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="text-center text-muted">
No medicines available
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>



<!-- Submit -->

<div class="mt-3">

<button class="btn btn-success">
Dispense Medicines
</button>

</div>

</form>


</div>



<script>

document.querySelectorAll(".batchSelect").forEach(select => {

select.addEventListener("change", function(){

let stock = this.options[this.selectedIndex].getAttribute("data-stock");

let row = this.closest("tr");

row.querySelector(".stockCell").innerText = stock ?? 0;

});

});

</script>

@endsection