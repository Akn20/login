@extends('layouts.admin')

@section('page-title', 'Edit User | ' . config('app.name'))
@section('title', 'Edit User')

@section('content')

    <div class="page-header mb-4">
        <div class="d-flex align-items-center w-100">

            <div class="page-header-title">
                <h5 class="m-b-10 mb-1">
                    <i class="feather-user me-2"></i>Edit User
                </h5>
                <ul class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.users.index') }}">Users</a>
                    </li>
                    <li class="breadcrumb-item">Edit</li>
                </ul>
            </div>

            <div class="ms-auto">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light">
                    Cancel
                </a>
            </div>

        </div>
    </div>


    <div class="card stretch stretch-full">
        <div class="card-body">

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <!-- LEFT COLUMN -->
                    <div class="col-lg-6">

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">

                                <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>

                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    <!-- RIGHT COLUMN -->
                    <div class="col-lg-6">

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role_id" class="form-select @error('role_id') is-invalid @enderror">

                                <option value="">Select Role</option>

                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
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


                <!-- BUTTONS -->
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection