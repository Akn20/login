@extends('layouts.admin')

@section('page-title', 'Assign Shift')

@section('content')

<div class="page-header mb-4">
    <div class="page-header-left">
        <h5>Assign Shift</h5>
    </div>
</div>

<form action="{{ route('admin.shift-assignments.store') }}" method="POST">

    @include('hr.shift_scheduling.shift_assignment.form')

    <div class="text-end mt-3">
        <button type="submit" class="btn btn-primary">
            Assign Shift
        </button>
    </div>

</form>

@endsection