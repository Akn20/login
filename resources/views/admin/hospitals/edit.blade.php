@extends('layouts.admin')

@section('page-title', 'Edit Hospital | ' . config('app.name'))
@section('title', 'Edit Hospital')

@section('content')
<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-title">
        <h5 class="m-b-10"><i class="feather-edit me-2"></i>Edit Hospital</h5>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.hospitals.index') }}">Hospitals</a></li>
            <li class="breadcrumb-item">Edit</li>
        </ul>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>There were some problems with your input.</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.hospitals.update', $hospital->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Hospital Name <span class="text-danger">*</span></label>
                    <input type="text"
                           id="name"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $hospital->name) }}"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="code" class="form-label">Code</label>
                    <input type="text"
                           id="code"
                           name="code"
                           class="form-control @error('code') is-invalid @enderror"
                           value="{{ old('code', $hospital->code) }}">
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="institution_id" class="form-label">Institution <span class="text-danger">*</span></label>
                    <select id="institution_id"
                            name="institution_id"
                            class="form-select @error('institution_id') is-invalid @enderror"
                            required>
                        <option value="">Select Institution</option>
                        @foreach ($institutions as $institution)
                            <option value="{{ $institution->id }}"
                                {{ old('institution_id', $hospital->institution_id) == $institution->id ? 'selected' : '' }}>
                                {{ $institution->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('institution_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea id="address"
                          name="address"
                          rows="3"
                          class="form-control @error('address') is-invalid @enderror">{{ old('address', $hospital->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="contact_number" class="form-label">Contact Number</label>
                    <input type="text"
                           id="contact_number"
                           name="contact_number"
                           class="form-control @error('contact_number') is-invalid @enderror"
                           value="{{ old('contact_number', $hospital->contact_number) }}">
                    @error('contact_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select id="status"
                            name="status"
                            class="form-select @error('status') is-invalid @enderror"
                            required>
                        <option value="1" {{ old('status', $hospital->status ? '1' : '0') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $hospital->status ? '1' : '0') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.hospitals.index') }}" class="btn btn-light me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Hospital</button>
            </div>
        </form>
    </div>
</div>
@endsection
