@extends('layouts.admin')
@section('page-title', 'Earning Breakdown')
@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-left">
        <h5 class="m-b-10 mb-1">Earning Breakdown</h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Earning Breakdown</li>
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
        <form method="GET" action="{{ route('hr.payroll.payroll-result-earnings.index') }}">
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
                    <a href="{{ route('hr.payroll.payroll-result-earnings.index') }}"
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
                    <small class="text-muted">Gross Earnings</small>
                    <div><strong>₹ {{ number_format($selectedPayrollResult->gross_earnings, 2) }}</strong></div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Status</small>
                    <div>
                        @if($selectedPayrollResult->status == 'Locked')
                            <span class="badge bg-danger">Locked</span>
                        @else
                            <span class="badge bg-warning">{{ $selectedPayrollResult->status }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- GENERATE BUTTON --}}
    @if($earnings->isEmpty())
        <form method="POST" action="{{ route('hr.payroll.payroll-result-earnings.generate') }}" class="mb-3">
            @csrf
            <input type="hidden" name="staff_id" value="{{ request('staff_id') }}">
            <input type="hidden" name="payroll_month" value="{{ request('payroll_month') }}">
            <button type="submit" class="btn btn-success btn-sm">
                Generate Earning Breakdown
            </button>
        </form>
    @endif

    {{-- EARNINGS TABLE --}}
    <div class="row">
        <div class="col-12">
            <div class="card stretch stretch-full">

                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Earnings Breakdown</h5>
                    @if($earnings->isNotEmpty())
                        <a href="{{ route('hr.payroll.payroll-result-earnings.show', $selectedPayrollResult->id) }}"
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
                                    <th>Earning Name</th>
                                    <th>Type</th>
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
                                    <td colspan="8" class="text-center text-muted py-3">
                                        No earnings generated yet. Click "Generate Earning Breakdown" above.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($earnings->isNotEmpty())
                            <tfoot>
                                <tr>
                                    <th colspan="7" class="text-end">Total Gross Earnings</th>
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

@endif

@endsection