@extends('layouts.admin')

@section('content')

<div class="page-header">
    <h4>Bed Management</h4>
</div>

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Beds</h5>

        <a href="{{ route('admin.beds.create') }}" class="btn btn-primary">
            + Add Bed
        </a>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Bed Code</th>
                        <th>Ward</th>
                        <th>Room</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th width="150">Action</th>
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
                                    <span class="badge bg-success">Available</span>
                                @elseif($bed->status == 'Occupied')
                                    <span class="badge bg-danger">Occupied</span>
                                @elseif($bed->status == 'Maintenance')
                                    <span class="badge bg-warning text-dark">Maintenance</span>
                                @elseif($bed->status == 'Cleaning')
                                    <span class="badge bg-info">Cleaning</span>
                                @else
                                    <span class="badge bg-secondary">{{ $bed->status }}</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.beds.edit', $bed->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>

                                <form action="{{ route('admin.beds.delete', $bed->id) }}"
                                      method="POST"
                                      style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure?')">
                                        Delete
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