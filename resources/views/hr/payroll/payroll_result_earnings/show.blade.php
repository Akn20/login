@extends('layouts.admin')
@section('page-title', 'Earning Breakdown - Detail')
@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-left">
        <h5 class="m-b-10 mb-1">Earning Breakdown — Detail</h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.payroll.payroll-result-earnings.index') }}">Earning Breakdown</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ul>
    </div>
    <div class="page-header-right">
        <a href="{{ route('hr.payroll.payroll-result-earnings.index') }}"
           class="btn btn-outline-secondary btn-sm">
            ← Back
        </a>
    </div>
</div>

{{-- PAYROLL RESULT SUMMARY --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <small class="text-muted">Employee</small>
                <div><strong>{{ $payrollResult->staff->name ?? $payrollResult->staff_id }}</strong></div>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Payroll Month</small>
                <div><strong>{{ $payrollResult->payroll_month }}</strong></div>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Financial Year</small>
                <div><strong>{{ $payrollResult->financial_year }}</strong></div>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Status</small>
                <div>
                    @if($payrollResult->status == 'Locked')
                        <span class="badge bg-danger">Locked</span>
                    @else
                        <span class="badge bg-warning">{{ $payrollResult->status }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3 mt-3">
                <small class="text-muted">Working Days</small>
                <div><strong>{{ $payrollResult->working_days }}</strong></div>
            </div>
            <div class="col-md-3 mt-3">
                <small class="text-muted">Paid Days</small>
                <div><strong>{{ $payrollResult->paid_days }}</strong></div>
            </div>
            <div class="col-md-3 mt-3">
                <small class="text-muted">LOP Days</small>
                <div><strong>{{ $payrollResult->lop_days }}</strong></div>
            </div>
            <div class="col-md-3 mt-3">
                <small class="text-muted">Gross Earnings</small>
                <div><strong>₹ {{ number_format($payrollResult->gross_earnings, 2) }}</strong></div>
            </div>
        </div>
    </div>
</div>

{{-- EARNINGS BREAKDOWN TABLE --}}
<div class="row">
    <div class="col-12">
        <div class="card stretch stretch-full">

            <div class="card-header">
                <h5 class="mb-0">Earnings Breakdown</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Earning Name</th>
                                <th>Type</th>
                                <th>Calc Base</th>
                                <th>Calc Value</th>
                                <th>Taxable</th>
                                <th>PF</th>
                                <th>ESI</th>
                                <th class="text-end">Amount (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($earnings as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <span class="badge bg-soft-primary text-primary">
                                        {{ $row->earning_code }}
                                    </span>
                                </td>
                                <td>{{ $row->earning_name }}</td>
                                <td>{{ $row->earning_type }}</td>
                                <td>{{ $row->calculation_base ?? '-' }}</td>
                                <td>{{ $row->calculation_value ?? '-' }}</td>
                                <td>
                                    @if($row->taxable)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if($row->pf_applicable)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if($row->esi_applicable)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <strong>₹ {{ number_format($row->amount, 2) }}</strong>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-3">
                                    No earnings found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($earnings->isNotEmpty())
                        <tfoot>
                            <tr>
                                <th colspan="9" class="text-end">Total Gross Earnings</th>
                                <th class="text-end">₹ {{ number_format($earnings->sum('amount'), 2) }}</th>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection