@extends('layouts.admin')

@section('page-title', 'Edit Patient | ' . config('app.name'))

@section('content')

<div class="main-content">
    <form method="POST" action="{{ route('admin.patients.update', $patient->id) }}">
        @csrf
        @method('PUT')
        @include('admin.patients.form')
        <button class="btn btn-primary">Update</button>
    </form>
</div>

@endsection