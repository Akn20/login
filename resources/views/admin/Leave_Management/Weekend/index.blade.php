@extends('layouts.admin')

@section('page-title', 'Weekend Configurations | ' . config('app.name'))
@section('title', 'Weekend Configurations')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-title">
            <h5 class="m-b-10 mb-1">
                <i class="feather-calendar me-2"></i>Weekend Configurations
            </h5>
            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">Weekend Configurations</li>
            </ul>
        </div>

        <div class="d-flex gap-2 align-items-center">
            {{-- Filter: status + search --}}
            <form method="GET" action="{{ route('hr.weekends.index') }}" class="d-flex">
                <select name="status" class="form-control form-control-sm me-2">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <input type="text" name="search" class="form-control form-control-sm me-2"
                    placeholder="Search Configuration" value="{{ request('search') }}">

                <button class="btn btn-light-brand btn-sm">
                    <i class="feather-search"></i>
                </button>
            </form>

            <a href="{{ route('hr.weekends.create') }}" class="btn btn-primary">
                <i class="feather-plus me-1"></i> Add Weekend
            </a>

            <a href="{{ route('hr.weekends.deleted') }}" class="btn btn-danger">
                Deleted Weekends
            </a>
        </div>
    </div>

    <div class="card stretch stretch-full">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Configuration Name</th>
                            <th>Selected Days</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($weekends->count())
                            @foreach ($weekends as $index => $weekend)
                                <tr>
                                    <td>{{ $weekends->firstItem() ? $weekends->firstItem() + $index : $index + 1 }}</td>

                                    <td>{{ $weekend->name }}</td>

                                    <td>
                                        @php
                                            $days = is_array($weekend->days)
                                                ? $weekend->days
                                                : (json_decode($weekend->days, true) ?? []);
                                        @endphp
                                        {{ $days ? implode(', ', $days) : '-' }}
                                    </td>

                                    <td>
                                        @if ($weekend->status === 'active')
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        @else
                                            <span class="badge bg-soft-danger text-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td>{{ $weekend->created_at?->format('d-m-Y H:i') }}</td>

                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2 align-items-center">

                                            <a href="{{ route('hr.weekends.edit', $weekend->id) }}"
                                                class="btn btn-outline-secondary btn-icon rounded-circle" title="Edit">
                                                <i class="feather-edit-2"></i>
                                            </a>

                                            <form action="{{ route('hr.weekends.delete', $weekend->id) }}" method="POST"
                                                onsubmit="return confirm('Move weekend configuration to trash?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" title="Trash">
                                                    <i class="feather feather-trash-2"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('hr.weekends.toggleStatus', $weekend->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="status-toggle {{ $weekend->status === 'active' ? 'inactive' : 'active' }}">
                                                    <span>
                                                        {{ $weekend->status === 'active' ? 'Deactivate' : 'Activate' }}
                                                    </span>
                                                </button>
                                            </form>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">No Weekend Configurations Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($weekends->hasPages())
                <div class="mt-3 px-3 pb-3">
                    {{ $weekends->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection