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

        {{-- PATIENT INFO --}}
        <div class="card-body">

            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Patient Name:</strong> {{ $patient['name'] }}</p>
                    <p><strong>IPD No:</strong> {{ $patient['ipd_no'] }}</p>
                    <p><strong>Doctor:</strong> {{ $patient['doctor'] }}</p>
                </div>

                <div class="col-md-6 text-end">
                    <p><strong>Room:</strong> {{ $patient['room'] }}</p>
                    <p><strong>Admission Date:</strong> {{ $patient['admission_date'] }}</p>
                    <p><strong>Date:</strong> {{ date('d-m-Y') }}</p>
                </div>
            </div>

            {{-- CHARGES TABLE --}}
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>

                <tbody>
                    @php $i = 1; @endphp
                    @foreach($charges as $c)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $c['date'] }}</td>
                        <td>{{ $c['type'] }}</td>
                        <td>{{ $c['description'] }}</td>
                        <td>{{ $c['qty'] }}</td>
                        <td>{{ $c['rate'] }}</td>
                        <td>{{ $c['amount'] }}</td>
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
                            <td>{{ $summary['total'] }}</td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td>{{ $summary['discount'] }}</td>
                        </tr>
                        <tr>
                            <th>Tax</th>
                            <td>{{ $summary['tax'] }}</td>
                        </tr>
                        <tr class="table-success">
                            <th>Grand Total</th>
                            <td><strong>{{ $summary['grand_total'] }}</strong></td>
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