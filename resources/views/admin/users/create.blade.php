@extends('layouts.admin')

@section('page-title', 'Add User | ' . config('app.name'))
@section('title', 'Add User')

@section('content')

    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center w-100">

            <!-- LEFT SIDE -->
            <div class="page-header-title">
                <h5 class="m-b-10">
                    <i class="feather-user-plus me-2"></i>Add User
                </h5>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.users.index') }}">Users</a>
                    </li>
                    <li class="breadcrumb-item">Create</li>
                </ul>
            </div>

            <!-- RIGHT SIDE BUTTONS -->
            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light">
                    <i class="feather-x me-2"></i> Cancel
                </a>

                <button type="submit" form="userForm" class="btn btn-primary">
                    <i class="feather-save me-2"></i> Save
                </button>
            </div>

        </div>
    </div>


    <div class="card stretch stretch-full">
        <div class="card-body">

            <!-- FORM START -->
            <form action="{{ route('admin.users.store') }}" method="POST" id="userForm">
                @csrf

                <div class="row">

                    <!-- LEFT COLUMN -->
                    <div class="col-lg-6">

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mobile</label>
                            <input type="text" name="mobile" value="{{ old('mobile') }}"
                                class="form-control @error('mobile') is-invalid @enderror">

                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    <!-- RIGHT COLUMN -->
                    <div class="col-lg-6">

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">

                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>

                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role_id" class="form-select @error('role_id') is-invalid @enderror">

                                <option value="">Select Role</option>

                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                </div>
            </form>
            <!-- FORM END -->

        </div>
    </div>

@endsection