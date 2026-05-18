@extends('layouts.admin')

@section('page-title', 'Payroll Dashboard | ' . config('app.name'))

@section('content')
<div class="nxl-content">
    <div class="main-content">

        {{-- Welcome --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">Payroll Dashboard</h5>
                            <p class="mb-0 text-muted">
                                Manage payroll processing, salary structures, deductions and payroll reports.
                            </p>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('hr.payroll.pre-payroll.index') }}"
                               class="btn btn-danger btn-sm">
                                <i class="feather-dollar-sign me-1"></i>
                                Pre Payroll
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    {{-- Payroll Stats Counters --}}
<div class="row">

    {{-- Pending Pre Payroll --}}
    <div class="col-md-3">
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <div class="text-muted small text-uppercase">
                        Pending Pre Payroll
                    </div>

                    <h4 class="mb-0">
                        {{ $stats['pending_pre_payroll'] }}
                    </h4>
                </div>

                <div class="avatar-text avatar-md bg-soft-warning text-warning">
                    <i class="feather-clock"></i>
                </div>

            </div>
        </div>
    </div>

    {{-- Salary Structures --}}
    <div class="col-md-3">
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <div class="text-muted small text-uppercase">
                        Salary Structures
                    </div>

                    <h4 class="mb-0">
                        {{ $stats['salary_structures'] }}
                    </h4>
                </div>

                <div class="avatar-text avatar-md bg-soft-primary text-primary">
                    <i class="feather-layers"></i>
                </div>

            </div>
        </div>
    </div>

    {{-- Salary Assignments --}}
    <div class="col-md-3">
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <div class="text-muted small text-uppercase">
                        Salary Assignments
                    </div>

                    <h4 class="mb-0">
                        {{ $stats['salary_assignments'] }}
                    </h4>
                </div>

                <div class="avatar-text avatar-md bg-soft-success text-success">
                    <i class="feather-users"></i>
                </div>

            </div>
        </div>
    </div>

    {{-- Payroll Results --}}
    <div class="col-md-3">
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <div class="text-muted small text-uppercase">
                        Payroll Results
                    </div>

                    <h4 class="mb-0">
                        {{ $stats['payroll_results'] }}
                    </h4>
                </div>

                <div class="avatar-text avatar-md bg-soft-danger text-danger">
                    <i class="feather-file-text"></i>
                </div>

            </div>
        </div>
    </div>

</div>
        {{-- Top Cards --}}
        <div class="row">

            <div class="col-md-3">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="mb-2">
                            <i class="feather-edit text-danger me-1"></i>
                            Pre Payroll Adjustment
                        </h6>

                        <p class="text-muted mb-3">
                            Manage payroll adjustments before salary processing.
                        </p>

                        <a href="{{ route('hr.payroll.pre-payroll.index') }}"
                           class="btn btn-outline-danger btn-sm">
                            Open Module
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="mb-2">
                            <i class="feather-plus-circle text-success me-1"></i>
                            Earnings Breakdown
                        </h6>

                        <p class="text-muted mb-3">
                            View earnings, allowances and payroll additions.
                        </p>

                        <a href="{{ route('hr.payroll.payroll-result-earnings.index') }}"
                           class="btn btn-outline-success btn-sm">
                            Open Module
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="mb-2">
                            <i class="feather-minus-circle text-warning me-1"></i>
                            Deduction Breakdown
                        </h6>

                        <p class="text-muted mb-3">
                            Manage payroll deductions and statutory reductions.
                        </p>

                        <a href="{{ route('hr.payroll.payroll-result-deductions.index') }}"
                           class="btn btn-outline-warning btn-sm">
                            Open Module
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="mb-2">
                            <i class="feather-file-text text-primary me-1"></i>
                            Payroll Result
                        </h6>

                        <p class="text-muted mb-3">
                            View generated payroll results and salary sheets.
                        </p>

                        <a href="{{ route('hr.payroll.payroll-result.index') }}"
                           class="btn btn-outline-primary btn-sm">
                            Open Module
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{-- Second Row --}}
        <div class="row">

            <div class="col-md-3">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="mb-2">
                            <i class="feather-sliders text-info me-1"></i>
                            Salary Structure
                        </h6>

                        <p class="text-muted mb-3">
                            Configure salary structures and employee mapping.
                        </p>

                        <a href="{{ route('hr.payroll.salary-structure.index') }}"
                           class="btn btn-outline-info btn-sm">
                            Open Module
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="mb-2">
                            <i class="feather-users text-secondary me-1"></i>
                            Employee Salary Assignment
                        </h6>

                        <p class="text-muted mb-3">
                            Assign salary plans and payroll settings to employees.
                        </p>

                        <a href="{{ route('hr.payroll.employee-salary-assignment.index') }}"
                           class="btn btn-outline-secondary btn-sm">
                            Open Module
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="mb-2">
                            <i class="feather-percent text-dark me-1"></i>
                            Statutory Contributions
                        </h6>

                        <p class="text-muted mb-3">
                            Manage PF, tax and other statutory contributions.
                        </p>

                        <a href="{{ route('hr.payroll.statutory-contribution.index') }}"
                           class="btn btn-outline-dark btn-sm">
                            Open Module
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="mb-2">
                            <i class="feather-clock text-primary me-1"></i>
                            Hourly Pay
                        </h6>

                        <p class="text-muted mb-3">
                            Manage hourly payroll calculations and approvals.
                        </p>

                        <a href="{{ route('hr.payroll.hourly-pay.index') }}"
                           class="btn btn-outline-primary btn-sm">
                            Open Module
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection