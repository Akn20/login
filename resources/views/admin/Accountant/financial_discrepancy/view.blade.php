@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">
            <h5>Discrepancy Details</h5>
        </div>

        <div class="card-body">

           <p>
                <strong>Reconciliation Id:</strong>

                REC-{{ strtoupper(substr($discrepancy->financialReconciliation->id, 0, 6)) }}

                |

                {{ \Carbon\Carbon::parse(
                    $discrepancy->financialReconciliation->reconciliation_date
                )->format('d M Y') }}
            </p>

            <p>
                <strong>Issue Type:</strong>
                {{ $discrepancy->issue_type }}
            </p>

            <p>
                <strong>Expected Amount:</strong>
                ₹ {{ number_format($discrepancy->expected_amount, 2) }}
            </p>

            <p>
                <strong>Actual Amount:</strong>
                ₹ {{ number_format($discrepancy->actual_amount, 2) }}
            </p>

            <p>
                <strong>Difference:</strong>

                <span class="{{ $discrepancy->difference_amount != 0 ? 'text-danger fw-bold' : 'text-success fw-bold' }}">

                    ₹ {{ number_format($discrepancy->difference_amount, 2) }}

                </span>

            </p>

            <p>
                <strong>Status:</strong>
                {{ $discrepancy->status }}
            </p>

            <p>
                <strong>Remarks:</strong>
                {{ $discrepancy->remarks ?? '-' }}
            </p>

        </div>

    </div>

</div>

@endsection