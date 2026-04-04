@extends('layouts.admin')

@section('page-title', 'Equipment | ' . config('app.name'))

@section('content')

<div class="page-header mb-4">
    <div class="page-header-left">
        <h5>Equipment</h5>
    </div>

        <div class="page-header-right ms-auto d-flex align-items-center gap-2">

        <!-- SEARCH -->
        <form method="GET"
            action="{{ route('admin.laboratory.equipment.index') }}"
            class="d-flex align-items-center">

            <input type="text"
                name="search"
                class="form-control"
                placeholder="Search Equipment..."
                value="{{ request('search') }}"
                style="width: 220px;">

            <button class="btn btn-light ms-2">
                <i class="feather-search"></i>
            </button>
        </form>

        <!-- ADD -->
        <a href="{{ route('admin.laboratory.equipment.create') }}"
        class="btn btn-primary">
            <i class="feather-plus me-2"></i> New Equipment
        </a>

        <!-- DELETED -->
        <a href="{{ route('admin.laboratory.equipment.deleted') }}"
        class="btn btn-danger">
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
                    <th>Code</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Condition</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($equipment as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->equipment_code }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->condition_status }}</td>

                        <td>
                            @include('partials.status-toggle', [
                                'id' => $item->id,
                                'url' => route('admin.laboratory.equipment.toggleStatus', $item->id),
                                'checked' => (bool) $item->status,
                                'type' => 'status'
                            ])
                        </td>

                        <td class="d-flex gap-2">

                            <a href="{{ route('admin.laboratory.equipment.show', $item->id) }}"
                                class="btn btn-outline-secondary btn-icon rounded-circle">
                                <i class="feather-eye"></i>
                            </a>

                            <a href="{{ route('admin.laboratory.equipment.edit', $item->id) }}"
                                class="btn btn-outline-secondary btn-icon rounded-circle">
                                <i class="feather-edit-2"></i>
                            </a>

                            <form action="{{ route('admin.laboratory.equipment.destroy', $item->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-icon rounded-circle">
                                    <i class="feather-trash-2"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Equipment Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection
