@extends('layouts.admin')

@section('page-title', 'Deleted Institutions | ' . config('app.name'))
@section('title', 'Deleted Institutions')

@section('content')
    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-title">
            <h5 class="m-b-10 mb-1">
                <i class="feather-trash-2 me-2"></i>Deleted Institutions
            </h5>
            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.institutions.index') }}">Institutions</a>
                </li>
                <li class="breadcrumb-item">Deleted</li>
            </ul>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.institutions.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="feather-arrow-left me-1"></i> Back to Institutions
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="card stretch stretch-full">
            <div class="card-body custom-card-action p-0">

                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr class="border-b">
                                <th>Sl.No</th>
                                <th>Institution Name</th>
                                <th>Organization</th>
                                <th>Email</th>
                                <th>Deleted At</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($institutions as $index => $institution)
                                <tr>
                                    <td>{{ $institutions->firstItem() ? $institutions->firstItem() + $index : $index + 1 }}</td>

                                    <td>{{ $institution->name }}</td>

                                    <td>{{ $institution->organization->name ?? '-' }}</td>

                                    <td>{{ $institution->email }}</td>

                                    <td>
                                        <small class="text-muted">
                                            {{ optional($institution->deleted_at)->format('d M Y, H:i') }}
                                        </small>
                                    </td>

                                    <td class="text-end">
                                        <div class="hstack gap-2 justify-content-end">
                                            {{-- View (optional) --}}
                                            @if(Route::has('admin.institutions.show'))
                                                <a href="{{ route('admin.institutions.show', $institution->id) }}"
                                                    class="btn btn-outline-secondary btn-icon rounded-circle" title="View">
                                                    <i class="feather-eye"></i>
                                                </a>
                                            @endif

                                            {{-- Restore --}}
                                            <form action="{{ route('admin.institutions.restore', $institution->id) }}"
                                                method="POST" onsubmit="return confirm('Restore this institution?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-outline-success btn-icon rounded-circle"
                                                    title="Restore">
                                                    <i class="feather-rotate-ccw"></i>
                                                </button>
                                            </form>

                                            {{-- Force Delete --}}
                                            <form action="{{ route('admin.institutions.forceDelete', $institution->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Permanently delete this institution? This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-icon rounded-circle"
                                                    title="Delete Permanently">
                                                    <i class="feather-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center p-4">
                                        No Deleted Institutions Found
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