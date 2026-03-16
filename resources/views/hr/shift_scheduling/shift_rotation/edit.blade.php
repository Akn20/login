@extends('layouts.admin')

@section('page-title','Edit Rotational Shift')

@section('content')

<div class="page-header mb-4">

<div class="page-header-left d-flex align-items-center">

<div class="page-header-title">
<h5 class="m-b-0">Edit Rotation</h5>
</div>

<ul class="breadcrumb ms-3">

<li class="breadcrumb-item">
<a href="{{ route('admin.shift-rotations.index') }}">
Rotational Shifts
</a>
</li>

<li class="breadcrumb-item">Edit</li>

</ul>

</div>

</div>


<form method="POST"
action="{{ route('admin.shift-rotations.update',$rotation->id) }}">

@method('PUT')

@include('hr.shift_scheduling.shift_rotation.form')

</form>

@endsection