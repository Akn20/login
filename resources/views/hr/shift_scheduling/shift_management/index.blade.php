@extends('layouts.admin')

@section('page-title', 'Shifts | ' . config('app.name'))

@section('content')

<!-- Page Header -->
<div class="page-header mb-4">

    <div class="page-header-left d-flex align-items-center">

        <div class="page-header-title">
            <h5 class="m-b-0">Shift Management</h5>
        </div>

        <ul class="breadcrumb ms-3">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.shifts.index') }}">Shifts</a>
            </li>
            <li class="breadcrumb-item">List</li>
        </ul>

    </div>

    <div class="page-header-right ms-auto d-flex align-items-center gap-2">

        <!-- Search -->
        <form method="GET" action="{{ route('admin.shifts.index') }}" class="d-flex">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Search Shift..."
                   style="width:220px;">

            <button class="btn btn-light ms-2">
                <i class="feather-search"></i>
            </button>

        </form>

        <!-- Create Shift -->
        <a href="{{ route('admin.shifts.create') }}" class="btn btn-primary">
            <i class="feather-plus me-2"></i> New Shift
        </a>

        <!-- Deleted Records -->
        <a href="{{ route('admin.shifts.deleted') }}" class="btn btn-danger">
            Deleted Shifts
        </a>

    </div>

</div>


<div class="row">
<div class="col-12">

<div class="card stretch stretch-full">

<div class="card-body p-0">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-light">

<tr>
<th>#</th>
<th>Shift Name</th>
<th>Start Time</th>
<th>End Time</th>
<th>Grace Time</th>
<th>Status</th>
<th class="text-end">Actions</th>
</tr>

</thead>

<tbody>

@forelse ($shifts as $index => $shift)

<tr>

<td>
{{ $shifts->firstItem() ? $shifts->firstItem() + $index : $index + 1 }}
</td>

<td class="fw-bold">
{{ $shift->shift_name }}
</td>

<td>
{{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }}
</td>

<td>
{{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
</td>

<td>
{{ $shift->grace_minutes ?? '-' }} min
</td>

<td>

@include('partials.status-toggle', [
'id' => $shift->id,
'url' => route('admin.shifts.toggleStatus',$shift->id),
'checked' => (bool)$shift->status,
'type' => 'status'
])

</td>

<td class="text-center">

    <div class="d-flex justify-content-end gap-2 align-items-center">

        <!-- View -->
        <a href="{{ route('admin.shifts.show', $shift->id) }}"
           class="btn btn-outline-secondary btn-icon rounded-circle"
           title="View">
            <i class="feather-eye"></i>
        </a>

        <!-- Edit -->
        <a href="{{ route('admin.shifts.edit', $shift->id) }}"
           class="btn btn-outline-secondary btn-icon rounded-circle"
           title="Edit">
            <i class="feather-edit-2"></i>
        </a>

        <!-- Delete -->
        <form action="{{ route('admin.shifts.destroy', $shift->id) }}"
              method="POST"
              onsubmit="return confirm('Move shift to trash?')">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                    data-bs-toggle="tooltip"
                    title="Trash">

                <i class="feather feather-trash-2"></i>

            </button>

        </form>

    </div>

</td>

</tr>

@empty

<tr>
<td colspan="7" class="text-center">
No shifts found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

<div class="card-footer">
{{ $shifts->links() }}
</div>

</div>

</div>
</div>

@endsection