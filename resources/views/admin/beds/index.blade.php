@extends('layouts.admin')

@section('page-title', 'Beds | ' . config('app.name'))

@section('content')

  <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-title">
            <h5 class="m-b-10 mb-1">
                <i class="feather-grid me-2"></i>Beds
            </h5>
            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">Beds</li>
            </ul>
        </div>

        <div class="d-flex gap-2 align-items-center">
            <form method="GET" action="{{ route('admin.beds.index') }}" class="d-flex">
                <input
                    type="text"
                    name="search"
                    class="form-control form-control-sm me-2"
                    placeholder="Search Bed"
                    value="{{ request('search') }}"
                >
                <button class="btn btn-light-brand btn-sm">
                    <i class="feather-search"></i>
                </button>
            </form>

            <a href="{{ route('admin.beds.create') }}" class="btn btn-primary">
                <i class="feather-plus me-1"></i> Add Bed
            </a>

            <a href="{{ route('admin.beds.deleted') }}" class="btn btn-danger">
                Deleted Beds
            </a>
        </div>
    </div>

<div class="card"

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>SL.No</th>
                        <th>Bed Code</th>
                        <th>Ward</th>
                        <th>Room</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($beds as $bed)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $bed->bed_code }}</td>
                            <td>{{ $bed->ward->ward_name ?? '-' }}</td>
                            <td>{{ $bed->room_number ?? '-' }}</td>
                            <td>{{ $bed->bed_type }}</td>
                            <td>
                                @if($bed->status == 'Available')
                                    <span class="badge bg-soft-success text-success">Available</span>
                                @elseif($bed->status == 'Occupied')
                                    <span class="badge bg-soft-danger text-danger">Occupied</span>
                                @elseif($bed->status == 'Maintenance')
                                    <span class="badge bg-soft-dark text-dark">Maintenance</span>
                                @elseif($bed->status == 'Cleaning')
                                    <span class="badge bg-soft-warning text-warning">Cleaning</span>
                                @else
                                    <span class="badge bg-secondary">{{ $bed->status }}</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex gap-2 align-items-center">

                                {{--Edit --}}
                                    <a href="{{ route('admin.beds.edit', $bed->id) }}"
                                        class="avatar-text avatar-md" title="Edit">
                                        <i class="feather feather-edit"></i>
                                    </a>

                                   {{---Delete--}}
                                   <form action="{{ route('admin.beds.destroy', $bed->id) }}"
                                        method="POST"
                                        class="m-0"
                                        onsubmit="return confirm('Move this bed to deleted list?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                                            data-bs-toggle="tooltip"
                                            title="Delete">
                                            <i class="feather feather-trash-2"></i>
                                        </button>

                                    </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No Beds Found</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection