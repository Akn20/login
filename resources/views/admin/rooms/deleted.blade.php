@extends('layouts.admin')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-title">
        <h5 class="m-b-10 mb-1">
            <i class="feather-trash-2 me-2"></i>Deleted Rooms
        </h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.rooms.index') }}">Rooms</a>
            </li>
            <li class="breadcrumb-item">Deleted</li>
        </ul>
    </div>

    <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-primary">
        <i class="feather-arrow-left me-1"></i> Back
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

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
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $room->room_number }}</td>
                            <td>{{ $room->ward->ward_name ?? '-' }}</td>
                            <td>{{ $room->room_type }}</td>
                            <td>{{ $room->total_beds }}</td>

                            <td>
                                <span class="badge bg-soft-secondary text-secondary">
                                    Deleted
                                </span>
                            </td>

                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">

                                    {{-- Restore --}}
                                    <form action="{{ route('admin.rooms.restore', $room->id) }}"
                                          method="POST"
                                          class="m-0">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit"
                                            class="avatar-text avatar-md border-0 bg-transparent text-success"
                                            title="Restore">
                                            <i class="feather-rotate-ccw"></i>
                                        </button>
                                    </form>

                                    {{-- Permanent Delete --}}
                                    <form action="{{ route('admin.rooms.forceDelete', $room->id) }}"
                                          method="POST"
                                          class="m-0"
                                          onsubmit="return confirm('Permanently delete this room?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="avatar-text avatar-md border-0 bg-transparent text-danger"
                                            title="Delete Permanently">
                                            <i class="feather-trash-2"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                No Deleted Rooms Found
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection