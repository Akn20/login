@extends('layouts.admin')

@section('page-title', 'Payroll Result Details')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between align-items-center">

    <h5 class="mb-1">
        Payroll Result Details
    </h5>

    <a href="{{ route('hr.payroll.payroll-result.index') }}"
       class="btn btn-light">

        <i class="feather-arrow-left me-1"></i> Back

    </a>

</div>


<div class="card">
<div class="card-body">

{{-- IDENTIFICATION --}}

<h6 class="mb-3">Identification</h6>

<div class="row">

<div class="col-md-4 mb-3">
<label class="text-muted">Payroll Result ID</label>
<div class="fw-bold">
{{ $payrollResult->id }}
</div>
</div>

<div class="col-md-4 mb-3">
<label class="text-muted">Payroll Run ID</label>
<div class="fw-bold">
{{ $payrollResult->payroll_run_id }}
</div>
</div>

<div class="col-md-4 mb-3">
<label class="text-muted">Employee ID</label>
<div class="fw-bold">
{{ $payrollResult->staff_id }}
</div>
</div>

</div>

<hr>

{{-- PERIOD --}}

<h6 class="mb-3">Period</h6>

<div class="row">

<div class="col-md-4 mb-3">
Payroll Month:
<strong>
{{ $payrollResult->payroll_month }}
</strong>
</div>

<div class="col-md-4 mb-3">
Financial Year:
<strong>
{{ $payrollResult->financial_year }}
</strong>
</div>

<div class="col-md-4 mb-3">
Academic Year:
<strong>
{{ $payrollResult->academic_year ?? '-' }}
</strong>
</div>

</div>

<hr>

{{-- ATTENDANCE --}}

<h6 class="mb-3">Attendance</h6>

<div class="row">

<div class="col-md-4 mb-3">
Working Days:
<strong>
{{ $payrollResult->working_days }}
</strong>
</div>

<div class="col-md-4 mb-3">
Paid Days:
<strong>
{{ $payrollResult->paid_days }}
</strong>
</div>

<div class="col-md-4 mb-3">
LOP Days:
<strong>
{{ $payrollResult->lop_days }}
</strong>
</div>

<div class="col-md-4 mb-3">
Overtime Hours:
<strong>
{{ $payrollResult->overtime_hours }}
</strong>
</div>

</div>

<hr>

{{-- EARNINGS --}}

<h6 class="mb-3">Earnings</h6>

<div class="row">

<div class="col-md-4 mb-3">
Fixed Earnings:
<strong>
₹ {{ number_format($payrollResult->fixed_earnings_total,2) }}
</strong>
</div>

<div class="col-md-4 mb-3">
Variable Earnings:
<strong>
₹ {{ number_format($payrollResult->variable_earnings_total,2) }}
</strong>
</div>

<div class="col-md-4 mb-3">
Gross Earnings:
<strong class="text-success">
₹ {{ number_format($payrollResult->gross_earnings,2) }}
</strong>
</div>

</div>

<hr>

{{-- DEDUCTIONS --}}

<h6 class="mb-3">Deductions</h6>

<div class="row">

<div class="col-md-4 mb-3">
Fixed Deductions:
<strong>
₹ {{ number_format($payrollResult->fixed_deductions_total,2) }}
</strong>
</div>

<div class="col-md-4 mb-3">
Variable Deductions:
<strong>
₹ {{ number_format($payrollResult->variable_deductions_total,2) }}
</strong>
</div>

<div class="col-md-4 mb-3">
Total Deductions:
<strong class="text-danger">
₹ {{ number_format($payrollResult->total_deductions,2) }}
</strong>
</div>

</div>

<hr>

{{-- STATUTORY --}}

<h6 class="mb-3">Statutory</h6>

<div class="row">

<div class="col-md-4 mb-3">
PF Employee:
<strong>
{{ $payrollResult->pf_employee }}
</strong>
</div>

<div class="col-md-4 mb-3">
ESI Employee:
<strong>
{{ $payrollResult->esi_employee }}
</strong>
</div>

<div class="col-md-4 mb-3">
Professional Tax:
<strong>
{{ $payrollResult->professional_tax }}
</strong>
</div>

<div class="col-md-4 mb-3">
TDS Amount:
<strong>
{{ $payrollResult->tds_amount }}
</strong>
</div>

</div>

<hr>

{{-- NET PAY --}}

<h6 class="mb-3">Net Pay</h6>

<div class="row">

<div class="col-md-4 mb-3">
Net Payable:
<strong class="text-success">
₹ {{ number_format($payrollResult->net_payable,2) }}
</strong>
</div>

</div>

<hr>

{{-- CONTROL --}}

<h6 class="mb-3">Control</h6>

<div class="row">

<div class="col-md-4 mb-3">

Status:

<span class="badge bg-danger">
{{ $payrollResult->status }}
</span>

</div>

<div class="col-md-4 mb-3">

Locked On:

<strong>
{{ $payrollResult->locked_on }}
</strong>

</div>

<div class="col-md-4 mb-3">

Locked By:

<strong>
{{ $payrollResult->locked_by }}
</strong>

</div>

</div>

<hr>

{{-- AUDIT --}}

<h6 class="mb-3">Audit</h6>

<div class="row">

<div class="col-md-4 mb-3">
Created On:
<strong>
{{ $payrollResult->created_on }}
</strong>
</div>

<div class="col-md-8 mb-3">
Remarks:
<strong>
{{ $payrollResult->remarks }}
</strong>
</div>

</div>

</div>
</div>

@endsection