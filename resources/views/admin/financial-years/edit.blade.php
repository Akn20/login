@extends('layouts.admin')

@section('page-title', 'Add Financial Year | ' .config('app.name'))
@section('title', 'Add Financial Year')

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center w-100">

        {{-- LEFT SIDE --}}
        <div class="page-header-title">
            <h5 class="m-b-10">
                <i class="feather-calendar me-2"></i>Add Financial Year
            </h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.financial-years.index') }}">Financial Years</a>
                </li>
                <li class="breadcrumb-item">Create</li>
            </ul>
        </div>

        {{-- RIGHT SIDE BUTTONS --}}
        <div class="d-flex gap-2">
            <a href="{{ route('admin.financial-years.index') }}" class="btn btn-light">
                <i class="feather-x me-2"></i> Cancel
            </a>

            <button type="submit" form="financialYearForm" class="btn btn-primary">
                <i class="feather-save me-2"></i> Save
            </button>
        </div>

    </div>
</div>

<div class="card stretch stretch-full">
    <div class="card-body">

        {{-- FORM START --}}
        <form action="{{ route('admin.financial-years.store') }}" method="POST" id="financialYearForm">
            @csrf

            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Code</label>
                        <input type="text" name="code"
                                value="{{ old('code') }}"
                                placeholder="2024-25"
                                class="form-control @error('code') is-invalid @enderror">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date"
                                value="{{ old('start_date') }}"
                                class="form-control @error('start_date') is-invalid @enderror">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date"
                                value="{{ old('end_date') }}"
                                class="form-control @error('end_date') is-invalid @enderror">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                    type="checkbox"
                                    id="is_active"
                                    name="is_active"
                                    value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        {{-- FORM END --}}

    </div>
</div>
@endsection
