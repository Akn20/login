@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4">Edit IPD Billing</h3>

    {{-- ================= PATIENT DETAILS ================= --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Patient Details
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"><strong>Name:</strong> {{ $patient['name'] }}</div>
                <div class="col-md-3"><strong>IPD No:</strong> {{ $patient['ipd_no'] }}</div>
                <div class="col-md-3"><strong>Doctor:</strong> {{ $patient['doctor'] }}</div>
                <div class="col-md-3"><strong>Room:</strong> {{ $patient['room'] }}</div>
                <div class="col-md-3 mt-2"><strong>Admission Date:</strong> {{ $patient['admission_date'] }}</div>
            </div>
        </div>
    </div>

    {{-- ================= CHARGES SECTION ================= --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <span>Charges</span>
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addChargeModal">
                + Add Charge
            </button>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="chargesTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($charges as $c)
                    <tr>
                        <td>{{ $c['date'] }}</td>
                        <td>{{ $c['type'] }}</td>
                        <td>{{ $c['description'] }}</td>
                        <td>{{ $c['qty'] }}</td>
                        <td>{{ $c['rate'] }}</td>
                        <td class="amount">{{ $c['amount'] }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>
                        </td>
                    </tr>
                    @endforeach
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
                    <input type="text" id="total" class="form-control" readonly>
                </div>

                <div class="col-md-3">
                    <label>Discount</label>
                    <input type="number" id="discount" class="form-control" value="0">
                </div>

                <div class="col-md-3">
                    <label>Tax</label>
                    <input type="number" id="tax" class="form-control" value="0">
                </div>

                <div class="col-md-3">
                    <label>Grand Total</label>
                    <input type="text" id="grand_total" class="form-control" readonly>
                </div>

            </div>

            <div class="mt-4 text-end">
                <button class="btn btn-primary">Update Bill</button>
                <button class="btn btn-success">Generate Final Bill</button>
            </div>
        </div>
    </div>

</div>

{{-- ================= MODAL ================= --}}
<div class="modal fade" id="addChargeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Add Charge</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-2">
                    <label>Type</label>
                    <select id="type" class="form-control">
                        <option>Room</option>
                        <option>Lab</option>
                        <option>Pharmacy</option>
                        <option>Service</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label>Description</label>
                    <input type="text" id="description" class="form-control">
                </div>

                <div class="mb-2">
                    <label>Quantity</label>
                    <input type="number" id="qty" class="form-control" value="1">
                </div>

                <div class="mb-2">
                    <label>Rate</label>
                    <input type="number" id="rate" class="form-control">
                </div>

                <div class="mb-2">
                    <label>Amount</label>
                    <input type="text" id="amount" class="form-control" readonly>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" onclick="addCharge()">Add</button>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

// Initial calculation on page load
window.onload = calculateTotal;

// Auto calc
document.getElementById('qty').addEventListener('input', calcAmount);
document.getElementById('rate').addEventListener('input', calcAmount);

function calcAmount() {
    let qty = document.getElementById('qty').value || 0;
    let rate = document.getElementById('rate').value || 0;
    document.getElementById('amount').value = qty * rate;
}

// Add new row
function addCharge() {
    let type = document.getElementById('type').value;
    let desc = document.getElementById('description').value;
    let qty = document.getElementById('qty').value;
    let rate = document.getElementById('rate').value;
    let amount = document.getElementById('amount').value;

    let row = `
        <tr>
            <td>${new Date().toLocaleDateString()}</td>
            <td>${type}</td>
            <td>${desc}</td>
            <td>${qty}</td>
            <td>${rate}</td>
            <td class="amount">${amount}</td>
            <td><button class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
        </tr>
    `;

    document.querySelector('#chargesTable tbody').insertAdjacentHTML('beforeend', row);

    calculateTotal();
}

// Remove
function removeRow(btn) {
    btn.closest('tr').remove();
    calculateTotal();
}

// Total
function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.amount').forEach(el => {
        total += parseFloat(el.innerText) || 0;
    });

    document.getElementById('total').value = total;

    let discount = document.getElementById('discount').value || 0;
    let tax = document.getElementById('tax').value || 0;

    let grand = total - discount + parseFloat(tax);
    document.getElementById('grand_total').value = grand;
}

document.getElementById('discount').addEventListener('input', calculateTotal);
document.getElementById('tax').addEventListener('input', calculateTotal);

</script>
@endsection