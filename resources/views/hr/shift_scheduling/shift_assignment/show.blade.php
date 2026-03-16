@extends('layouts.admin')

@section('page-title','Assignment Details')

@section('content')

<div class="card">

<div class="card-body">

<h5 class="mb-4">Assignment Details</h5>

<p><strong>Employee:</strong> {{ $assignment->staff->name }}</p>

<p><strong>Shift:</strong> {{ $assignment->shift->shift_name }}</p>

<p><strong>Start Date:</strong> {{ $assignment->start_date }}</p>

<p><strong>End Date:</strong> {{ $assignment->end_date ?? '-' }}</p>

<p><strong>Status:</strong>
{{ $assignment->status ? 'Active' : 'Inactive' }}
</p>

</div>

</div>

@endsection