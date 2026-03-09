{{-- resources/views/admin/pharmacy/prescriptions/create.blade.php --}}
@extends('layouts.admin')

@section('title','Offline Prescription Entry')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Offline Prescription Entry</h4>
            <small class="text-muted">Pharmacy → Prescriptions → Offline Entry</small>
        </div>

        <a href="{{ route('admin.prescriptions.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>


<form method="POST" enctype="multipart/form-data">

@csrf

<!-- Patient & Doctor Details -->

<div class="card mb-3">

<div class="card-header">
<strong>Prescription Details</strong>
</div>

<div class="card-body">

<div class="row">

<div class="col-md-4">
<label>Patient Name</label>
<input type="text" name="patient_name" class="form-control" placeholder="Enter Patient Name">
</div>

<div class="col-md-4">
<label>Patient Phone</label>
<input type="text" name="patient_phone" class="form-control" placeholder="Phone Number">
</div>

<div class="col-md-4">
<label>Prescription Date</label>
<input type="date" name="prescription_date" class="form-control">
</div>

</div>


<div class="row mt-3">

<div class="col-md-6">
<label>Doctor Name</label>
<input type="text" name="doctor_name" class="form-control" placeholder="Doctor Name">
</div>

<div class="col-md-6">
<label>Clinic / Hospital Name</label>
<input type="text" name="clinic_name" class="form-control" placeholder="Clinic / Hospital">
</div>

</div>

</div>

</div>



<!-- Upload Prescription -->

<div class="card mb-3">

<div class="card-header">
<strong>Upload Prescription</strong>
</div>

<div class="card-body">

<input type="file" name="prescription_image" class="form-control">

</div>

</div>



<!-- Medicines -->

<div class="card">

<div class="card-header d-flex justify-content-between">

<strong>Medicines</strong>

<button type="button" class="btn btn-sm btn-primary" onclick="addMedicineRow()">
Add Medicine
</button>

</div>


<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered" id="medicineTable">

<thead>

<tr>
<th>Medicine</th>
<th>Dosage</th>
<th>Frequency</th>
<th>Duration</th>
<th>Quantity</th>
<th>Instructions</th>
<th width="50">Action</th>
</tr>

</thead>


<tbody>

<tr>

<td>
<input type="text" name="medicine_name[]" class="form-control" placeholder="Medicine Name">
</td>

<td>
<input type="text" name="dosage[]" class="form-control" placeholder="Dosage">
</td>

<td>
<input type="text" name="frequency[]" class="form-control" placeholder="Frequency">
</td>

<td>
<input type="text" name="duration[]" class="form-control" placeholder="Duration">
</td>

<td>
<input type="number" name="quantity[]" class="form-control" placeholder="Qty">
</td>

<td>
<input type="text" name="instructions[]" class="form-control" placeholder="Instructions">
</td>

<td>
<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
X
</button>
</td>

</tr>

</tbody>

</table>

</div>

</div>

</div>



<!-- Save Button -->

<div class="mt-3">

<button type="submit" class="btn btn-success">
Save Prescription
</button>

<a href="{{ route('admin.prescriptions.index') }}" class="btn btn-secondary">
Cancel
</a>

</div>


</form>

</div>


<script>

function addMedicineRow()
{

let table = document.getElementById("medicineTable");

let row = table.insertRow();

row.innerHTML = `

<td><input type="text" name="medicine_name[]" class="form-control"></td>
<td><input type="text" name="dosage[]" class="form-control"></td>
<td><input type="text" name="frequency[]" class="form-control"></td>
<td><input type="text" name="duration[]" class="form-control"></td>
<td><input type="number" name="quantity[]" class="form-control"></td>
<td><input type="text" name="instructions[]" class="form-control"></td>
<td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>

`;

}

function removeRow(button)
{
button.closest("tr").remove();
}

</script>

@endsection