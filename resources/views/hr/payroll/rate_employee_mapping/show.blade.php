@extends('layouts.admin')

@section('page-title', 'View Rate Employee Mapping')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

<div>
<h5 class="mb-1">
View Rate Employee Mapping
</h5>
</div>

<a href="{{ route('hr.payroll.rate-employee-mapping.index') }}"
class="btn btn-light">

<i class="feather-arrow-left me-1"></i>
Back

</a>

</div>



<!-- ================= IDENTIFICATION ================= -->

<div class="card mb-3">

<div class="card-header">
Identification Details
</div>

<div class="card-body">

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label text-muted">
Rule Set Code
</label>

<div>
{{ $rateMapping->rule_set_code }}
</div>

</div>



<div class="col-md-4 mb-3">

<label class="form-label text-muted">
Rule Set Name
</label>

<div>
{{ $rateMapping->rule_set_name }}
</div>

</div>



<div class="col-md-4 mb-3">

<label class="form-label text-muted">
Work Type Code
</label>

<div>
{{ $rateMapping->work_type_code }}
</div>

</div>

</div>

</div>

</div>



<!-- ================= CALCULATION LOGIC ================= -->

<div class="card mb-3">

<div class="card-header">
Calculation Logic
</div>

<div class="card-body">

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label text-muted">
Rate Type
</label>

<div>
{{ $rateMapping->rate_type }}
</div>

</div>



<div class="col-md-4 mb-3">

<label class="form-label text-muted">
Base Rate Source
</label>

<div>
{{ $rateMapping->base_rate_source }}
</div>

</div>



<div class="col-md-4 mb-3">

<label class="form-label text-muted">
Base Rate Value
</label>

<div>
{{ $rateMapping->base_rate_value ?? 'N/A' }}
</div>

</div>

</div>



<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label text-muted">
Multiplier Value
</label>

<div>
{{ $rateMapping->multiplier_value ?? 'N/A' }}
</div>

</div>



<div class="col-md-4 mb-3">

<label class="form-label text-muted">
Maximum Hours
</label>

<div>
{{ $rateMapping->maximum_hours ?? 'N/A' }}
</div>

</div>



<div class="col-md-4 mb-3">

<label class="form-label text-muted">
Round Off Rule
</label>

<div>
{{ $rateMapping->round_off_rule ?? 'N/A' }}
</div>

</div>

</div>

</div>

</div>



<!-- ================= APPLICABILITY ================= -->

<div class="card mb-3">

<div class="card-header">
Applicability
</div>

<div class="card-body">

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label text-muted">
Employee Type
</label>

<div>
{{ $rateMapping->employee_type }}
</div>

</div>



<div class="col-md-4 mb-3">

<label class="form-label text-muted">
Employee
</label>

<div>
{{ optional($rateMapping->employee)->name ?? 'N/A' }}
</div>

</div>



<div class="col-md-4 mb-3">

<label class="form-label text-muted">
Employee Category
</label>

<div>
{{ $rateMapping->employee_category ?? 'N/A' }}
</div>

</div>

</div>

</div>

</div>

@endsection