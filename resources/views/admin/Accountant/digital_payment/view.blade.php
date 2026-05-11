@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="page-header mb-4">

        <div class="page-header-left">
            <h5 class="m-b-0">
                Digital Payment Details
            </h5>
        </div>

        <div class="page-header-right ms-auto">

            <a href="{{ route('admin.digital-payment.index') }}"
               class="btn btn-light">

                Back

            </a>

        </div>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th>Payment Method</th>
                    <td>{{ $payment->payment_method }}</td>
                </tr>

                <tr>
                    <th>Gateway</th>
                    <td>{{ $payment->payment_gateway }}</td>
                </tr>

                <tr>
                    <th>Amount</th>
                    <td>
                        ₹ {{ number_format($payment->payment_amount, 2) }}
                    </td>
                </tr>

                <tr>
                    <th>Payment Date</th>
                    <td>
                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                    </td>
                </tr>

                <tr>
                    <th>Transaction Reference</th>
                    <td>
                        {{ $payment->transaction_reference ?? 'N/A' }}
                    </td>
                </tr>

                <tr>
                    <th>Matching Status</th>
                    <td>

                        @if($payment->matching_status == 'Matched')

                            <span class="badge bg-success">
                                Matched
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Mismatch
                            </span>

                        @endif

                    </td>
                </tr>

                <tr>
                    <th>Settlement Status</th>
                    <td>

                        @if($payment->settlement_status == 'Settled')

                            <span class="badge bg-success">
                                Settled
                            </span>

                        @else

                            <span class="badge bg-warning">
                                Pending
                            </span>

                        @endif

                    </td>
                </tr>

                <tr>
                    <th>Remarks</th>
                    <td>
                        {{ $payment->remarks ?? 'N/A' }}
                    </td>
                </tr>

            </table>

        </div>

    </div>

</div>

@endsection