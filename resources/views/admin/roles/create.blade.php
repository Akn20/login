@extends('layouts.admin')

@section('page-title', 'Add Role | ' .config('app.name'))
@section('title', 'Add Role | ' .config('app.name'))

@section('content')
        <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center w-100">

            <!-- LEFT SIDE -->
            <div class="page-header-title">
                <h5 class="m-b-10 mb-1">
                    <i class="feather-shield me-2"></i>Add Role
                </h5>
                <ul class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.roles.index') }}">Roles</a>
                    </li>
                    <li class="breadcrumb-item">Create</li>
                </ul>
            </div>

            <!-- RIGHT SIDE BUTTONS -->
            <div class="d-flex gap-2">

                <a href="{{ route('admin.roles.index') }}" class="btn btn-light">
                    <i class="feather-x me-2"></i>
                    <span>Cancel</span>
                </a>

                <button type="submit"  form="userForm"
                        class="btn btn-primary">
                    <i class="feather-save me-2"></i>
                    <span>Save</span>
                </button>

            </div>

    </div>
</div>

    <div class="card stretch stretch-full">
        <div class="card-body">
            <form action="{{ route('admin.roles.store') }}" method="POST" id="userForm">
                @csrf
<div class="row">
    <div class="col-lg-6">
        <!-- Left Box -->
    
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3"
                        class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div></div>

                 <div class="col-lg-6">
        <!-- Right Box -->
  
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div></div></div>

              
                </div>
            </form>
        </div>
  
@endsection