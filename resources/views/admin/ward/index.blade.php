@extends('layouts.admin')

@section('page-title', 'Wards | ' . config('app.name'))

@section('content')

    <div class="page-header">
        <div class="page-header-left">
            <h5 class="m-b-10">Wards</h5>
        </div>
        <div class="page-header-right ms-auto d-flex gap-2">

            {{-- Search --}}
            <form method="GET" action="{{ route('admin.ward.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search Ward"
                    value="{{ request('search') }}">
                <button class="btn btn-light-brand btn-sm">
                    <i class="feather-search"></i>
                </button>
            </form>

            {{-- Add --}}
            <a href="{{ route('admin.ward.create') }}" class="btn btn-primary btn-sm">
                <i class="feather-plus me-1"></i> Add Ward
            </a>

            {{-- Deleted --}}
            <a href="{{ route('admin.ward.deleted') }}" class="btn btn-danger btn-sm">
                Deleted Wards
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
                                <th>Ward Name</th>
                                <th>Type</th>
                                <th>Floor</th>
                                <th>Total Beds</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                        </thead>
                        <tbody>

                            @forelse($wards as $ward)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ward->ward_name }}</td>
                                    <td>{{ $ward->ward_type }}</td>
                                    <td>{{ $ward->floor_number }}</td>
                                    <td>{{ $ward->total_beds }}</td>
                                    <td>
                                        @if($ward->status)

                                            <span class="badge bg-soft-success text-success">Active</span>
                                        @else
                                            <span class="badge bg-soft-danger text-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="hstack gap-2 justify-content-end">

                                            {{-- View --}}
                                            <a href="{{ route('admin.ward.show', $ward->id) }}" class="avatar-text avatar-md"
                                                data-bs-toggle="tooltip" title="View">
                                                <i class="feather feather-eye"></i>
                                            </a>

                                            {{-- Edit --}}
                                            <a href="{{ route('admin.ward.edit', $ward->id) }}" class="avatar-text avatar-md"
                                                data-bs-toggle="tooltip" title="Edit">
                                                <i class="feather feather-edit"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('admin.ward.destroy', $ward->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this ward?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" title="Delete">
                                                    <i class="feather feather-trash-2"></i>
                                                </button>
                                            </form>

                                            <!--Status Toggle-->
                                            <form action="{{ route('admin.ward.toggleStatus', $ward->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="status-toggle {{ $ward->status ? 'active' : 'inactive' }}">
                                                    <span>
                                                        {{ $ward->status ? 'Deactivate' : 'Activate' }}
                                                    </span>
                                                </button>
                                            </form>




                                        </div>
                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        No Wards Found
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>

            <div class="card-footer">
                {{ $wards->links() }}
            </div>

        </div>
    </div>

@endsection