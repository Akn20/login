@extends('layouts.admin')

@section('title', 'Create Invoice')

@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Create Invoice</h4>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.pharmacy.billing.index') }}" class="btn btn-light">
                Back
            </a>
            <button type="submit" form="billingForm" class="btn btn-primary">
                Save Invoice
            </button>
        </div>
    </div>

    <form id="billingForm" action="{{ route('admin.pharmacy.billing.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-lg-8">

                {{-- Invoice Details --}}
                <div class="card mb-3">
                    <div class="card-body row g-3">

                        <div class="col-md-6">
                            <label>Patient</label>
                            <input type="text" name="patient_id" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label>Prescription</label>
                            <input type="text" name="prescription_id" class="form-control">
                        </div>

                    </div>
                </div>

                {{-- Items --}}
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Items</h5>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addRow()">Add Item</button>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered" id="itemsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="width: 180px;">Medicine</th>
                                    <th style="width: 140px;">Batch</th>
                                    <th style="width: 120px;">Qty</th>
                                    <th style="width: 120px;">Price</th>
                                    <th style="width: 120px;">Discount %</th>
                                    <th style="width: 120px;">Tax %</th>
                                    <th style="width: 150px;">Total</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr class="item-row">
                                    <td>1</td>

                                    {{-- Medicine --}}
                                    <td>
                                        <select name="items[0][medicine_id]" class="form-control">
                                            <option value="">Select Medicine</option>
                                            @foreach($medicines as $medicine)
                                                <option value="{{ $medicine->id }}">
                                                    {{ $medicine->medicine_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>


                                    {{-- Batch --}}
                                    <td>
                                        <select name="items[0][batch_id]" class="form-control">
                                            <option value="">Select Batch</option>
                                            @foreach($batches as $batch)
                                                <option value="{{ $batch->id }}">
                                                    {{ $batch->batch_number }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <input name="items[0][qty]" type="number" class="form-control qty">
                                    </td>

                                    <td>
                                        <input name="items[0][unit_price]" type="number" class="form-control price" >
                                    </td>

                                    <td>
                                        <input type="number" name="items[0][discount]" class="form-control discount">                                    
                                    </td>

                                    <td>
                                        <input type="number" name="items[0][tax_percent]" class="form-control tax">                                    
                                    </td>

                                    <td>
                                        <input type="number" name="items[0][line_total]" class="form-control line-total" readonly>
                                    </td>

                                    <td>
                                        <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">X</button>
                                    </td>
                                </tr>

                                
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Remarks --}}
                <div class="card mb-3">

                    <div class="mt-3">
                        <label>Total Amount</label>
                        <input type="text" id="grand_total" class="form-control" readonly>
                    </div>

                    <div class="card-body">
                        <textarea name="remarks" class="form-control" placeholder="Remarks"></textarea>
                    </div>
                </div>

            </div>

            {{-- RIGHT --}}
            <div class="col-lg-4">

                <div class="card mb-3">
                    <div class="card-body">

                        <label>Payment Status</label>
                        <select name="payment_status" class="form-control mb-2">
                            <option>Paid</option>
                            <option>Partially Paid</option>
                            <option>Unpaid</option>
                        </select>

                        <label>Payment Mode</label>
                        <select name="payment_mode" class="form-control mb-2">
                            <option>Cash</option>
                            <option>UPI</option>
                            <option>Card</option>
                        </select>

                        <label>Paid Amount</label>
                        <input type="number" name="paid_amount" class="form-control">

                    </div>
                </div>

            </div>
        </div>

    </form>
</div>

{{-- JS --}}
<script>

let index = 1;
/*
function addRow() {

    let row = `
        <tr>
            <td>${index + 1}</td>

            <td>
                <select name="items[${index}][medicine_id]" class="form-control" required>
                    @foreach($medicines as $med)
                        <option value="{{ $med->id }}">{{ $med->name }}</option>
                    @endforeach
                </select>
            </td>

            <td>
                <select name="items[${index}][batch_id]" class="form-control" required>
                    @foreach($batches as $batch)
                        <option value="{{ $batch->id }}">{{ $batch->batch_no }}</option>
                    @endforeach
                </select>
            </td>

            <td><input name="items[${index}][qty]" type="number" class="form-control qty"></td>
<td><input name="items[${index}][unit_price]" type="number" class="form-control price"></td>
<td><input name="items[${index}][total]" type="number" class="form-control total" readonly></td>

            <td>
                <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">X</button>
            </td>
        </tr>
        `;    
        
    document.querySelector('#itemsTable tbody').insertAdjacentHTML('beforeend', row);

    index++;
}
*/

function addRow() {

    let row = `
    <tr class="item-row">
        <td>${index + 1}</td>

        <td>
            <select name="items[${index}][medicine_id]" class="form-control">
                <option value="">Select</option>
                @foreach($medicines as $med)
                    <option value="{{ $med->id }}">{{ $med->medicine_name }}</option>
                @endforeach
            </select>
        </td>

        <td>
            <select name="items[${index}][batch_id]" class="form-control">
                <option value="">Select</option>
                @foreach($batches as $batch)
                    <option value="{{ $batch->id }}">{{ $batch->batch_number }}</option>
                @endforeach
            </select>
        </td>

        <td><input name="items[${index}][qty]" type="number" class="form-control qty"></td>

        <td><input name="items[${index}][unit_price]" type="number" class="form-control price"></td>

        <td><input name="items[${index}][discount]" type="number" class="form-control discount"></td>

        <td><input name="items[${index}][tax_percent]" type="number" class="form-control tax"></td>

        <td><input name="items[${index}][line_total]" type="number" class="form-control line-total" readonly></td>

        <td>
            <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">X</button>
        </td>
    </tr>
    `;

    document.querySelector('#itemsTable tbody').insertAdjacentHTML('beforeend', row);

    index++;
}


function removeRow(btn) {
    btn.closest('tr').remove();
}

/*
function calcRow(el) {
    let row = el.closest('tr');

    let qty = row.querySelector('.qty').value || 0;
    let price = row.querySelector('.price').value || 0;

    row.querySelector('.total').value = qty * price;
}
*/

</script>

<script>
document.addEventListener('input', function (e) {

    if (
        e.target.classList.contains('qty') ||
        e.target.classList.contains('price') ||
        e.target.classList.contains('discount') ||
        e.target.classList.contains('tax')
    ) {
        calculateTotals();
    }
});

function calculateTotals() {

    let grandTotal = 0;

    document.querySelectorAll('.item-row').forEach(row => {

        let qty = parseFloat(row.querySelector('.qty')?.value) || 0;
        let price = parseFloat(row.querySelector('.price')?.value) || 0;
        let discount = parseFloat(row.querySelector('.discount')?.value) || 0;
        let tax = parseFloat(row.querySelector('.tax')?.value) || 0;

        let subtotal = qty * price;

        let discountAmount = (subtotal * discount) / 100;
        let afterDiscount = subtotal - discountAmount;

        let taxAmount = (afterDiscount * tax) / 100;

        let lineTotal = afterDiscount + taxAmount;

        // ✅ set line total in UI
        row.querySelector('.line-total').value = lineTotal.toFixed(2);

        grandTotal += lineTotal;
    });

    // ✅ set grand total
    document.getElementById('grand_total').value = grandTotal.toFixed(2);
}
</script>

<style>
#itemsTable input,
#itemsTable select {
    width: 100% !important;
    min-width: 120px;
}

#itemsTable td {
    vertical-align: middle;
}
</style>

@endsection