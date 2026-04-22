@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4">Create IPD Billing</h3>

    {{-- ================= SELECT PATIENT ================= --}}
    <div class="card mb-4">
        <div class="card-header">Select Patient</div>
        <div class="card-body">

            <select id="patientSelect" class="form-control">
                <option value="">-- Select Patient --</option>
                @foreach($patients as $p)
                    <option value="{{ $p['id'] }}"
                        data-name="{{ $p['name'] }}"
                        data-ipd="{{ $p['ipd_no'] }}"
                        data-doctor="{{ $p['doctor'] }}"
                        data-room="{{ $p['room'] }}"
                        data-date="{{ $p['admission_date'] }}">
                        {{ $p['name'] }} ({{ $p['ipd_no'] }})
                    </option>
                @endforeach
            </select>

        </div>
    </div>

    {{-- ================= PATIENT DETAILS ================= --}}
    <div class="card mb-4" id="patientCard" style="display:none;">
        <div class="card-header bg-primary text-white">Patient Details</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"><strong>Name:</strong> <span id="p_name"></span></div>
                <div class="col-md-3"><strong>IPD:</strong> <span id="p_ipd"></span></div>
                <div class="col-md-3"><strong>Doctor:</strong> <span id="p_doc"></span></div>
                <div class="col-md-3"><strong>Room:</strong> <span id="p_room"></span></div>
                <div class="col-md-3 mt-2"><strong>Date:</strong> <span id="p_date"></span></div>
            </div>
        </div>
    </div>

    {{-- ================= CHARGES ================= --}}
    <div class="card mb-4" id="chargesSection" style="display:none;">
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
                <tbody></tbody>
            </table>
        </div>
    </div>

    {{-- ================= SUMMARY ================= --}}
    <div class="card" id="summarySection" style="display:none;">
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
                <button class="btn btn-primary">Save Bill</button>
            </div>
        </div>
    </div>

</div>

{{-- ================= SCRIPT ================= --}}
<script>

document.getElementById('patientSelect').addEventListener('change', function() {
    let selected = this.options[this.selectedIndex];

    if (!this.value) return;

    // Show sections
    document.getElementById('patientCard').style.display = 'block';
    document.getElementById('chargesSection').style.display = 'block';
    document.getElementById('summarySection').style.display = 'block';

    // Fill details
    document.getElementById('p_name').innerText = selected.dataset.name;
    document.getElementById('p_ipd').innerText = selected.dataset.ipd;
    document.getElementById('p_doc').innerText = selected.dataset.doctor;
    document.getElementById('p_room').innerText = selected.dataset.room;
    document.getElementById('p_date').innerText = selected.dataset.date;

    // Simulate existing charges
    loadDummyCharges();
});

// Dummy charges (later replace with API)
function loadDummyCharges() {
    let table = document.querySelector('#chargesTable tbody');
    table.innerHTML = '';

    let data = [
        {type:'Room', desc:'Room Charge', qty:2, rate:2000},
        {type:'Lab', desc:'Blood Test', qty:1, rate:500},
    ];

    data.forEach(c => {
        let amount = c.qty * c.rate;

        let row = `
            <tr>
                <td>${new Date().toLocaleDateString()}</td>
                <td>${c.type}</td>
                <td>${c.desc}</td>
                <td>${c.qty}</td>
                <td>${c.rate}</td>
                <td class="amount">${amount}</td>
                <td><button class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
            </tr>
        `;

        table.insertAdjacentHTML('beforeend', row);
    });

    calculateTotal();
}

// Remove
function removeRow(btn){
    btn.closest('tr').remove();
    calculateTotal();
}

// Total
function calculateTotal(){
    let total = 0;
    document.querySelectorAll('.amount').forEach(el=>{
        total += parseFloat(el.innerText) || 0;
    });

    document.getElementById('total').value = total;

    let discount = document.getElementById('discount').value || 0;
    let tax = document.getElementById('tax').value || 0;

    document.getElementById('grand_total').value = total - discount + parseFloat(tax);
}

document.getElementById('discount').addEventListener('input', calculateTotal);
document.getElementById('tax').addEventListener('input', calculateTotal);

</script>

@endsection