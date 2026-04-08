@extends('layouts.admin')

@section('page-title', 'Add Hourly Pay Approval | ' . config('app.name'))
@section('title', 'Add Hourly Pay Approval')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

<div>

<h5 class="mb-1">
<i class="feather-plus-circle me-1"></i>
{{ isset($entry) ? 'Edit Hourly Entry' : 'Add Hourly Entry' }}
</h5>

<ul class="breadcrumb mb-0">
<li class="breadcrumb-item">Payroll</li>
<li class="breadcrumb-item">Hourly Pay Approval</li>
</ul>

</div>

<div class="d-flex gap-2">

<button type="submit"
form="hourlyForm"
class="btn btn-primary">

<i class="feather-save me-1"></i>
{{ isset($entry) ? 'Update' : 'Save' }}

</button>

<a href="{{ route('hr.payroll.hourly-pay-approval.index') }}"
class="btn btn-light">

Cancel

</a>

</div>

</div>

@if ($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach ($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif

<div class="card stretch stretch-full">

<div class="card-body">

<form id="hourlyForm"
method="POST"
action="{{ isset($entry)
? route('hr.payroll.hourly-pay-approval.update',$entry->id)
: route('hr.payroll.hourly-pay-approval.store') }}">

@csrf

@if(isset($entry))
@method('PUT')
@endif

{{-- BASIC DETAILS --}}

<h6 class="fw-bold mb-3">Basic Details</h6>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">Employee *</label>

<select name="staff_id"
class="form-control"
required>

<option value="">Select Employee</option>

@foreach($staffs as $staff)

<option value="{{ $staff->id }}"
{{ old('staff_id', $entry->staff_id ?? '') == $staff->id ? 'selected' : '' }}>

{{ $staff->name }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Work Type *</label>

<select name="work_type_code"
class="form-control"
required>

<option value="">Select Work Type</option>

@foreach($workTypes as $type)

<option value="{{ $type->code }}"
{{ old('work_type_code', $entry->work_type_code ?? '') == $type->code ? 'selected' : '' }}>

{{ $type->name }}

</option>

@endforeach

</select>

</div>

</div>

<hr>

{{-- TIME DETAILS --}}

<h6 class="fw-bold mb-3">Time Details</h6>

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label">Payroll Month *</label>

<input type="month"
name="payroll_month"
class="form-control"
value="{{ old('payroll_month', $entry->payroll_month ?? '') }}">

</div>

<div class="col-md-4 mb-3">

<label class="form-label">Attendance Date *</label>

<input type="date"
name="attendance_date"
class="form-control"
value="{{ old('attendance_date', $entry->attendance_date ?? '') }}">

</div>

<div class="col-md-4 mb-3">

<label class="form-label">Approved Hours *</label>

<input type="number"
step="0.1"
name="approved_hours"
class="form-control"
value="{{ old('approved_hours', $entry->approved_hours ?? '') }}">

</div>

</div>

<hr>

{{-- CONTEXT --}}

<h6 class="fw-bold mb-3">Context Details</h6>

<div class="row">

{{-- ✅ FIXED SHIFT DROPDOWN --}}

<div class="col-md-4 mb-3">

<label class="form-label">Shift Code</label>

<select name="shift_code"
class="form-control">

<option value="">Select Shift</option>

@foreach($shifts as $shift)

<option value="{{ $shift->shift_name }}"
{{ old('shift_code', $entry->shift_code ?? '') == $shift->shift_name ? 'selected' : '' }}>

{{ $shift->shift_name }}

</option>

@endforeach

</select>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">Day Type</label>

<select name="day_type"
class="form-control">

<option value="Working"
{{ old('day_type', $entry->day_type ?? '') == 'Working' ? 'selected' : '' }}>

Working

</option>

<option value="Weekend"
{{ old('day_type', $entry->day_type ?? '') == 'Weekend' ? 'selected' : '' }}>

Weekend

</option>

<option value="Holiday"
{{ old('day_type', $entry->day_type ?? '') == 'Holiday' ? 'selected' : '' }}>

Holiday

</option>

</select>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">Source Type *</label>

<select name="source_type"
class="form-control">

<option value="Biometric"
{{ old('source_type', $entry->source_type ?? '') == 'Biometric' ? 'selected' : '' }}>

Biometric

</option>

<option value="Manual"
{{ old('source_type', $entry->source_type ?? '') == 'Manual' ? 'selected' : '' }}>

Manual

</option>

</select>

</div>

</div>

<hr>

{{-- APPROVAL --}}

<h6 class="fw-bold mb-3">Approval Details</h6>

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label">Approval Status</label>

<select name="approval_status"
class="form-control">

<option value="Pending">Pending</option>

<option value="Approved">Approved</option>

<option value="Rejected">Rejected</option>

</select>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">Approved By</label>

<select name="approved_by"
class="form-control">

<option value="">Select Approver</option>

@foreach($approvers as $staff)

<option value="{{ $staff->id }}"
{{ old('approved_by', $entry->approved_by ?? '') == $staff->id ? 'selected' : '' }}>

{{ $staff->name }}

</option>

@endforeach

</select>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">Approved Date</label>

<input type="date"
name="approved_date"
class="form-control"
value="{{ old('approved_date', $entry->approved_date ?? '') }}">

</div>

</div>

<hr>

{{-- PAYROLL LOCK --}}

<h6 class="fw-bold mb-3">Payroll Lock</h6>

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label">Locked for Payroll</label>

<select name="locked_for_payroll"
class="form-control">

<option value="0">No</option>

<option value="1">Yes</option>

</select>

</div>

</div>

</form>

</div>

</div>

@endsection
