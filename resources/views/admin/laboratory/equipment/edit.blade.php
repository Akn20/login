@extends('layouts.admin')

@section('page-title', 'Edit Equipment | ' . config('app.name'))

@section('content')

<div class="main-content">
    <form method="POST" action="{{ route('admin.laboratory.equipment.update', $equipment->id) }}">
        @csrf
        @method('PUT')
        @include('admin.laboratory.equipment.form')

        <button class="btn btn-primary">Update</button>
    </form>
</div>

@endsection