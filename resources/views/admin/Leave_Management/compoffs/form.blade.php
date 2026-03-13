@extends('layouts.admin')

@section('page-title', (isset($compoff) ? 'Edit' : 'Add') . ' Comp-Off | ' . config('app.name'))
@section('title', (isset($compoff) ? 'Edit' : 'Add') . ' Comp-Off')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center w-100">

        {{-- LEFT SIDE --}}
        <div class="page-header-title">
            <h5 class="m-b-10">
                <i class="feather-calendar me-2"></i>
                {{ isset($compoff) ? 'Edit Comp-Off Entry' : 'Add Comp-Off Entry' }}
            </h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('hr.compoffs.index') }}">Comp-Off</a>
                </li>
                <li class="breadcrumb-item">{{ isset($compoff) ? 'Edit' : 'Create' }}</li>
            </ul>
        </div>

        {{-- RIGHT SIDE — Back to List only --}}
        <div class="d-flex gap-2">
            <a href="{{ route('hr.compoffs.index') }}" class="btn btn-light">
                <i class="feather-arrow-left me-2"></i> Back to List
            </a>
        </div>

    </div>
</div>


<div class="card stretch stretch-full">
    <div class="card-body">

        {{-- FORM START --}}
        <form action="{{ isset($compoff)
                ? route('hr.compoffs.update', $compoff->id)
                : route('hr.compoffs.store') }}"
            method="POST"
            id="compoffForm">

            @csrf
            @if(isset($compoff))
                @method('PUT')
            @endif

            <div class="row">

                {{-- LEFT COLUMN --}}
                <div class="col-lg-6">

                    {{-- Employee --}}
                    <div class="mb-3">
                        <label class="form-label">Employee <span class="text-danger">*</span></label>
                        <select name="employee_id"
                                class="form-select @error('employee_id') is-invalid @enderror">
                            <option value="">Select Employee</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}"
                                    {{ old('employee_id', $compoff->employee_id ?? '') == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Worked On --}}
                    <div class="mb-3">
                        <label class="form-label">Worked On <span class="text-danger">*</span></label>
                        <input type="date"
                               name="worked_on"
                               value="{{ old('worked_on', $compoff->worked_on ?? '') }}"
                               class="form-control @error('worked_on') is-invalid @enderror">
                        @error('worked_on')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- RIGHT COLUMN --}}
                <div class="col-lg-6">

                    {{-- Comp-Off Credited --}}
                    <div class="mb-3">
                        <label class="form-label">Comp-Off Credited <span class="text-danger">*</span></label>
                        <input type="number"
                               step="0.5"
                               name="comp_off_credited"
                               value="{{ old('comp_off_credited', $compoff->comp_off_credited ?? '') }}"
                               class="form-control @error('comp_off_credited') is-invalid @enderror"
                               placeholder="Enter comp-off days">
                        @error('comp_off_credited')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Expiry Date --}}
                    <div class="mb-3">
                        <label class="form-label">Expiry Date</label>
                        <input type="date"
                               name="expiry_date"
                               value="{{ old('expiry_date', $compoff->expiry_date ?? '') }}"
                               class="form-control @error('expiry_date') is-invalid @enderror">
                        @error('expiry_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

            </div>

            {{-- BOTTOM BUTTONS --}}
            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('hr.compoffs.index') }}" class="btn btn-light">
                    <i class="feather-x me-2"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="feather-save me-2"></i>
                    {{ isset($compoff) ? 'Update' : 'Save' }}
                </button>
            </div>

        </form>
        {{-- FORM END --}}

    </div>
</div>

@endsection