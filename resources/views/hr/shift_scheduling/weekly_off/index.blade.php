@extends('layouts.admin')

@section('page-title','Weekly Off')

@section('content')

<div class="page-header mb-4">

<div class="page-header-left d-flex align-items-center">

<div class="page-header-title">
<h5 class="m-b-0">Weekly Off</h5>
</div>

</div>

<div class="page-header-right ms-auto">

<a href="{{ route('admin.weekly-offs.create') }}"
class="btn btn-primary">

<i class="feather-plus me-2"></i> Add Weekly Off

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
<th class="text-end">Actions</th>

</tr>

</thead>

<tbody>

@forelse($weeklyOffs as $index => $row)

<tr>

<td>{{ $weeklyOffs->firstItem() + $index }}</td>

<td>{{ $row->staff->name ?? '-' }}</td>

<td>{{ $row->week_day }}</td>

<td>{{ $row->status ? 'Active' : 'Inactive' }}</td>

<td class="text-end">

<a href="{{ route('admin.weekly-offs.edit',$row->id) }}"
class="btn btn-outline-secondary btn-icon rounded-circle">

<i class="feather-edit-2"></i>

</a>

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