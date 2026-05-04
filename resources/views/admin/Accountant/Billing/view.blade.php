@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div id="printArea"> 
        <div class="text-center mb-3">
            <h4>Hospital Name</h4>
            <p>Address | Phone</p>
            <hr>
        </div>

    <h3 class="mb-4">IPD Billing Details</h3>

    {{-- ================= PATIENT DETAILS ================= --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Patient Details</div>
        <div class="card-body row">

            <div class="col-md-3"><strong>Name:</strong> {{ $bill->patient->first_name }} {{ $bill->patient->last_name }}</div>
            <div class="col-md-3"><strong>IPD ID:</strong> {{ $bill->ipd_id }}</div>
            <div class="col-md-3"><strong>Bill No:</strong> {{ $bill->bill_no }}</div>
            <div class="col-md-3"><strong>Status:</strong> 
                <span class="badge bg-{{ $bill->status == 'discharged' ? 'success' : 'warning' }}">
                    {{ ucfirst($bill->status) }}
                </span>
            </div>

            <div class="col-md-3 mt-2"><strong>Bill Date:</strong> {{ $bill->bill_date }}</div>
            <div class="col-md-3 mt-2"><strong>Advance:</strong> ₹{{ $bill->patient->ipdAdmission->advance_amount ?? 0 }}</div>

        </div>
    </div>

    {{-- ================= ITEMS ================= --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Charges</strong></div>
        <div class="card-body table-responsive">

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Type</th>
                        <th>Description</th>
                        <th width="100">Qty</th>
                        <th width="120">Rate</th>
                        <th width="120">Amount</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($bill->items as $item)
                    <tr>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                            ₹{{ number_format(
                                ($item->rate > 0 ? $item->rate : $item->amount),
                            2) }}
                        </td>
                        <td>₹{{ $item->amount }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    {{-- ================= SUMMARY ================= --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Bill Summary</strong></div>
        <div class="card-body row">

            <div class="col-md-3">
                <strong>Total:</strong> ₹{{ $bill->total_amount }}
            </div>

            <div class="col-md-3">
                <strong>Discount ({{ $bill->discount_percent }}%):</strong> ₹{{ $bill->discount }}
            </div>

            <div class="col-md-3">
                <strong>Tax ({{ $bill->tax_percent }}%):</strong> ₹{{ $bill->tax }}
            </div>

            <div class="col-md-3">
                <strong>Grand Total:</strong> ₹{{ $bill->grand_total }}
            </div>

            <div class="col-md-3 mt-2">
                <strong>Payable:</strong> ₹{{ $bill->payable_amount }}
            </div>

        </div>

        <div class="p-3">
            <strong>Notes:</strong>
            <p>{{ $bill->notes ?? '—' }}</p>
        </div>
    </div>

    {{-- ================= ACTION BUTTONS ================= --}}
    <div class="d-flex justify-content-end gap-2 no-print">

        <a href="{{ route('admin.accountant.billing.index') }}" class="btn btn-secondary">
            Back
        </a>

        <button onclick="window.print()" class="btn btn-success">
            Print
        </button>

        @if($bill->status != 'discharged')
            <a href="{{ route('admin.accountant.billing.edit', $bill->id) }}" class="btn btn-primary">
                Edit
            </a>
        @endif

    </div>
    </div>
</div>

<style>
@media print {

    body * {
        visibility: hidden;
    }

    #printArea, #printArea * {
        visibility: visible;
    }

    #printArea {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }

    .no-print {
        display: none !important;
    }
}
</style>
@endsection