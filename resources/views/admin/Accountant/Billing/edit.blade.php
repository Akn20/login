@extends('layouts.admin')

@section('content')
<div class="container-fluid">

<form method="POST" action="{{ route('admin.accountant.billing.update', $bill->id) }}">
    @csrf
    @method('PUT')

    <h3 class="mb-4">Edit IPD Billing</h3>

    {{-- HIDDEN --}}
    <input type="hidden" name="patient_id" value="{{ $patient->patient_id }}">
    <input type="hidden" name="ipd_id" value="{{ $patient->ipd_id }}">

    {{-- ================= PATIENT ================= --}}
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

    @php $index = 0; @endphp

    {{-- ================= PHARMACY ================= --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Pharmacy Charges</strong></div>
        <div class="card-body table-responsive">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($pharmacyItems as $item)

                @php
                    $existing = $bill->items
                        ->where('type','Pharmacy')
                        ->where('description',$item->medicine_name)
                        ->first();

                    $total = $existing->amount ?? ($item->qty * $item->price);
                @endphp

                <tr>
                    <td>
                        {{ $item->medicine_name }}
                        <input type="hidden" name="items[{{ $index }}][type]" value="Pharmacy">
                        <input type="hidden" name="items[{{ $index }}][description]" value="{{ $item->medicine_name }}">
                        <input type="hidden" name="items[{{ $index }}][reference_id]" value="">
                    </td>

                    <td>
                        <input type="number" name="items[{{ $index }}][quantity]"
                               value="{{ $item->qty }}" class="form-control" readonly>
                    </td>

                    <td>
                        <input type="number" name="items[{{ $index }}][rate]"
                               value="{{ $item->price }}" class="form-control" readonly>
                    </td>

                    <td>
                        <input type="number" name="items[{{ $index }}][amount]"
                               value="{{ $total }}" class="form-control amount" readonly>
                    </td>
                </tr>

                @php $index++; @endphp
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

    {{-- ================= LAB ================= --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Lab Tests</strong></div>
        <div class="card-body">

            @foreach($labItems as $lab)

            @php
                $existing = $bill->items
                    ->where('type','Lab')
                    ->where('description',$lab->test_name)
                    ->first();

                $amount = $existing->amount ?? $lab->price;
            @endphp

            <div class="row mb-2">
                <div class="col-md-6">
                    {{ $lab->test_name }}
                    <input type="hidden" name="items[{{ $index }}][type]" value="Lab">
                    <input type="hidden" name="items[{{ $index }}][description]" value="{{ $lab->test_name }}">
                    <input type="hidden" name="items[{{ $index }}][reference_id]" value="{{ $lab->test_name }}">
                </div>

                <div class="col-md-3">
                    <input type="number" name="items[{{ $index }}][amount]"
                           value="{{ $amount }}" class="form-control amount" readonly>
                </div>
            </div>

            @php $index++; @endphp
            @endforeach

        </div>
    </div>

    {{-- ================= SCAN ================= --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Scan</strong></div>
        <div class="card-body">

            @foreach($scanItems as $scan)

            @php
                $existing = $bill->items
                    ->where('type','Scan')
                    ->where('description',$scan->scan_name)
                    ->first();

                $amount = $existing->amount ?? 0;
            @endphp

            <div class="row mb-2">
                <div class="col-md-6">
                    {{ $scan->scan_name }}
                    <input type="hidden" name="items[{{ $index }}][type]" value="Scan">
                    <input type="hidden" name="items[{{ $index }}][description]" value="{{ $scan->scan_name }}">
                    <input type="hidden" name="items[{{ $index }}][reference_id]" value="{{ $scan->scan_name }}">
                </div>

                <div class="col-md-3">
                    <input type="number" name="items[{{ $index }}][amount]"
                           value="{{ $amount }}" class="form-control amount">
                </div>
            </div>

            @php $index++; @endphp
            @endforeach

        </div>
    </div>

    {{-- ================= ROOM ================= --}}
    @if($roomCharge)
    @php
        $existing = $bill->items->where('type','Room')->first();
        $amount = $existing->amount ?? 0;
    @endphp

    <div class="card mb-4">
        <div class="card-header"><strong>Room Charges</strong></div>
        <div class="card-body">

            Room: {{ $roomCharge->room_number }}

            <input type="hidden" name="items[{{ $index }}][type]" value="Room">
            <input type="hidden" name="items[{{ $index }}][description]" value="Room Charges">
            <input type="hidden" name="items[{{ $index }}][reference_id]" value="{{ $roomCharge->room_number }}">

            <input type="number" name="items[{{ $index }}][amount]"
                   value="{{ $amount }}" class="form-control amount mt-2">

        </div>
    </div>

    @php $index++; @endphp
    @endif

    {{-- ================= SERVICES ================= --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Other Services</strong></div>
        <div class="card-body">

            <div id="serviceSection">

                @foreach($bill->items->where('type','Service') as $service)
                <div class="row mb-2">
                    <div class="col-md-5">
                        <input type="text" name="items[{{ $index }}][description]"
                               value="{{ $service->description }}" class="form-control">
                        <input type="hidden" name="items[{{ $index }}][type]" value="Service">
                    </div>

                    <div class="col-md-3">
                        <input type="number" name="items[{{ $index }}][amount]"
                               value="{{ $service->amount }}"
                               class="form-control amount" oninput="calculateTotal()">
                    </div>
                </div>

                @php $index++; @endphp
                @endforeach

            </div>

            <button type="button" class="btn btn-success btn-sm" onclick="addService()">
                + Add Service
            </button>

        </div>
    </div>

    {{-- ================= SUMMARY ================= --}}
    <div class="card">
        <div class="card-body row">

            <div class="col-md-3">
                <label>Total</label>
                <input type="text" id="total" class="form-control" readonly>
            </div>

            <div class="col-md-3">
                <label>Discount %</label>
                <input type="number" name="discount" id="discount"
                       value="{{ $bill->discount_percent }}" class="form-control">
            </div>

            <div class="col-md-3">
                <label>Tax %</label>
                <input type="number" name="tax" id="tax"
                       value="{{ $bill->tax_percent }}" class="form-control">
            </div>

            <div class="col-md-3">
                <label>Advance</label>
                <input type="text" id="advance"
                       value="{{ $patient->advance_amount }}" class="form-control" readonly>
            </div>

            <div class="col-md-3 mt-3">
                <label>Grand Total</label>
                <input type="text" id="grand_total" name="grand_total" class="form-control" readonly>
            </div>

        </div>

        <div class="p-3">
            <textarea name="notes" class="form-control">{{ $bill->notes }}</textarea>
        </div>

        <div class="text-end p-3">
            <button class="btn btn-primary">Update Bill</button>
        </div>
    </div>

</form>
</div>

<script>
function calculateTotal(){
    let total = 0;
    document.querySelectorAll('.amount').forEach(el=>{
        total += parseFloat(el.value) || 0;
    });

    document.getElementById('total').value = total;

    let discount = document.getElementById('discount').value || 0;
    let tax = document.getElementById('tax').value || 0;
    let advance = document.getElementById('advance').value || 0;

    let d = total * discount / 100;
    let t = total * tax / 100;

    document.getElementById('grand_total').value = total - d + t - advance;
}

document.addEventListener('DOMContentLoaded', calculateTotal);
document.getElementById('discount').addEventListener('input', calculateTotal);
document.getElementById('tax').addEventListener('input', calculateTotal);

function addService(){
    let index = Date.now(); // always unique

    let html = `
    <div class="row mb-2">
        <div class="col-md-5">
            <input type="text" name="items[${index}][description]" class="form-control">
            <input type="hidden" name="items[${index}][type]" value="Service">
        </div>
        <div class="col-md-3">
            <input type="number" name="items[${index}][amount]" class="form-control amount" oninput="calculateTotal()">
        </div>
    </div>`;

    document.getElementById('serviceSection').insertAdjacentHTML('beforeend', html);
}
</script>

@endsection