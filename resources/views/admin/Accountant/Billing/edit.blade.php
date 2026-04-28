@extends('layouts.admin')

@section('content')
<div class="container-fluid">

<form method="POST" action="{{ route('admin.accountant.billing.update', $bill->id) }}">
    @csrf

    <h3 class="mb-4">Edit IPD Billing</h3>

    {{-- PATIENT DETAILS --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Patient Details</div>
        <div class="card-body">
            <p><strong>Patient:</strong> {{ $bill->patient->first_name ?? '' }} {{ $bill->patient->last_name ?? '' }}</p>
            <p><strong>Bill No:</strong> {{ $bill->bill_no }}</p>
        </div>
    </div>

    {{-- CHARGES --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <span>Charges</span>
            <button type="button" class="btn btn-success btn-sm" onclick="addCharge()">+ Add</button>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="chargesTable">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($bill->items as $item)
                    <tr>
                        <td><input type="text" name="items[][type]" value="{{ $item->type }}" class="form-control"></td>
                        <td><input type="text" name="items[][description]" value="{{ $item->description }}" class="form-control"></td>
                        <td><input type="number" name="items[][quantity]" value="{{ $item->quantity }}" class="form-control qty" oninput="calc(this)"></td>
                        <td><input type="number" name="items[][rate]" value="{{ $item->rate }}" class="form-control rate" oninput="calc(this)"></td>
                        <td><input type="text" name="items[][amount]" value="{{ $item->amount }}" class="form-control amount" readonly></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    {{-- SUMMARY --}}
    <div class="card">
        <div class="card-body row">
            <div class="col-md-3">
                <label>Total</label>
                <input type="text" id="total" class="form-control" value="{{ $bill->total_amount }}" readonly>
            </div>
            <div class="col-md-3">
                <label>Discount</label>
                <input type="number" name="discount" id="discount" value="{{ $bill->discount }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Tax</label>
                <input type="number" name="tax" id="tax" value="{{ $bill->tax }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Grand Total</label>
                <input type="text" id="grand_total" value="{{ $bill->grand_total }}" class="form-control" readonly>
            </div>
        </div>

        <div class="text-end p-3">
            <button type="submit" class="btn btn-primary">Update Bill</button>
        </div>
    </div>

</form>

</div>

<script>
function addCharge(){
    let row = `
    <tr>
        <td><input name="items[][type]" class="form-control"></td>
        <td><input name="items[][description]" class="form-control"></td>
        <td><input name="items[][quantity]" class="form-control qty" oninput="calc(this)"></td>
        <td><input name="items[][rate]" class="form-control rate" oninput="calc(this)"></td>
        <td><input name="items[][amount]" class="form-control amount" readonly></td>
        <td><button type="button" onclick="removeRow(this)">X</button></td>
    </tr>`;
    document.querySelector('#chargesTable tbody').insertAdjacentHTML('beforeend', row);
}

function calc(el){
    let row = el.closest('tr');
    let qty = row.querySelector('.qty').value || 0;
    let rate = row.querySelector('.rate').value || 0;
    let amount = qty * rate;
    row.querySelector('.amount').value = amount;
    calculateTotal();
}

function removeRow(btn){
    btn.closest('tr').remove();
    calculateTotal();
}

function calculateTotal(){
    let total = 0;
    document.querySelectorAll('.amount').forEach(el=>{
        total += parseFloat(el.value) || 0;
    });

    document.getElementById('total').value = total;

    let discount = parseFloat(document.getElementById('discount').value) || 0;
    let tax = parseFloat(document.getElementById('tax').value) || 0;

    document.getElementById('grand_total').value = total - discount + tax;
}

document.getElementById('discount').addEventListener('input', calculateTotal);
document.getElementById('tax').addEventListener('input', calculateTotal);
</script>

@endsection