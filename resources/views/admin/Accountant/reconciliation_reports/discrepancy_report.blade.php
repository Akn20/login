@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Discrepancy Report</h5>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.reconciliation-reports.index') }}"
               class="btn btn-light">
                Back
            </a>
        </div>
    </div>

    <div class="card">

        <div class="card-body table-responsive">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>Issue Type</th>

                        <th>Expected</th>

                        <th>Actual</th>

                        <th>Difference</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($discrepancies as $item)

                        <tr>

                            <td>{{ $item->issue_type }}</td>

                            <td>
                                ₹ {{ number_format($item->expected_amount, 2) }}
                            </td>

                            <td>
                                ₹ {{ number_format($item->actual_amount, 2) }}
                            </td>

                            <td class="text-danger fw-bold">

                                ₹ {{ number_format($item->difference_amount, 2) }}

                            </td>

                            <td>

                                <span class="badge bg-warning">

                                    {{ $item->status }}

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