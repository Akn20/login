@extends('layouts.admin')

@section('page-title','Edit Weekly Off')

@section('content')

<div class="page-header mb-4">

<div class="page-header-left d-flex align-items-center">

<div class="page-header-title">
<h5 class="m-b-0">Edit Weekly Off</h5>
</div>

<ul class="breadcrumb ms-3">

<li class="breadcrumb-item">
<a href="{{ route('admin.weekly-offs.index') }}">
Weekly Off
</a>
</li>

<li class="breadcrumb-item">Edit</li>

</ul>

</div>

</div>

<form method="POST"
action="{{ route('admin.weekly-offs.update',$weeklyOff->id) }}">

@method('PUT')

@include('hr.shift_scheduling.weekly_off.form')

</form>

@endsection