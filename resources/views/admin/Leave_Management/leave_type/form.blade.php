@extends('layouts.admin')

@section('page-title', 'Add Leave Type | ' . config('app.name'))
@section('title', 'Add Leave Type')

@section('content')

<div class="page-header mb-4">
    <div>
        <h5 class="mb-1">
            <i class="feather-plus-circle me-2"></i>Add Leave Type
        </h5>

        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">Leave Management</li>
            <li class="breadcrumb-item">Leave Type</li>
        </ul>
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

<form method="POST"
      action="{{ isset($leaveType)
            ? route('admin.leave-type.update', $leaveType->id)
            : route('admin.leave-type.store') }}">

    @csrf

    @if(isset($leaveType))
        @method('PUT')
    @endif
@csrf
{{-- ================= BASIC INFO ================= --}}
<h6 class="fw-bold mb-3">Basic Information</h6>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Leave Type Name *</label>
        <input type="text"
               name="display_name"
               class="form-control"
               placeholder="Enter leave type"
               value="{{ old('display_name', $leaveType->display_name ?? '') }}"
            >
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Description</label>
        <input type="text"
               name="description"
               class="form-control"
               placeholder="Optional description"
               value="{{ old('description', $leaveType->description ?? '') }}">
    </div>
</div>

<hr>
{{-- ================= DURATION RULES ================= --}}
<h6 class="fw-bold mb-3">Duration Rules</h6>

<div class="row">

    <div class="col-md-4 mb-3">
        <label class="form-label">Allow Half Day</label>
        <select name="allow_half_day" class="form-control">

            <option value="1"
                {{ old('allow_half_day', $leaveType->allow_half_day ?? '') == 1 ? 'selected' : '' }}>
                Yes
            </option>

            <option value="0"
                {{ old('allow_half_day', $leaveType->allow_half_day ?? '') == 0 ? 'selected' : '' }}>
                No
            </option>

        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Minimum Leave Unit</label>
        <select name="min_leave_unit" class="form-control">

            <option value="0.5"
                {{ old('min_leave_unit', $leaveType->min_leave_unit ?? '') == '0.5' ? 'selected' : '' }}>
                0.5
            </option>

            <option value="1"
                {{ old('min_leave_unit', $leaveType->min_leave_unit ?? '') == '1' ? 'selected' : '' }}>
                1
            </option>

        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Maximum Continuous Days</label>
        <input type="number"
               name="max_continuous_days"
               class="form-control"
               value="{{ old('max_continuous_days', $leaveType->max_continuous_days ?? '') }}">
    </div>

</div>

<hr>
{{-- ================= CALENDAR RULES ================= --}}
<h6 class="fw-bold mb-3">Calendar Rules</h6>

<div class="row">

    <div class="col-md-4 mb-3">
        <label class="form-label">Count Weekends</label>
        <select name="count_weekends" class="form-control">

            <option value="1"
                {{ old('count_weekends', $leaveType->count_weekends ?? '') == 1 ? 'selected' : '' }}>
                Yes
            </option>

            <option value="0"
                {{ old('count_weekends', $leaveType->count_weekends ?? '') == 0 ? 'selected' : '' }}>
                No
            </option>

        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Count Holidays</label>
        <select name="count_holidays" class="form-control">

            <option value="1"
                {{ old('count_holidays', $leaveType->count_holidays ?? '') == 1 ? 'selected' : '' }}>
                Yes
            </option>

            <option value="0"
                {{ old('count_holidays', $leaveType->count_holidays ?? '') == 0 ? 'selected' : '' }}>
                No
            </option>

        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Sandwich Rule Enabled</label>
        <select name="sandwich_enabled" class="form-control">

            <option value="1"
                {{ old('sandwich_enabled', $leaveType->sandwich_enabled ?? '') == 1 ? 'selected' : '' }}>
                Enabled
            </option>

            <option value="0"
                {{ old('sandwich_enabled', $leaveType->sandwich_enabled ?? '') == 0 ? 'selected' : '' }}>
                Disabled
            </option>

        </select>
    </div>

</div>

<div class="row">

    <div class="col-md-4 mb-3">
        <label class="form-label">Sandwich Applies On</label>
        <select name="sandwich_applies_on" class="form-control">

            <option value="Weekend"
                {{ old('sandwich_applies_on', $leaveType->sandwich_applies_on ?? '') == 'Weekend' ? 'selected' : '' }}>
                Weekend
            </option>

            <option value="Holiday"
                {{ old('sandwich_applies_on', $leaveType->sandwich_applies_on ?? '') == 'Holiday' ? 'selected' : '' }}>
                Holiday
            </option>

            <option value="Both"
                {{ old('sandwich_applies_on', $leaveType->sandwich_applies_on ?? '') == 'Both' ? 'selected' : '' }}>
                Both
            </option>

        </select>
    </div>

</div>

<hr>
{{-- ================= APPLICATION RULES ================= --}}
<h6 class="fw-bold mb-3">Application Rules</h6>

<div class="row">

    <div class="col-md-4 mb-3">
        <label class="form-label">Approval Required</label>
        <select name="approval_required" class="form-control">

            <option value="1"
                {{ old('approval_required', $leaveType->approval_required ?? '') == 1 ? 'selected' : '' }}>
                Yes
            </option>

            <option value="0"
                {{ old('approval_required', $leaveType->approval_required ?? '') == 0 ? 'selected' : '' }}>
                No
            </option>

        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Approval Level</label>
        <select name="approval_level" class="form-control">

            <option value="Single"
                {{ old('approval_level', $leaveType->approval_level ?? '') == 'Single' ? 'selected' : '' }}>
                Single
            </option>

            <option value="Multi"
                {{ old('approval_level', $leaveType->approval_level ?? '') == 'Multi' ? 'selected' : '' }}>
                Multi
            </option>

        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Allow Backdated Application</label>
        <select name="allow_backdate" class="form-control">

            <option value="1"
                {{ old('allow_backdate', $leaveType->allow_backdate ?? '') == 1 ? 'selected' : '' }}>
                Yes
            </option>

            <option value="0"
                {{ old('allow_backdate', $leaveType->allow_backdate ?? '') == 0 ? 'selected' : '' }}>
                No
            </option>

        </select>
    </div>

</div>

<div class="row">

    <div class="col-md-4 mb-3">
        <label class="form-label">Max Backdate Days</label>
        <input type="number"
               name="max_backdate_days"
               class="form-control"
               value="{{ old('max_backdate_days', $leaveType->max_backdate_days ?? '') }}">
    </div>

</div>

<hr>
{{-- ================= ATTENDANCE ================= --}}
<h6 class="fw-bold mb-3">Attendance Mapping</h6>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Attendance Code</label>
        <input type="text"
               name="attendance_code"
               class="form-control"
               value="{{ old('attendance_code', $leaveType->attendance_code ?? '') }}" required >
    </div>
</div>

<hr>

<div class="d-flex gap-2">

    {{-- CHANGE BUTTON TEXT BASED ON ADD / EDIT --}}
    <button type="submit" class="btn btn-primary">
        {{ isset($leaveType) ? 'Update Leave Type' : 'Save Leave Type' }}
    </button>

    <a href="{{ route('admin.leave-type.index') }}" class="btn btn-light">
        Cancel
    </a>

</div>

</form>

</div>
</div>

@endsection