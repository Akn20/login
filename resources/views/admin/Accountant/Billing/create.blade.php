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
{{--Pharmacy --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Pharmacy Charges</strong>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Medicine</th>
                        <th width="120">Qty</th>
                        <th width="120">Price</th>
                        <th width="150">Total</th>
                    </tr>
                </thead>

                <tbody>

                    @php $index = 0; @endphp

                    @forelse($pharmacyItems as $item)
                    @php
                        $total = $item->qty * $item->price;
                    @endphp

                    <tr>
                        <td>
                            {{ $item->medicine_name }}

                            <input type="hidden" name="items[{{ $index }}][type]" value="Pharmacy">
                            <input type="hidden" name="items[{{ $index }}][description]" value="{{ $item->medicine_name }}">
                            <input type="hidden" name="items[{{ $index }}][reference_id]" value="{{ $item->medicine_id ?? '' }}">
                        </td>

                        <td>
                            <input type="number"
                                name="items[{{ $index }}][quantity]"
                                value="{{ $item->qty }}"
                                class="form-control qty"
                                readonly>
                        </td>

                        <td>
                            <input type="number"
                                name="items[{{ $index }}][rate]"
                                value="{{ $item->price }}"
                                class="form-control rate"
                                readonly>
                        </td>

                        <td>
                            <input type="number"
                                name="items[{{ $index }}][amount]"
                                value="{{ $total }}"
                                class="form-control amount"
                                readonly>
                        </td>
                    </tr>

                    @php $index++; @endphp

                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            No pharmacy records found
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>

        </div>
    </div>

{{--Lab --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Lab Tests</strong></div>
        <div class="card-body table-responsive">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Test Name</th>
                        <th width="150">Price</th>
                    </tr>
                </thead>

                <tbody>
                @php $index = count($pharmacyItems); @endphp

                @forelse($labItems as $lab)
                <tr>
                    <td>
                        {{ $lab->test_name }}

                        <input type="hidden" name="items[{{ $index }}][type]" value="Lab">
                        <input type="hidden" name="items[{{ $index }}][description]" value="{{ $lab->test_name }}">
                        <input type="hidden" name="items[{{ $index }}][reference_id]" value="{{ $lab->test_name }}">
                    </td>

                    <td>
                        <input type="number"
                            name="items[{{ $index }}][amount]"
                            value="{{ $lab->price }}"
                            class="form-control amount"
                            readonly>
                    </td>
                </tr>
                @php $index++; @endphp
                @empty
                <tr><td colspan="2" class="text-center">No Lab Tests</td></tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>

{{--Scan --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Radiology / Scan</strong></div>
        <div class="card-body table-responsive">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Scan Name</th>
                        <th width="150">Price</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($scanItems as $scan)
                <tr>
                    <td>
                        {{ $scan->scan_name }}

                        <input type="hidden" name="items[{{ $index }}][type]" value="Scan">
                        <input type="hidden" name="items[{{ $index }}][description]" value="{{ $scan->scan_name }}">
                        <input type="hidden" name="items[{{ $index }}][reference_id]" value="{{ $scan->scan_name }}">
                    </td>

                    <td>
                        <input type="number"
                            name="items[{{ $index }}][amount]"
                            value="0"
                            class="form-control amount">
                    </td>
                </tr>
                @php $index++; @endphp
                @empty
                <tr><td colspan="2" class="text-center">No Scans</td></tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>

{{--Room --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Room Charges</strong></div>
        <div class="card-body">

            @if($roomCharge)
            <div class="row">
                <div class="col-md-4">
                    Room: {{ $roomCharge->room_number }}
                </div>

                <div class="col-md-4">
                    From: {{ \Carbon\Carbon::parse($roomCharge->admission_date)->format('d-m-Y') }}
                </div>

                <div class="col-md-4">
                    To: {{ $roomCharge->discharge_date 
                            ? \Carbon\Carbon::parse($roomCharge->discharge_date)->format('d-m-Y') 
                            : 'Active' }}
                </div>

                <div class="col-md-4 mt-2">
                    <label>Room Charges</label>
                    <input type="number"
                        name="items[{{ $index }}][amount]"
                        class="form-control amount"
                        value="0">
                    <input type="hidden" name="items[{{ $index }}][type]" value="Room">
                    <input type="hidden" name="items[{{ $index }}][description]" value="Room Charges">
                    <input type="hidden" name="items[{{ $index }}][reference_id]" value="{{ $roomCharge->room_number }}">
                </div>
            </div>

            @php $index++; @endphp
            @endif

        </div>
    </div>

{{--Service --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Other / Service Charges</strong></div>
        <div class="card-body">

            <div id="serviceSection"></div>

            <button type="button" class="btn btn-sm btn-success" onclick="addService()">
                + Add Service
            </button>

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
                    <input type="number" name="discount" id="discount" class="form-control" value="0" placeholder="%">
                </div>

                <div class="col-md-3">
                    <label>Tax</label>
                    <input type="number" name="tax" id="tax" class="form-control" value="0" placeholder="%">
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

            <div class="col-md-12 mt-3">
                <label>Notes</label>
                <textarea name="notes" class="form-control" rows="3" placeholder="Enter remarks (optional)"></textarea>
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



// TOTAL CALCULATION
function calculateTotal(){

    let total = 0;

    document.querySelectorAll('input[name*="[amount]"]').forEach(el=>{
        total += parseFloat(el.value) || 0;
    });

    document.getElementById('total').value = total;

    let discountPercent = parseFloat(document.getElementById('discount').value) || 0;
    let taxPercent = parseFloat(document.getElementById('tax').value) || 0;
    let advance = parseFloat(document.getElementById('advance').value) || 0;

    let discount = (total * discountPercent) / 100;
    let tax = (total * taxPercent) / 100;

    let grand = total - discount + tax - advance;

    document.getElementById('grand_total').value = grand;
}

// AUTO RUN ON LOAD
document.addEventListener('DOMContentLoaded', calculateTotal);

// AUTO UPDATE
document.getElementById('discount').addEventListener('input', calculateTotal);
document.getElementById('tax').addEventListener('input', calculateTotal);

//SErvice
function addService() {

    let index = document.querySelectorAll('.amount').length;

    let html = `
        <div class="row mb-2">
            <div class="col-md-5">
                <input type="text" name="items[${index}][description]" placeholder="Service Name" class="form-control">
                <input type="hidden" name="items[${index}][type]" value="Service">
            </div>

            <div class="col-md-3">
                <input type="number" name="items[${index}][amount]" class="form-control amount" placeholder="Amount" oninput="calculateTotal()">
            </div>
        </div>
    `;

    document.getElementById('serviceSection').insertAdjacentHTML('beforeend', html);
}

</script>

@endsection