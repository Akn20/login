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

    {{-- ACTION BUTTONS --}}
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


{{-- ================= BASIC DETAILS ================= --}}

<h6 class="fw-bold mb-3">Basic Details</h6>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
Employee *
</label>

<select name="employee_id"
class="form-control">

<option value="">
Select Employee
</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Work Type *
</label>

<select name="work_type_code"
class="form-control">

<option value="">
Select Work Type
</option>

<option value="OT">
OT
</option>

<option value="HRLY">
HRLY
</option>

</select>

</div>

</div>


<hr>


{{-- ================= TIME DETAILS ================= --}}

<h6 class="fw-bold mb-3">Time Details</h6>

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label">
Payroll Month *
</label>

<input type="month"
name="payroll_month"
class="form-control">

</div>

<div class="col-md-4 mb-3">

<label class="form-label">
Attendance Date *
</label>

<input type="date"
name="attendance_date"
class="form-control">

</div>

<div class="col-md-4 mb-3">

<label class="form-label">
Approved Hours *
</label>

<input type="number"
step="0.1"
name="approved_hours"
class="form-control">

</div>

</div>


<hr>


{{-- ================= CONTEXT ================= --}}

<h6 class="fw-bold mb-3">Context Details</h6>

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label">
Shift Code
</label>

<input type="text"
name="shift_code"
class="form-control">

</div>

<div class="col-md-4 mb-3">

<label class="form-label">
Day Type
</label>

<select name="day_type"
class="form-control">

<option value="Working">
Working
</option>

<option value="Weekend">
Weekend
</option>

<option value="Holiday">
Holiday
</option>

</select>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">
Source Type *
</label>

<select name="source_type"
class="form-control">

<option value="Biometric">
Biometric
</option>

<option value="Manual">
Manual
</option>

</select>

</div>

</div>


<hr>


{{-- ================= APPROVAL ================= --}}

<h6 class="fw-bold mb-3">Approval Details</h6>

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label">
Approval Status
</label>

<select name="approval_status"
class="form-control">

<option value="Pending">
Pending
</option>

<option value="Approved">
Approved
</option>

<option value="Rejected">
Rejected
</option>

</select>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">
Approved By
</label>

<input type="text"
name="approved_by"
class="form-control">

</div>

<div class="col-md-4 mb-3">

<label class="form-label">
Approved Date
</label>

<input type="date"
name="approved_date"
class="form-control">

</div>

</div>


<hr>


{{-- ================= PAYROLL LOCK ================= --}}

<h6 class="fw-bold mb-3">Payroll Lock</h6>

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label">
Locked for Payroll
</label>

<select name="locked_for_payroll"
class="form-control">

<option value="0">
No
</option>

<option value="1">
Yes
</option>

</select>

</div>

</div>

</form>

</div>

</div>

@endsection