@extends('layouts.admin')

@section('page-title', 'Edit Maintenance | ' . config('app.name'))

@section('content')

<div class="main-content">
    <form method="POST" action="{{ route('admin.laboratory.maintenance.update', $maintenance->id) }}">
        @csrf
        @method('PUT')

        @include('admin.laboratory.maintenance.form')

        <button class="btn btn-primary">Update</button>
    </form>
</div>

@endsection