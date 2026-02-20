@extends('layouts.admin')

@section('page-title', 'Deleted Organizations | ' . config('app.name'))
@section('title', 'Deleted Organizations')

@section('content')
    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-title">
            <h5 class="m-b-10 mb-1">
                <i class="feather-trash-2 me-2"></i>Deleted Organizations
            </h5>
            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.organization.index') }}">Organizations</a>
                </li>
                <li class="breadcrumb-item">Deleted</li>
            </ul>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.organization.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="feather-arrow-left me-1"></i> Back to Organizations
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card stretch stretch-full">
        <div class="card-body custom-card-action p-0">

            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr class="border-b">
                            <th>Sl.No</th>
                            <th>Organization Name</th>
                            <th>Type</th>
                            <th>Email</th>
                            <th>Plan</th>
                            <th>Deleted At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($organizations as $index => $organization)
                            <tr>
                                <td>{{ $organizations->firstItem() ? $organizations->firstItem() + $index : $index + 1 }}</td>

                                <td>
                                    <div class="fw-bold">{{ $organization->name }}</div>
                                    <small class="text-muted">{{ $organization->city }}</small>
                                </td>

                                <td>{{ $organization->type ?? '-' }}</td>

                                <td>{{ $organization->email }}</td>

                                <td>
                                    <span class="badge bg-soft-primary text-primary">
                                        {{ $organization->plan_type ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <small class="text-muted">
                                        {{ optional($organization->deleted_at)->format('d M Y, H:i') }}
                                    </small>
                                </td>

                                <td class="text-end">
                                    <div class="hstack gap-2 justify-content-end">

                                        {{-- Restore --}}
                                        <form action="{{ route('admin.organization.restore', $organization->id) }}"
                                            method="POST" onsubmit="return confirm('Restore this organization?')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip" title="Restore">
                                                <i class="feather feather-rotate-ccw"></i>
                                            </button>
                                        </form>

                                        {{-- Force Delete --}}
                                        <form action="{{ route('admin.organization.forceDelete', $organization->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Permanently delete this organization? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip" title="Delete Permanently">
                                                <i class="feather feather-trash-2"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center p-4">
                                    No Deleted Organizations Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <div class="card-footer">
            {{ $organizations->links() }}
        </div>
    </div>
@endsection