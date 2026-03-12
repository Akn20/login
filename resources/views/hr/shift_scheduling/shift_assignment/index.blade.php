@extends('layouts.admin')

@section('page-title','Shift Assignments | ' . config('app.name'))

@section('content')

<!-- Page Header -->
<div class="page-header mb-4">

    <div class="page-header-left d-flex align-items-center">

        <div class="page-header-title">
            <h5 class="m-b-0">Shift Assignments</h5>
        </div>

        <ul class="breadcrumb ms-3">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.shift-assignments.index') }}">Assignments</a>
            </li>
            <li class="breadcrumb-item">List</li>
        </ul>

    </div>

    <div class="page-header-right ms-auto d-flex align-items-center gap-2">

        <!-- Search -->
        <form method="GET"
              action="{{ route('admin.shift-assignments.index') }}"
              class="d-flex">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Search Employee..."
                   style="width:220px;">

            <button class="btn btn-light ms-2">
                <i class="feather-search"></i>
            </button>

        </form>

        <!-- Create -->
        <a href="{{ route('admin.shift-assignments.create') }}"
           class="btn btn-primary">
            <i class="feather-plus me-2"></i> Assign Shift
        </a>

        <!-- Deleted -->
        <a href="{{ route('admin.shift-assignments.deleted') }}"
           class="btn btn-danger">
            Deleted Assignments
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
<th>Employee</th>
<th>Shift</th>
<th>Start Date</th>
<th>End Date</th>
<th>Status</th>
<th class="text-center">Actions</th>
</tr>

</thead>

<tbody>

@forelse ($assignments as $index => $row)

<tr>

<td>
{{ $assignments->firstItem() ? $assignments->firstItem() + $index : $index + 1 }}
</td>

<td>{{ $row->staff->name ?? '-' }}</td>

<td>{{ $row->shift->shift_name ?? '-' }}</td>

<td>{{ $row->start_date }}</td>

<td>{{ $row->end_date ?? '-' }}</td>

<td>{{ $row->status ? 'Active' : 'Inactive' }}</td>

<td class="text-center">

<div class="d-flex justify-content-center gap-2 align-items-center">

<!-- View -->
<a href="{{ route('admin.shift-assignments.show',$row->id) }}"
class="btn btn-outline-secondary btn-icon rounded-circle"
title="View">

<i class="feather-eye"></i>

</a>

<!-- Edit -->
<a href="{{ route('admin.shift-assignments.edit',$row->id) }}"
class="btn btn-outline-secondary btn-icon rounded-circle"
title="Edit">

<i class="feather-edit-2"></i>

</a>

<!-- Delete -->
<form action="{{ route('admin.shift-assignments.destroy',$row->id) }}"
method="POST"
onsubmit="return confirm('Move assignment to trash?')">

@csrf
@method('DELETE')

<button type="submit"
class="avatar-text avatar-md d-flex align-items-center justify-content-center"
title="Trash">

<i class="feather-trash-2"></i>

</button>

</form>

</div>

</td>

</tr>

@empty

<tr>
<td colspan="7" class="text-center">
No Assignments Found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

<div class="card-footer">
{{ $assignments->links() }}
</div>

</div>

</div>
</div>

@endsection