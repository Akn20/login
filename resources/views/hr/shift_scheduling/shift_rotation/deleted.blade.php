@extends('layouts.admin')

@section('page-title','Deleted Rotations')

@section('content')

<div class="card">

<div class="card-body p-0">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>
<th>#</th>
<th>Employee</th>
<th>First Shift</th>
<th>Second Shift</th>
<th>Deleted At</th>
<th class="text-center">Actions</th>
</tr>

</thead>

<tbody>

@forelse($rotations as $index => $row)

<tr>

<td>{{ $index+1 }}</td>

<td>{{ $row->staff->name ?? '-' }}</td>

<td>{{ $row->firstShift->shift_name ?? '-' }}</td>

<td>{{ $row->secondShift->shift_name ?? '-' }}</td>

<td>{{ $row->deleted_at }}</td>

<td class="text-center">

<div class="d-flex justify-content-center gap-2">

<!-- Restore -->
<form action="{{ route('admin.shift-rotations.restore',$row->id) }}"
method="POST">

@csrf
@method('PUT')

<button class="btn btn-outline-success btn-icon rounded-circle">

<i class="feather-rotate-ccw"></i>

</button>

</form>

<!-- Permanent Delete -->
<form action="{{ route('admin.shift-rotations.forceDelete',$row->id) }}"
method="POST"
onsubmit="return confirm('Delete permanently?')">

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
<td colspan="6" class="text-center">No Deleted Rotations</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

@endsection