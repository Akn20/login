@extends('layouts.admin')

@section('content')

    <div class="page-header">
        <div class="page-header-left">
            <h5 class="m-b-10">Institutions</h5>
        </div>
        <div class="page-header-right ms-auto d-flex gap-2">

            {{-- Search --}}
            <form method="GET" action="{{ route('admin.institutions.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search Institution"
                    value="{{ request('search') }}">
                <button class="btn btn-light-brand btn-sm">
                    <i class="feather-search"></i>
                </button>
            </form>

            {{-- Add --}}
            <a href="{{ route('admin.institutions.create') }}" class="btn btn-primary btn-sm">
                <i class="feather-plus me-1"></i> Add Institution
            </a>

            {{-- Deleted --}}
            <a href="{{ route('admin.institutions.deleted') }}" class="btn btn-danger btn-sm">
                Deleted Institutions
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
                                <th>Institution Name</th>
                                <th>Organization</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($institutions as $institution)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $institution->name }}</td>
                                    <td>{{ $institution->organization->name ?? '-' }}</td>
                                    <td>{{ $institution->email }}</td>
                                    <td>
                                        @if($institution->status)

                                            <span class="badge bg-soft-success text-success">Active</span>
                                        @else
                                            <span class="badge bg-soft-danger text-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="hstack gap-2 justify-content-end">

                                            {{-- View --}}
                                            <a href="{{ route('admin.institutions.show', $institution->id) }}"
                                                class="avatar-text avatar-md" data-bs-toggle="tooltip" title="View">
                                                <i class="feather feather-eye"></i>
                                            </a>

                                            {{-- Edit --}}
                                            <a href="{{ route('admin.institutions.edit', $institution->id) }}"
                                                class="avatar-text avatar-md" data-bs-toggle="tooltip" title="Edit">
                                                <i class="feather feather-edit"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('admin.institutions.destroy', $institution->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this institution?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" title="Delete">
                                                    <i class="feather feather-trash-2"></i>
                                                </button>
                                            </form>

                                            <!--Status Toggle-->
                                            <form action="{{ route('admin.institutions.toggleStatus', $institution->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="status-toggle {{ $institution->status ? 'active' : 'inactive' }}">
                                                    <span>
                                                        {{ $institution->status ? 'Deactivate' : 'Activate' }}
                                                    </span>
                                                </button>
                                            </form>




                                        </div>
                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        No Institutions Found
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>

            <div class="card-footer">
                {{ $institutions->links() }}
            </div>

        </div>
    </div>

@endsection