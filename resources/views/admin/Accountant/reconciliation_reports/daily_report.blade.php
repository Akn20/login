@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Daily Reconciliation Report</h5>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.reconciliation-reports.index') }}"
               class="btn btn-light">
                Back
            </a>
        </div>
    </div>

    <div class="row">

        <div class="col-md-4 mb-4">

            <div class="card p-4 text-center">

                <h6>Total Cash</h6>

                <h3>
                    ₹ {{ number_format($totalCash, 2) }}
                </h3>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card p-4 text-center">

                <h6>Total Bank Deposits</h6>

                <h3>
                    ₹ {{ number_format($totalBankDeposits, 2) }}
                </h3>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card p-4 text-center">

                <h6>Total Digital Payments</h6>

                <h3>
                    ₹ {{ number_format($totalDigitalPayments, 2) }}
                </h3>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-6 mb-4">

            <div class="card p-4 text-center bg-success text-white">

                <h6>Total Reconciled</h6>

                <h3>
                    ₹ {{ number_format($totalReconciled, 2) }}
                </h3>

            </div>

        </div>

        <div class="col-md-6 mb-4">

            <div class="card p-4 text-center bg-danger text-white">

                <h6>Total Discrepancy</h6>

                <h3>
                    ₹ {{ number_format($totalDiscrepancy, 2) }}
                </h3>

            </div>

        </div>

    </div>

</div>

@endsection