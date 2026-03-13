@extends('layouts.admin')

@section('page-title','Weekly Off | ' . config('app.name'))

@section('content')

<!-- Page Header -->
<div class="page-header mb-4">

<div class="page-header-left d-flex align-items-center">

<div class="page-header-title">
<h5 class="m-b-0">Weekly Off</h5>
</div>

<ul class="breadcrumb ms-3">
<li class="breadcrumb-item">HR Management</li>
<li class="breadcrumb-item">Shift Scheduling</li>
<li class="breadcrumb-item">Weekly Off</li>
</ul>

</div>

<div class="page-header-right ms-auto d-flex align-items-center gap-2">

<!-- Search -->
<form method="GET"
action="{{ route('admin.weekly-offs.index') }}"
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
<a href="{{ route('admin.weekly-offs.create') }}"
class="btn btn-primary">

<i class="feather-plus me-2"></i> Add Weekly Off

</a>

<!-- Deleted -->
<a href="{{ route('admin.weekly-offs.deleted') }}"
class="btn btn-danger">

Deleted Weekly Off

</a>

</div>

</div>


<div class="card stretch stretch-full">

<div class="card-body p-0">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-light">

<tr>
<th>#</th>
<th>Employee</th>
<th>Weekly Off</th>
<th>Status</th>
<th class="text-center">Actions</th>
</tr>

</thead>

<tbody>

@forelse($weeklyOffs as $index => $row)

<tr>

<td>
{{ $weeklyOffs->firstItem() ? $weeklyOffs->firstItem() + $index : $index + 1 }}
</td>

<td>{{ $row->staff->name ?? '-' }}</td>

<td>{{ $row->week_day }}</td>

<td>{{ $row->status ? 'Active' : 'Inactive' }}</td>

<td class="text-center">

<div class="d-flex justify-content-center gap-2 align-items-center">

<!-- View -->
<a href="{{ route('admin.weekly-offs.show',$row->id) }}"
class="btn btn-outline-secondary btn-icon rounded-circle"
title="View">

<i class="feather-eye"></i>

</a>

<!-- Edit -->
<a href="{{ route('admin.weekly-offs.edit',$row->id) }}"
class="btn btn-outline-secondary btn-icon rounded-circle"
title="Edit">

<i class="feather-edit-2"></i>

</a>

<!-- Delete -->
<form action="{{ route('admin.weekly-offs.destroy',$row->id) }}"
method="POST"
onsubmit="return confirm('Move weekly off to trash?')">

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
<td colspan="5" class="text-center">
No Weekly Off Found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

<div class="card-footer">
{{ $weeklyOffs->links() }}
</div>

</div>

@endsection