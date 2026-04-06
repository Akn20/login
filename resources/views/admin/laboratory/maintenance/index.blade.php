@extends('layouts.admin')

@section('page-title', 'Maintenance | ' . config('app.name'))

@section('content')

<<div class="page-header mb-4">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-0">Maintenance</h5>
        </div>

        <ul class="breadcrumb ms-3">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.laboratory.maintenance.index') }}">Maintenance</a>
            </li>
            <li class="breadcrumb-item">List</li>
        </ul>
    </div>

    <div class="page-header-right ms-auto d-flex align-items-center gap-2">

        <!-- SEARCH -->
        <form method="GET" action="{{ route('admin.laboratory.maintenance.index') }}" class="d-flex">
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                class="form-control"
                placeholder="Search Maintenance..."
                style="width: 220px;">

            <button class="btn btn-light ms-2">
                <i class="feather-search"></i>
            </button>
        </form>

        <!-- ADD -->
        <a href="{{ route('admin.laboratory.maintenance.create') }}" class="btn btn-primary">
            <i class="feather-plus me-2"></i> New Maintenance
        </a>

        <!-- DELETED -->
        <a href="{{ route('admin.laboratory.maintenance.deleted') }}" class="btn btn-danger">
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
                    <th>Status</th>
                    <th>Technician</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($maintenance as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->equipment->name ?? '-' }}</td>
                        <td>{{ $item->maintenance_type }}</td>
                        <td>{{ $item->maintenance_date }}</td>

                        <td>
                            <span class="badge bg-{{ 
                                $item->status == 'Completed' ? 'success' :
                                ($item->status == 'In Progress' ? 'warning' : 'secondary')
                            }}">
                                {{ $item->status }}
                            </span>
                        </td>

                        <td>{{ $item->technician ?? '-' }}</td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.laboratory.maintenance.show', $item->id) }}"
                                class="btn btn-outline-secondary btn-icon rounded-circle"
                                title="View">
                                    <i class="feather-eye"></i>
                                </a>

                                <a href="{{ route('admin.laboratory.maintenance.edit', $item->id) }}"
                                    class="btn btn-outline-secondary btn-icon rounded-circle">
                                    <i class="feather-edit-2"></i>
                                </a>

                                <form action="{{ route('admin.laboratory.maintenance.destroy', $item->id) }}"
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