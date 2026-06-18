@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Bank Verification Report</h5>
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

                <h6>Verified Deposits</h6>

                <h3>{{ $verified }}</h3>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card p-4 text-center bg-warning">

                <h6>Pending Verifications</h6>

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

                        <th>Bank Name</th>

                        <th>Deposit Amount</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($verifications as $item)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                <td>REC-{{ strtoupper(substr($item->financialReconciliation->id, 0, 6)) }}

                    |

                    {{ \Carbon\Carbon::parse(
                        $item->financialReconciliation->reconciliation_date
                    )->format('d M Y') }}

                </td>
                            <td>{{ $item->deposit_date }}</td>

                            <td>{{ $item->bank_name }}</td>

                            <td>
                                ₹ {{ number_format($item->deposit_amount, 2) }}
                            </td>

                            <td>

                                <span class="badge bg-{{ $item->verification_status == 'Verified' ? 'success' : 'warning' }}">

                                    {{ $item->verification_status }}

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