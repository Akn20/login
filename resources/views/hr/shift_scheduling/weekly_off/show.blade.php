@extends('layouts.admin')

@section('page-title','Weekly Off Details')

@section('content')

<div class="card">

<div class="card-body">

<h5 class="mb-4">Weekly Off Details</h5>

<p><strong>Employee:</strong> {{ $weeklyOff->staff->name }}</p>

<p><strong>Weekly Off Day:</strong> {{ $weeklyOff->week_day }}</p>

<p><strong>Status:</strong>
{{ $weeklyOff->status ? 'Active' : 'Inactive' }}
</p>

</div>

</div>

@endsection