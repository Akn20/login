@extends('layouts.admin')

@section('title', 'Edit Sales Bill')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
<div class="container-fluid">

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Edit Sales Bill</h4>
        <a href="{{ route('admin.pharmacy.billing.index') }}" class="btn btn-light">Back</a>
    </div>

    <form action="{{ route('admin.pharmacy.billing.update', $bill->bill_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">

                {{-- Patient & Prescription --}}
                <div class="card mb-3">
                    <div class="card-body row g-3">
                        <div class="col-md-6">
                            <label>Patient Name</label>
                            <input type="text" class="form-control"
                            value="{{ $bill->display_patient_name }}"
                            readonly>
                            <input type="hidden" name="patient_id" value="{{ $bill->patient_id }}">
                        </div>

                        
                    </div>
                </div>

                {{-- Items --}}
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Items</h5>
                       {{--   <button type="button" class="btn btn-sm btn-primary" onclick="addRow()">Add Item</button>--}}
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered" id="itemsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Medicine</th>
                                    <th>Batch</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bill->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <select name="items[{{ $index }}][medicine_id]" class="form-control" required>
                                            @foreach($medicines as $medicine)
                                                <option value="{{ $medicine->id }}" 
                                                    {{ $medicine->id == $item->medicine_id ? 'selected' : '' }}>
                                                    {{ $medicine->medicine_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <select name="items[{{ $index }}][batch_id]" class="form-control" required>
                                            @foreach($batches as $batch)
                                                <option value="{{ $batch->id }}" 
                                                    {{ $batch->id == $item->batch_id ? 'selected' : '' }}>
                                                    {{ $batch->batch_number }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td><input type="number" name="items[{{ $index }}][quantity]" class="form-control qty" value="{{ $item->quantity }}"></td>
                                    <td><input type="number" name="items[{{ $index }}][unit_price]" class="form-control price" value="{{ $item->unit_price }}"></td>
                                    <td><input type="number" name="items[{{ $index }}][total_price]" class="form-control total" value="{{ $item->total_price }}" readonly></td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Remarks --}}
                <div class="card mb-3">
                    <div class="card-body">
                        <label>Remarks</label>
                        <textarea name="remarks" class="form-control">{{ $bill->remarks }}</textarea>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                {{-- Payment --}}
                <div class="card mb-3">
                    <div class="card-body">
                        <label>Payment Status</label>
                        <select name="payment_status" class="form-control mb-2">
                            <option value="Paid" {{ $bill->payment_status=='Paid'?'selected':'' }}>Paid</option>
                            <option value="Partially Paid" {{ $bill->payment_status=='Partially Paid'?'selected':'' }}>Partially Paid</option>
                            <option value="Unpaid" {{ $bill->payment_status=='Unpaid'?'selected':'' }}>Unpaid</option>
                        </select>

                        <label>Payment Mode</label>
                        <input type="text" name="payment_mode" class="form-control mb-2" value="{{ $bill->payment_mode }}">

                        <label>Paid Amount</label>
                        <input type="number" name="paid_amount" class="form-control" value="{{ $bill->paid_amount }}">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Bill</button>
    </form>
</div>

<script>
let index = {{ $bill->items->count() }};

function addRow() {
    let row = `
        <tr>
            <td>${index + 1}</td>
            <td>
                <select name="items[${index}][medicine_id]" class="form-control" required>
                    @foreach($medicines as $med)
                        <option value="{{ $med->id }}">{{ $med->medicine_name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="items[${index}][batch_id]" class="form-control" required>
                    @foreach($batches as $batch)
                        <option value="{{ $batch->id }}">{{ $batch->batch_number }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="items[${index}][quantity]" class="form-control qty"></td>
            <td><input type="number" name="items[${index}][unit_price]" class="form-control price"></td>
            <td><input type="number" name="items[${index}][total_price]" class="form-control total" readonly></td>
            <td><button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">X</button></td>
        </tr>
    `;
    document.querySelector('#itemsTable tbody').insertAdjacentHTML('beforeend', row);
    index++;
}

function removeRow(btn) {
    btn.closest('tr').remove();
}

document.addEventListener('input', function (e) {
    if(e.target.classList.contains('qty') || e.target.classList.contains('price')) {
        let row = e.target.closest('tr');
        let qty = parseFloat(row.querySelector('.qty').value) || 0;
        let price = parseFloat(row.querySelector('.price').value) || 0;
        row.querySelector('.total').value = (qty * price).toFixed(2);
    }
});
</script>
@endsection