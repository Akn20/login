@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5 class="m-b-10 text-danger">Deleted Organizations</h5>
    </div>

    <div class="page-header-right ms-auto">
        <a href="{{ route('admin.organization.index') }}" class="btn btn-light-brand btn-sm">
            <i class="feather-arrow-left me-1"></i> Back to List
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
                            <th>Email</th>
                            <th>Deleted At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($organizations as $organization)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $organization->name }}</td>
                            <td>{{ $organization->email }}</td>
                            <td>{{ $organization->deleted_at->format('d M Y H:i') }}</td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    <!-- Restore -->
                                    <a href="{{ route('admin.organization.restore', $organization->id) }}"
                                       class="avatar-text avatar-md text-success"
                                       data-bs-toggle="tooltip"
                                       title="Restore">
                                        <i class="feather feather-rotate-ccw"></i>
                                    </a>

                                    <!-- Permanent Delete -->
                                    <form action="{{ route('admin.organization.forceDelete', $organization->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Permanently delete this organization?')"
                                          class="m-0">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="avatar-text avatar-md border-0 bg-transparent text-danger"
                                                data-bs-toggle="tooltip"
                                                title="Delete Permanently">
                                            <i class="feather feather-trash-2"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
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
</div>

@endsection
