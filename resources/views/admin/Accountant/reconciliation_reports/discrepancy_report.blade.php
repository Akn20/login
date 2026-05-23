@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="page-header mb-4">

        <div class="page-header-left">
            <h5 class="m-b-0">
                Discrepancy Report
            </h5>
        </div>

        <div class="page-header-right ms-auto">

            <a href="{{ route('admin.reconciliation-reports.index') }}"
               class="btn btn-light">

                Back

            </a>

        </div>

    </div>

    {{-- SUMMARY CARDS --}}
    <div class="row mb-4">

        {{-- OPEN DISCREPANCIES --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm rounded-4 bg-warning">

                <div class="card-body text-center py-5">

                    <h3 class="fw-bold text-dark">
                        Open Discrepancies
                    </h3>

                    <h1 class="fw-bold text-dark mt-3">

                        {{ $discrepancies->where('status', 'Open')->count() }}

                    </h1>

                </div>

            </div>

        </div>

        {{-- RESOLVED DISCREPANCIES --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm rounded-4 bg-success">

                <div class="card-body text-center py-5">

                    <h2 class="fw-bold text-white">
                        Resolved
                    </h2>

                    <h1 class="fw-bold text-white mt-3">

                        {{ $discrepancies->where('status', 'Resolved')->count() }}

                    </h1>

                </div>

            </div>

        </div>

        {{-- TOTAL DIFFERENCE --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm rounded-4 bg-danger">

                <div class="card-body text-center py-5">

                    <h3 class="fw-bold text-white">
                        Total Difference
                    </h3>

                    <h1 class="fw-bold text-white mt-3">

                        ₹ {{ number_format($discrepancies->sum('difference_amount'), 2) }}

                    </h1>

                </div>

            </div>

        </div>

    </div>

    {{-- REPORT TABLE --}}
    <div class="card">

        <div class="card-body table-responsive">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Reconciliation Id</th>

                        <th>Issue Type</th>

                        <th>Expected</th>

                        <th>Actual</th>

                        <th>Difference</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($discrepancies as $key => $item)

                        <tr>

                            <td>
                                {{ $key + 1 }}
                            </td>

                            {{-- RECONCILIATION REFERENCE --}}
                            <td>

                                @if($item->financialReconciliation)

                                    REC-{{ strtoupper(substr($item->financialReconciliation->id, 0, 6)) }}

                                    |

                                    {{ \Carbon\Carbon::parse(
                                        $item->financialReconciliation->reconciliation_date
                                    )->format('d M Y') }}

                                @else

                                    No Reconciliation

                                @endif

                            </td>

                            {{-- ISSUE TYPE --}}
                            <td>

                                {{ $item->issue_type }}

                            </td>

                            {{-- EXPECTED --}}
                            <td>

                                ₹ {{ number_format($item->expected_amount, 2) }}

                            </td>

                            {{-- ACTUAL --}}
                            <td>

                                ₹ {{ number_format($item->actual_amount, 2) }}

                            </td>

                            {{-- DIFFERENCE --}}
                            <td class="text-danger fw-bold">

                                ₹ {{ number_format($item->difference_amount, 2) }}

                            </td>

                            {{-- STATUS --}}
                            <td>

                                @if($item->status == 'Open')

                                    <span class="badge bg-warning">

                                        {{ $item->status }}

                                    </span>

                                @elseif($item->status == 'Resolved')

                                    <span class="badge bg-success">

                                        {{ $item->status }}

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        {{ $item->status }}

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center">

                                No discrepancy records found

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection