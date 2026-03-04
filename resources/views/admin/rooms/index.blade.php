@extends('layouts.admin')

@section('page-title', 'Rooms | ' . config('app.name'))

@section('content')

    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-title">
            <h5 class="m-b-10 mb-1">
                <i class="feather-grid me-2"></i>Rooms
            </h5>
            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">Rooms</li>
            </ul>
        </div>

        <div class="d-flex gap-2 align-items-center">

            {{-- Search --}}
            <form method="GET" action="{{ route('admin.rooms.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search Room"
                    value="{{ request('search') }}">
                <button class="btn btn-light-brand btn-sm">
                    <i class="feather-search"></i>
                </button>
            </form>

            {{-- Add --}}
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                <i class="feather-plus me-1"></i> Add Room
            </a>

            {{-- Deleted --}}
            <a href="{{ route('admin.rooms.deleted') }}" class="btn btn-danger">
                Deleted Rooms
            </a>

        </div>
    </div>


    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead>
                        <tr>
                            <th>SL.No</th>
                            <th>Room Number</th>
                            <th>Ward</th>
                            <th>Room Type</th>
                            <th>Total Beds</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($rooms as $room)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $room->room_number }}</td>
                                <td>{{ $room->ward->ward_name ?? '-' }}</td>
                                <td>{{ $room->room_type }}</td>
                                <td>{{ $room->beds()->count() }}</td>

                                {{-- Status Badge --}}
                                <td>
                                    @if($room->status == 'available')
                                        <span class="badge bg-soft-success text-success">
                                            Available
                                        </span>
                                    @elseif($room->status == 'occupied')
                                        <span class="badge bg-soft-danger text-danger">
                                            Occupied
                                        </span>
                                    @elseif($room->status == 'maintenance')
                                        <span class="badge bg-soft-dark text-dark">
                                            Maintenance
                                        </span>
                                    @elseif($room->status == 'cleaning')
                                        <span class="badge bg-soft-warning text-warning">
                                            Cleaning
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($room->status) }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Action --}}
                                <td>
                                    <div class="d-flex gap-2 align-items-center">

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.rooms.edit', $room->id) }}" class="avatar-text avatar-md"
                                            title="Edit">
                                            <i class="feather feather-edit"></i>
                                        </a>

                                        {{-- Delete (Soft Delete) --}}
                                        <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="m-0"
                                            onsubmit="return confirm('Move this room to deleted list?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                                                title="Delete">
                                                <i class="feather feather-trash-2"></i>
                                            </button>

                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    No Rooms Found
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

@endsection