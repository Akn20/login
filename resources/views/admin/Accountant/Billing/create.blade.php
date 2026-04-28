@extends('layouts.admin')

@section('content')
<div class="container-fluid">

<form method="POST" action="{{ route('admin.accountant.billing.store') }}">
    @csrf

    <h3 class="mb-4">Create IPD Billing</h3>

    {{-- HIDDEN --}}
    <input type="hidden" name="patient_id" value="{{ $patient->patient_id }}">
    <input type="hidden" name="ipd_id" value="{{ $patient->ipd_id }}">

    {{-- ================= PATIENT DETAILS ================= --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Patient Details</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"><strong>Name:</strong> {{ $patient->name }}</div>
                <div class="col-md-3"><strong>IPD:</strong> {{ $patient->admission_id }}</div>
                <div class="col-md-3"><strong>Doctor:</strong> {{ $patient->doctor }}</div>
                <div class="col-md-3"><strong>Room:</strong> {{ $patient->room }}</div>
                <div class="col-md-3 mt-2">
                    <strong>Advance:</strong> ₹{{ $patient->advance_amount }}
                </div>
            </div>
        </div>
    </div>

    {{-- ================= CHARGES ================= --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <span>Charges</span>
            <button type="button" class="btn btn-success btn-sm" onclick="addCharge()">
                + Add Charge
            </button>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="chargesTable">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Description</th>
                        <th>QTY</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                <tr>
                    <td>
                        <input type="text" name="items[0][type]" value="Pharmacy" class="form-control" readonly>
                    </td>
                    <td>
                        <input type="text" name="items[0][description]" value="Pharmacy Charges" class="form-control">
                    </td>
                    <td>
                        <input type="number" name="items[0][quantity]" class="form-control qty" value="1">
                    </td>
                    <td>
                        <input type="number" name="items[0][amount]" class="form-control amount" value="0" oninput="calculateTotal()">
                    </td>
                    <td>-</td>
                </tr>

                <tr>
                    <td>
                        <input type="text" name="items[1][type]" value="Service" class="form-control" readonly>
                    </td>
                    <td>
                        <input type="text" name="items[1][description]" value="Service Charges" class="form-control">
                    </td>
                    <td>
                        <input type="number" name="items[1][quantity]" class="form-control qty" value="1">
                    </td>
                    <td>
                        <input type="number" name="items[1][amount]" class="form-control amount" value="0" oninput="calculateTotal()">
                    </td>
                    <td>-</td>
                </tr>

                <tr>
                    <td>
                        <input type="text" name="items[2][type]" value="Lab" class="form-control" readonly>
                    </td>
                    <td>
                        <input type="text" name="items[2][description]" value="Lab Charges" class="form-control">
                    </td>
                    <td>
                        <input type="number" name="items[2][quantity]" class="form-control qty" value="1">
                    </td>
                    <td>
                        <input type="number" name="items[2][amount]" class="form-control amount" value="0" oninput="calculateTotal()">
                    </td>
                    <td>-</td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= SUMMARY ================= --}}
    <div class="card">
        <div class="card-header">Bill Summary</div>
        <div class="card-body">

            <div class="row">

                <div class="col-md-3">
                    <label>Total</label>
                    <input type="text" id="total" name="total" class="form-control" readonly>
                </div>

                <div class="col-md-3">
                    <label>Discount</label>
                    <input type="number" name="discount" id="discount" class="form-control" value="0">
                </div>

                <div class="col-md-3">
                    <label>Tax</label>
                    <input type="number" name="tax" id="tax" class="form-control" value="0">
                </div>

                <div class="col-md-3">
                    <label>Advance</label>
                    <input type="text" id="advance" value="{{ $patient->advance_amount }}" class="form-control" readonly>
                </div>

                <div class="col-md-3 mt-3">
                    <label>Grand Total</label>
                    <input type="text" id="grand_total" name="grand_total" class="form-control" readonly>
                </div>

            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary">Save Bill</button>
            </div>

        </div>
    </div>

</form>

</div>

{{-- ================= SCRIPT ================= --}}
<script>

// ADD EXTRA ROW
function addCharge() {

    let index = document.querySelectorAll('#chargesTable tbody tr').length;

    let row = `
        <tr>
            <td>
                <input type="text" name="items[${index}][type]" class="form-control">
            </td>

            <td>
                <input type="text" name="items[${index}][description]" class="form-control">
            </td>

            <td>
                <input type="number" name="items[${index}][quantity]" class="form-control" value="1">
            </td>

            <td>
                <input type="number" name="items[${index}][amount]" class="form-control amount" value="0" oninput="calculateTotal()">
            </td>

            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>
            </td>
        </tr>
    `;

    document.querySelector('#chargesTable tbody').insertAdjacentHTML('beforeend', row);
}   

// REMOVE ROW
function removeRow(btn){
    btn.closest('tr').remove();
    calculateTotal();
}


// TOTAL CALCULATION
function calculateTotal(){

    let total = 0;

    document.querySelectorAll('.amount').forEach(el=>{
        total += parseFloat(el.value) || 0;
    });

    document.getElementById('total').value = total;

    let discount = parseFloat(document.getElementById('discount').value) || 0;
    let tax = parseFloat(document.getElementById('tax').value) || 0;
    let advance = parseFloat(document.getElementById('advance').value) || 0;

    let grand = total - discount + tax - advance;

    document.getElementById('grand_total').value = grand;
}


// AUTO RUN ON LOAD
document.addEventListener('DOMContentLoaded', calculateTotal);

// AUTO UPDATE
document.getElementById('discount').addEventListener('input', calculateTotal);
document.getElementById('tax').addEventListener('input', calculateTotal);

</script>

@endsection