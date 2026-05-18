@extends('layouts.admin')
@section('page-title', 'Deduction Breakdown')
@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-left">
        <h5 class="m-b-10 mb-1">Deduction Breakdown</h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Deduction Breakdown</li>
        </ul>
    </div>
</div>

{{-- ALERTS --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
@endif

{{-- FILTER FORM --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('hr.payroll.payroll-result-deductions.index') }}">
            <div class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label">Employee</label>
                    <select name="staff_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Select Employee --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp['staff_id'] }}"
                                {{ request('staff_id') == $emp['staff_id'] ? 'selected' : '' }}>
                                {{ $emp['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Payroll Month</label>
                    <select name="payroll_month" class="form-select">
                        <option value="">-- Select Month --</option>
                        @foreach($months as $month)
                            <option value="{{ $month }}"
                                {{ request('payroll_month') == $month ? 'selected' : '' }}>
                                {{ $month }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">View</button>
                    <a href="{{ route('hr.payroll.payroll-result-deductions.index') }}"
                       class="btn btn-outline-secondary">Reset</a>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- RESULTS SECTION --}}
@if($selectedPayrollResult)

    {{-- PAYROLL RESULT SUMMARY --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <small class="text-muted">Employee</small>
                    <div><strong>{{ $selectedPayrollResult->staff->name ?? $selectedPayrollResult->staff_id }}</strong></div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Payroll Month</small>
                    <div><strong>{{ $selectedPayrollResult->payroll_month }}</strong></div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Total Deductions</small>
                    <div><strong>₹ {{ number_format($selectedPayrollResult->total_deductions, 2) }}</strong></div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Net Payable</small>
                    <div><strong>₹ {{ number_format($selectedPayrollResult->net_payable, 2) }}</strong></div>
                </div>
            </div>
        </div>
    </div>

    {{-- GENERATE BUTTON --}}
    @if($deductions->isEmpty())
        <form method="POST" action="{{ route('hr.payroll.payroll-result-deductions.generate') }}" class="mb-3">
            @csrf
            <input type="hidden" name="staff_id" value="{{ request('staff_id') }}">
            <input type="hidden" name="payroll_month" value="{{ request('payroll_month') }}">
            <button type="submit" class="btn btn-danger btn-sm">
                Generate Deduction Breakdown
            </button>
        </form>
    @endif

    {{-- DEDUCTIONS TABLE --}}
    <div class="row">
        <div class="col-12">
            <div class="card stretch stretch-full">

                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Deductions Breakdown</h5>
                    @if($deductions->isNotEmpty())
                        <a href="{{ route('hr.payroll.payroll-result-deductions.show', $selectedPayrollResult->id) }}"
                           class="btn btn-outline-secondary btn-sm">
                            <i class="feather-eye"></i> View Detail
                        </a>
                    @endif
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
                                    <th>Value</th>
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
                                    <td>{{ $row->calculation_value ?? '-' }}</td>
                                    <td class="text-end">
                                        <strong>₹ {{ number_format($row->amount, 2) }}</strong>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">
                                        No deductions generated yet. Click "Generate Deduction Breakdown" above.
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

@endif

@endsection