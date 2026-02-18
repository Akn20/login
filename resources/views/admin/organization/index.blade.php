@extends('layouts.admin')

@section('content')

    <div class="page-header">
        <div class="page-header-left">
            <h5 class="m-b-10">Organizations</h5>
        </div>
        <div class="page-header-right ms-auto d-flex gap-2">

            {{-- Search --}}
            <form method="GET" action="{{ route('admin.organization.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search Organization"
                    value="{{ request('search') }}">
                <button class="btn btn-light-brand btn-sm">
                    <i class="feather-search"></i>
                </button>
            </form>

            {{-- Add --}}
            <a href="{{ route('admin.organization.create') }}" class="btn btn-primary btn-sm">
                <i class="feather-plus me-1"></i> Add Organization
            </a>

            {{-- Deleted --}}
            <a href="{{ route('admin.organization.deleted') }}" class="btn btn-danger btn-sm">
                Deleted Organizations
            </a>

        </div>
    </div>


    <div class="main-content">
        <div class="card stretch stretch-full">
            <div class="card-body custom-card-action p-0">

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="border-b">
                                <th>Sl.No</th>
                                <th>Organization Name</th>
                                <th>Type</th>
                                <th>Email</th>
                                <th>Plan</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($organizations as $organization)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $organization->name }}</td>
                                    <td>{{ $organization->type }}</td>
                                    <td>{{ $organization->email }}</td>
                                    <td>
                                        <span class="badge bg-soft-primary text-primary">
                                            {{ $organization->plan_type }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($organization->status == 1)
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        @else
                                            <span class="badge bg-soft-danger text-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="hstack gap-2 justify-content-end">

                                            {{-- View --}}
                                            <a href="{{ route('admin.organization.show', $organization->id) }}"
                                                class="avatar-text avatar-md" data-bs-toggle="tooltip" title="View">
                                                <i class="feather feather-eye"></i>
                                            </a>

                                            {{-- Edit --}}
                                            <a href="{{ route('admin.organization.edit', $organization->id) }}"
                                                class="avatar-text avatar-md" data-bs-toggle="tooltip" title="Edit">
                                                <i class="feather feather-edit"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('admin.organization.destroy', $organization->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this organization?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" title="Delete">
                                                    <i class="feather feather-trash-2"></i>
                                                </button>
                                            </form>

                                            <!--Status Toggle-->
                                            <form action="{{ route('admin.organization.toggleStatus', $organization->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="status-toggle {{ $organization->status ? 'active' : 'inactive' }}">
                                                    <span>
                                                        {{ $organization->status ? 'Deactivate' : 'Activate' }}
                                                    </span>
                                                </button>
                                            </form>


                                        </div>
                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        No Organizations Found
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
    </div>

@endsection