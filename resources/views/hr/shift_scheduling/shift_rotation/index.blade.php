@extends('layouts.admin')

@section('page-title','Rotational Shifts')

@section('content')

<div class="page-header mb-4">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-0">Rotational Shifts</h5>
        </div>

        <ul class="breadcrumb ms-3">
            <li class="breadcrumb-item">HR Management</li>
            <li class="breadcrumb-item">Shift Scheduling</li>
            <li class="breadcrumb-item">Rotational Shifts</li>
        </ul>
    </div>

    <div class="page-header-right ms-auto">

        <a href="{{ route('admin.shift-rotations.create') }}" class="btn btn-primary">
            <i class="feather-plus me-2"></i> New Rotation
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
<th>First Shift</th>
<th>Second Shift</th>
<th>Rotation Days</th>
<th>Start Date</th>
<th>Status</th>
<th class="text-end">Actions</th>
</tr>
</thead>

<tbody>

@forelse($rotations as $index => $row)

<tr>

<td>{{ $rotations->firstItem() + $index }}</td>

<td>{{ $row->staff->name ?? '-' }}</td>

<td>{{ $row->firstShift->shift_name ?? '-' }}</td>

<td>{{ $row->secondShift->shift_name ?? '-' }}</td>

<td>{{ $row->rotation_days }}</td>

<td>{{ $row->start_date }}</td>

<td>
{{ $row->status ? 'Active' : 'Inactive' }}
</td>

<td class="text-end">

<a href="{{ route('admin.shift-rotations.edit',$row->id) }}"
class="btn btn-outline-secondary btn-icon rounded-circle">

<i class="feather-edit-2"></i>

</a>

</td>

</tr>

@empty

<tr>
<td colspan="8" class="text-center">No Rotations Found</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

<div class="card-footer">

{{ $rotations->links() }}

</div>

</div>

</div>
</div>

@endsection