@extends('layouts.admin')

@section('page-title','Rotation Details')

@section('content')

<div class="card">

<div class="card-body">

<h5 class="mb-4">Rotation Details</h5>

<p><strong>Employee:</strong> {{ $rotation->staff->name }}</p>

<p><strong>First Shift:</strong> {{ $rotation->firstShift->shift_name }}</p>

<p><strong>Second Shift:</strong> {{ $rotation->secondShift->shift_name }}</p>

<p><strong>Rotation Days:</strong> {{ $rotation->rotation_days }}</p>

<p><strong>Start Date:</strong> {{ $rotation->start_date }}</p>

<p><strong>Status:</strong>
{{ $rotation->status ? 'Active' : 'Inactive' }}
</p>

</div>

</div>

@endsection