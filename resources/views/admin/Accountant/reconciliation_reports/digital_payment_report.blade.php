@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Digital Payment Report</h5>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.reconciliation-reports.index') }}"
               class="btn btn-light">
                Back
            </a>
        </div>
    </div>

    <div class="row mb-4">

        <div class="col-md-6">

            <div class="card p-4 text-center bg-success text-white">

                <h6>Successful Transactions</h6>

                <h3>{{ $success }}</h3>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card p-4 text-center bg-danger text-white">

                <h6>Pending Transactions</h6>

                <h3>{{ $pending }}</h3>

            </div>

        </div>

    </div>

    <div class="card">

        <div class="card-body table-responsive">

            <table class="table table-bordered">

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Reconciliation id</th>

                        <th>Date</th>

                        <th>Method</th>

                        <th>Amount</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($payments as $payment)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>REC-{{ strtoupper(substr($payment->financialReconciliation->id, 0, 6)) }}

    |

    {{ \Carbon\Carbon::parse(
        $payment->financialReconciliation->reconciliation_date
    )->format('d M Y') }}

</td>

                            <td>{{ $payment->payment_date }}</td>

                            <td>{{ $payment->payment_method }}</td>

                            <td>
                                ₹ {{ number_format($payment->payment_amount, 2) }}
                            </td>

                            <td>

                                <span class="badge bg-{{ $payment->settlement_status == 'Settled' ? 'success' : 'danger' }}">

                                    {{ $payment->settlement_status }}

                                </span>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection