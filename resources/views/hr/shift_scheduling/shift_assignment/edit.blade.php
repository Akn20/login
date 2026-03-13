@extends('layouts.admin')

@section('page-title', 'Edit Shift Assignment')

@section('content')

<div class="page-header mb-4">
    <div class="page-header-left">
        <h5>Edit Shift Assignment</h5>
    </div>
</div>

<form action="{{ route('admin.shift-assignments.update', $assignment->id) }}" method="POST">

    @csrf
    @method('PUT')

    @include('hr.shift_scheduling.shift_assignment.form')

    <div class="text-end mt-3">
        <button type="submit" class="btn btn-primary">
            Update Assignment
        </button>
    </div>

</form>

@endsection