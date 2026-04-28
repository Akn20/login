@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- TOP ACTIONS --}}
    <div class="d-flex justify-content-between mb-3">
        <h3>Final Bill</h3>
        <div>
            <button onclick="window.print()" class="btn btn-primary btn-sm">
                Print
            </button>
        </div>
    </div>

    {{-- BILL CARD --}}
    <div class="card" id="printArea">

        {{-- HEADER --}}
        <div class="card-header text-center">
            <h4 class="mb-0">Hospital Name</h4>
            <small>Address | Phone | Email</small>
        </div>

        {{-- BODY --}}
        <div class="card-body">

            {{-- PATIENT INFO --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Patient Name:</strong> 
                        {{ $bill->patient->first_name ?? '' }} 
                        {{ $bill->patient->last_name ?? '' }}
                    </p>

                    <p><strong>Bill No:</strong> {{ $bill->bill_no }}</p>

                    <p><strong>Date:</strong> 
                        {{ \Carbon\Carbon::parse($bill->bill_date)->format('d-m-Y') }}
                    </p>
                </div>

                <div class="col-md-6 text-end">
                    <p><strong>Status:</strong> 
                        <span class="badge bg-success text-uppercase">
                            {{ $bill->status }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- CHARGES TABLE --}}
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($bill->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->rate }}</td>
                        <td>{{ $item->amount }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- SUMMARY --}}
            <div class="row mt-4">
                <div class="col-md-6"></div>

                <div class="col-md-6">
                    <table class="table table-bordered">

                        <tr>
                            <th>Total</th>
                            <td>{{ $bill->total_amount }}</td>
                        </tr>

                        <tr>
                            <th>Discount</th>
                            <td>{{ $bill->discount }}</td>
                        </tr>

                        <tr>
                            <th>Tax</th>
                            <td>{{ $bill->tax }}</td>
                        </tr>

                        <tr class="table-success">
                            <th>Grand Total</th>
                            <td><strong>{{ $bill->grand_total }}</strong></td>
                        </tr>

                        <tr class="table-warning">
                            <th>Advance Paid</th>
                            <td>
                                {{ optional($bill->ipd)->advance_amount ?? 0 }}
                            </td>
                        </tr>

                        <tr class="table-primary">
                            <th>Payable Amount</th>
                            <td><strong>{{ $bill->payable_amount }}</strong></td>
                        </tr>

                    </table>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="mt-5 text-center">
                <p>Thank you for choosing our hospital</p>
            </div>

        </div>
    </div>

</div>
@endsection


{{-- PRINT STYLES --}}
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
}
</style>