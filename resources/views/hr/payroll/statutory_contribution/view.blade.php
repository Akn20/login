@extends('layouts.admin')

@section('page-title', 'View Statutory Contribution')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

<div>
<h5 class="mb-1">
View Statutory Contribution
</h5>
</div>

<a href="{{ route('hr.payroll.statutory-contribution.index') }}"
class="btn btn-light">

<i class="feather-arrow-left me-1"></i>
Back

</a>

</div>


<!-- ================= BASIC DETAILS ================= -->

<div class="card mb-3">

<div class="card-header">
Basic Details
</div>

<div class="card-body">

<div class="row">

<div class="col-md-4 mb-3">
<label class="form-label text-muted">
Contribution Code
</label>

<div>
{{ $statutoryContribution->contribution_code }}
</div>
</div>


<div class="col-md-4 mb-3">
<label class="form-label text-muted">
Contribution Name
</label>

<div>
{{ $statutoryContribution->contribution_name }}
</div>
</div>


<div class="col-md-4 mb-3">
<label class="form-label text-muted">
Statutory Category
</label>

<div>
{{ $statutoryContribution->statutory_category }}
</div>
</div>

</div>


<div class="row">

<div class="col-md-4 mb-3">
<label class="form-label text-muted">
Rule Set Code
</label>

<div>
{{ $statutoryContribution->rule_set_code }}
</div>
</div>


<div class="col-md-4 mb-3">
<label class="form-label text-muted">
Eligibility Flag
</label>

<div>
{{ $statutoryContribution->eligibility_flag ? 'Yes' : 'No' }}
</div>
</div>


<div class="col-md-4 mb-3">
<label class="form-label text-muted">
Status
</label>

<div>

@if($statutoryContribution->status == 'Active')

<span class="text-success">
Active
</span>

@else

<span class="text-danger">
Inactive
</span>

@endif

</div>

</div>

</div>

</div>

</div>


<!-- ================= SALARY & STATE ================= -->

<div class="card mb-3">

<div class="card-header">
Salary & State Configuration
</div>

<div class="card-body">

<div class="row">

<div class="col-md-4 mb-3">
<label class="form-label text-muted">
Salary Ceiling Applicable
</label>

<div>
{{ $statutoryContribution->salary_ceiling_applicable ? 'Yes' : 'No' }}
</div>
</div>


<div class="col-md-4 mb-3">
<label class="form-label text-muted">
Salary Ceiling Amount
</label>

<div>
{{ $statutoryContribution->salary_ceiling_amount ?? 'N/A' }}
</div>
</div>


<div class="col-md-4 mb-3">
<label class="form-label text-muted">
State Applicable
</label>

<div>
{{ $statutoryContribution->state_applicable ? 'Yes' : 'No' }}
</div>
</div>

</div>


{{-- ⭐ Applicable States Display --}}

@if($statutoryContribution->state_applicable)

@php

$states =
json_decode(
$statutoryContribution->applicable_states,
true
);

$stateNames = [

'KA' => 'Karnataka',
'TN' => 'Tamil Nadu',
'KL' => 'Kerala',
'AP' => 'Andhra Pradesh',
'TS' => 'Telangana',

];

@endphp

<div class="row">

<div class="col-md-12 mb-3">

<label class="form-label text-muted">
Applicable States
</label>

<div>

@if($states)

@foreach($states as $code)

<span class="badge bg-primary me-1">

{{ $stateNames[$code] ?? $code }}

</span>

@endforeach

@else

<span class="text-muted">
None
</span>

@endif

</div>

</div>

</div>

@endif

</div>

</div>


<!-- ================= PAYROLL ================= -->

<div class="card mb-3">

<div class="card-header">
Payroll Behaviour
</div>

<div class="card-body">

<div class="row">

<div class="col-md-4 mb-3">
<label class="form-label text-muted">
Prorata Applicable
</label>

<div>
{{ $statutoryContribution->prorata_applicable ? 'Yes' : 'No' }}
</div>
</div>


<div class="col-md-4 mb-3">
<label class="form-label text-muted">
LOP Impact
</label>

<div>
{{ $statutoryContribution->lop_impact ? 'Yes' : 'No' }}
</div>
</div>


<div class="col-md-4 mb-3">
<label class="form-label text-muted">
Rounding Rule
</label>

<div>
{{ $statutoryContribution->rounding_rule ?? 'N/A' }}
</div>
</div>

</div>

</div>

</div>


<!-- ================= PAYSLIP ================= -->

<div class="card mb-3">

<div class="card-header">
Payslip Configuration
</div>

<div class="card-body">

<div class="row">

<div class="col-md-4 mb-3">
<label class="form-label text-muted">
Show in Payslip
</label>

<div>
{{ $statutoryContribution->show_in_payslip ? 'Yes' : 'No' }}
</div>
</div>


<div class="col-md-4 mb-3">
<label class="form-label text-muted">
Payslip Order
</label>

<div>
{{ $statutoryContribution->payslip_order ?? 'N/A' }}
</div>
</div>


<div class="col-md-4 mb-3">
<label class="form-label text-muted">
Included in CTC
</label>

<div>
{{ $statutoryContribution->included_in_ctc ? 'Yes' : 'No' }}
</div>
</div>

</div>

</div>

</div>


<!-- ================= COMPLIANCE ================= -->

<div class="card mb-3">

<div class="card-header">
Compliance Details
</div>

<div class="card-body">

<div class="row">

<div class="col-md-4 mb-3">
<label class="form-label text-muted">
Compliance Head
</label>

<div>
{{ $statutoryContribution->compliance_head }}
</div>
</div>


<div class="col-md-4 mb-3">
<label class="form-label text-muted">
Statutory Code
</label>

<div>
{{ $statutoryContribution->statutory_code }}
</div>
</div>

</div>

</div>

</div>

@endsection