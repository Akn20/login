@extends('layouts.admin')

@section('page-title','Create Rotational Shift')

@section('content')

<div class="page-header mb-4">

<div class="page-header-left d-flex align-items-center">

<div class="page-header-title">
<h5 class="m-b-0">Create Rotation</h5>
</div>

<ul class="breadcrumb ms-3">

<li class="breadcrumb-item">
<a href="{{ route('admin.shift-rotations.index') }}">
Rotational Shifts
</a>
</li>

<li class="breadcrumb-item">Create</li>

</ul>

</div>

</div>


<form method="POST" action="{{ route('admin.shift-rotations.store') }}">

@include('hr.shift_scheduling.shift_rotation.form')

</form>

@endsection