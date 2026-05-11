@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Reconciliation Details</h5>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.financial-reconciliation.index') }}"
               class="btn btn-light">
                Back
            </a>
        </div>
    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th>Date</th>
                    <td>
                        {{ \Carbon\Carbon::parse($reconciliation->reconciliation_date)->format('d M Y') }}
                    </td>
                </tr>

                <tr>
                    <th>Total Cash</th>
                    <td>
                        ₹ {{ number_format($reconciliation->total_cash, 2) }}
                    </td>
                </tr>

                <tr>
                    <th>Total Digital</th>
                    <td>
                        ₹ {{ number_format($reconciliation->total_digital, 2) }}
                    </td>
                </tr>

                <tr>
                    <th>Bank Deposit</th>
                    <td>
                        ₹ {{ number_format($reconciliation->total_bank_deposit, 2) }}
                    </td>
                </tr>

                <tr>
                    <th>Difference Amount</th>
                    <td>
                        ₹ {{ number_format($reconciliation->difference_amount, 2) }}
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        {{ $reconciliation->status }}
                    </td>
                </tr>

                <tr>
                    <th>Bank Name</th>
                    <td>
                        {{ $reconciliation->bank_name ?? 'N/A' }}
                    </td>   
                </tr>
                
                 <tr>
                    <th>Reference Number</th>
                    <td>
                        {{ $reconciliation->deposit_reference ?? 'N/A' }}
                    </td>
                </tr>

                <tr>
                    <th>Verification Status</th>
                    <td>
                        {{ $reconciliation->verification_status ?? 'N/A' }}
                    </td>
                </tr>

                <tr><th>Payment Gateway</th>
                <td>{{ $reconciliation->payment_gateway ?? 'N/A' }}</td>
            </tr>

            <tr><th>Gateway Reference</th>
                <td>{{ $reconciliation->gateway_reference ?? 'N/A' }}</td>
        </tr>

             <tr><th>Digital Payment</th><td>{{ $reconciliation->digital_payment_status ?? 'N/A' }}</th></tr>
             

                <tr>
                    <th>Remarks</th>
                    <td>
                        {{ $reconciliation->remarks ?? 'N/A' }}
                    </td>
                </tr>

            </table>

        </div>

    </div>

</div>

@endsection