@extends('layouts.admin')

@section('page-title','Deleted Shift Assignments')

@section('content')

<div class="page-header mb-4">

<div class="page-header-left">
<h5>Deleted Assignments</h5>
</div>

<div class="page-header-right ms-auto">

<a href="{{ route('admin.shift-assignments.index') }}"
class="btn btn-secondary">
Back
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
<th>Employee</th>
<th>Shift</th>
<th>Start</th>
<th>Deleted At</th>
<th class="text-center">Actions</th>
</tr>

</thead>

<tbody>

@forelse($assignments as $index => $row)

<tr>

<td>{{ $index+1 }}</td>

<td>{{ $row->staff->name ?? '-' }}</td>

<td>{{ $row->shift->shift_name ?? '-' }}</td>

<td>{{ $row->start_date }}</td>

<td>{{ $row->deleted_at }}</td>

<td class="text-center">

<div class="d-flex justify-content-center gap-2">

<!-- Restore -->
<form action="{{ route('admin.shift-assignments.restore',$row->id) }}"
method="POST">
@csrf
@method('PUT')

<button class="btn btn-outline-success btn-icon rounded-circle">
<i class="feather-rotate-ccw"></i>
</button>

</form>

<!-- Permanent Delete -->
<form action="{{ route('admin.shift-assignments.forceDelete',$row->id) }}"
method="POST"
onsubmit="return confirm('Permanently delete?')">

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
<td colspan="6" class="text-center">
No Deleted Records
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

@endsection