@extends('layouts.admin')

@section('page-title', 'Calibration | ' . config('app.name'))

@section('content')

<div class="page-header mb-4">
    <div class="page-header-left d-flex align-items-center">
        <h5>Calibration</h5>
    </div>

    <div class="page-header-right ms-auto d-flex gap-2">

        <!-- SEARCH -->
        <form method="GET" class="d-flex">
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-control" placeholder="Search..." style="width:200px;">
            <button class="btn btn-light ms-2">
                <i class="feather-search"></i>
            </button>
        </form>

        <!-- ADD -->
        <a href="{{ route('admin.laboratory.calibration.create') }}" class="btn btn-primary">
            New Calibration
        </a>

        <!-- DELETED -->
        <a href="{{ route('admin.laboratory.calibration.deleted') }}" class="btn btn-danger">
            Deleted
        </a>

    </div>
</div>

<div class="card">
    <div class="card-body p-0">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Equipment</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Result</th>
                    <th>Next Due</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($calibrations as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->equipment->name ?? '-' }}</td>
                        <td>{{ $item->calibration_type }}</td>
                        <td>{{ $item->calibration_date }}</td>

                        <td>
                            <span class="badge bg-{{ $item->result == 'Pass' ? 'success' : 'danger' }}">
                                {{ $item->result }}
                            </span>
                        </td>

                        <td>{{ $item->next_due_date ?? '-' }}</td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">

                                <!-- VIEW -->
                                <a href="{{ route('admin.laboratory.calibration.show', $item->id) }}"
                                   class="btn btn-outline-secondary btn-icon rounded-circle">
                                    <i class="feather-eye"></i>
                                </a>

                                <!-- EDIT -->
                                <a href="{{ route('admin.laboratory.calibration.edit', $item->id) }}"
                                   class="btn btn-outline-secondary btn-icon rounded-circle">
                                    <i class="feather-edit-2"></i>
                                </a>

                                <!-- DELETE -->
                                <form action="{{ route('admin.laboratory.calibration.destroy', $item->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-outline-danger btn-icon rounded-circle">
                                        <i class="feather-trash-2"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Records Found</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

@endsection