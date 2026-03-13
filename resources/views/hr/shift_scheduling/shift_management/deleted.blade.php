@extends('layouts.admin')

@section('page-title', 'Deleted Shifts')

@section('content')

    <div class="page-header mb-4">

        <div class="page-header-left d-flex align-items-center">

            <div class="page-header-title">
                <h5 class="m-b-0">Deleted Shifts</h5>
            </div>

        </div>

        <div class="page-header-right ms-auto">

            <a href="{{ route('admin.shifts.index') }}" class="btn btn-secondary">
                Back to Shifts
            </a>

        </div>

    </div>

    <div class="card">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>Shift Name</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Deleted At</th>
                            <th class="text-end">Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($shifts as $index => $shift)

                            <tr>

                                <td>{{ $index + 1 }}</td>

                                <td>{{ $shift->shift_name }}</td>

                                <td>{{ $shift->start_time }}</td>

                                <td>{{ $shift->end_time }}</td>

                                <td>{{ $shift->deleted_at }}</td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        <!-- Restore -->
                                        <form action="{{ route('admin.shifts.restore', $shift->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" class="btn btn-outline-success btn-icon rounded-circle"
                                                title="Restore">
                                                <i class="feather-rotate-ccw"></i>
                                            </button>
                                        </form>

                                        <!-- Permanent Delete -->
                                        <form action="{{ route('admin.shifts.forceDelete', $shift->id) }}" method="POST"
                                            onsubmit="return confirm('Permanently delete this shift?')">
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
                                <td colspan="6" class="text-center">
                                    No deleted shifts
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection