@extends('layouts.admin')

@section('page-title','Shift Details')

@section('content')

<div class="page-header mb-4">

<div class="page-header-left d-flex align-items-center">

<div class="page-header-title">
<h5 class="m-b-0">Shift Details</h5>
</div>

</div>

<div class="page-header-right ms-auto">

<a href="{{ route('admin.shifts.index') }}"
class="btn btn-secondary">
Back
</a>

</div>

</div>

<div class="card">

<div class="card-body">

<div class="row">

<div class="col-md-6">

<p><strong>Shift Name:</strong> {{ $shift->shift_name }}</p>

<p><strong>Start Time:</strong>
{{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }}
</p>

<p><strong>End Time:</strong>
{{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
</p>

</div>

<div class="col-md-6">

<p><strong>Grace Minutes:</strong>
{{ $shift->grace_minutes ?? '-' }}
</p>

<p><strong>Break Minutes:</strong>
{{ $shift->break_minutes ?? '-' }}
</p>

<p><strong>Status:</strong>
{{ $shift->status ? 'Active' : 'Inactive' }}
</p>

</div>

</div>

</div>

</div>

@endsection