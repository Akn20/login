@extends('layouts.admin')

@section('page-title', 'Edit Organization | ' . config('app.name'))

@section('content')

    <h2>Edit Organization</h2>

    <form method="POST" action="{{ route('admin.organization.update', $organization->id) }}">
        @csrf
        @method('PUT')

        <input class="form-control mb-2" name="name" value="{{ $organization->name }}">
        <input class="form-control mb-2" name="type" value="{{ $organization->type }}">
        <input class="form-control mb-2" name="email" value="{{ $organization->email }}">
        <input class="form-control mb-2" name="plan_type" value="{{ $organization->plan_type }}">

        <select class="form-control mb-2" name="status">
            <option value="1" {{ $organization->status ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$organization->status ? 'selected' : '' }}>Inactive</option>
        </select>

        <button class="btn btn-primary">Update</button>

    </form>

@endsection