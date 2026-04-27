@extends('layouts.admin')

@section('page-title', 'Edit Calibration | ' . config('app.name'))

@section('content')

<div class="main-content">
    <form method="POST" action="{{ route('admin.laboratory.calibration.update', $calibration->id) }}">
        @csrf
        @method('PUT')

        @include('admin.laboratory.calibration.form')

        <button class="btn btn-primary">Update</button>
    </form>
</div>

@endsection