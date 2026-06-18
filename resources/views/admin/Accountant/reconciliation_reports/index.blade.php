@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="page-header mb-4">

        <h5>Reconciliation Reports</h5>

    </div>

    <div class="row">

        <div class="col-md-3 mb-4">

            <div class="card p-4 text-center">

                <h6>Daily Reconciliation</h6>

                <a href="{{ route('admin.reconciliation-reports.daily-report') }}"
                   class="btn btn-primary mt-3">

                    View Report

                </a>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card p-4 text-center">

                <h6>Bank Verification</h6>

                <a href="{{ route('admin.reconciliation-reports.bank-report') }}"
                   class="btn btn-success mt-3">

                    View Report

                </a>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card p-4 text-center">

                <h6>Digital Payments</h6>

                <a href="{{ route('admin.reconciliation-reports.digital-payment-report') }}"
                   class="btn btn-warning mt-3">

                    View Report

                </a>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card p-4 text-center">

                <h6>Discrepancy Report</h6>

                <a href="{{ route('admin.reconciliation-reports.discrepancy-report') }}"
                   class="btn btn-danger mt-3">

                    View Report

                </a>

            </div>

        </div>

    </div>

</div>

@endsection