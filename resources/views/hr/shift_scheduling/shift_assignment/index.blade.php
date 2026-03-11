@extends('layouts.admin')

@section('page-title','Shift Assignments')

@section('content')

<div class="page-header mb-4">

    <div class="page-header-left">
        <h5>Shift Assignments</h5>
    </div>

    <div class="page-header-right ms-auto">

        <a href="{{ route('admin.shift-assignments.create') }}"
           class="btn btn-primary">
            Assign Shift
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
<th class="text-end">Actions</th>
</tr>

</thead>

<tbody>

@forelse ($assignments as $index => $row)

<tr>

<td>{{ $index + 1 }}</td>

<td>{{ $row->staff->name ?? '-' }}</td>

<td>{{ $row->shift->shift_name ?? '-' }}</td>

<td>{{ $row->start_date }}</td>

<td>{{ $row->end_date ?? '-' }}</td>

<td>
    {{ $row->status ? 'Active' : 'Inactive' }}
</td>

<td class="text-end">

<a href="{{ route('admin.shift-assignments.edit',$row->id) }}"
   class="btn btn-outline-secondary btn-icon rounded-circle">

<i class="feather-edit-2"></i>

</a>

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

</div>

</div>
</div>

@endsection