@extends('layouts.admin')
@section('page-title', 'Deduction Breakdown - Detail')
@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-left">
        <h5 class="m-b-10 mb-1">Deduction Breakdown — Detail</h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.payroll.payroll-result-deductions.index') }}">Deduction Breakdown</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ul>
    </div>
    <div class="page-header-right">
        <a href="{{ route('hr.payroll.payroll-result-deductions.index') }}"
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
                <small class="text-muted">Gross Earnings</small>
                <div><strong>₹ {{ number_format($payrollResult->gross_earnings, 2) }}</strong></div>
            </div>
            <div class="col-md-3 mt-3">
                <small class="text-muted">Total Deductions</small>
                <div><strong>₹ {{ number_format($payrollResult->total_deductions, 2) }}</strong></div>
            </div>
            <div class="col-md-3 mt-3">
                <small class="text-muted">Net Payable</small>
                <div><strong>₹ {{ number_format($payrollResult->net_payable, 2) }}</strong></div>
            </div>
        </div>
    </div>
</div>

{{-- DEDUCTIONS BREAKDOWN TABLE --}}
<div class="row">
    <div class="col-12">
        <div class="card stretch stretch-full">

            <div class="card-header">
                <h5 class="mb-0">Deductions Breakdown</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Deduction Name</th>
                                <th>Type</th>
                                <th>Calc Base</th>
                                <th>Logic</th>
    
                                <th class="text-end">Amount (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deductions as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <span class="badge bg-soft-danger text-danger">
                                        {{ $row->deduction_code }}
                                    </span>
                                </td>
                                <td>{{ $row->deduction_name }}</td>
                                <td>{{ $row->deduction_type }}</td>
                                <td>{{ $row->calculation_base ?? '-' }}</td>
                                <td>{{ $row->calculation_logic ?? '-' }}</td>
                               
                                <td class="text-end">
                                    <strong>₹ {{ number_format($row->amount, 2) }}</strong>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-3">
                                    No deductions found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($deductions->isNotEmpty())
                        <tfoot>
                            <tr>
                                <th colspan="7" class="text-end">Total Deductions</th>
                                <th class="text-end">₹ {{ number_format($deductions->sum('amount'), 2) }}</th>
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