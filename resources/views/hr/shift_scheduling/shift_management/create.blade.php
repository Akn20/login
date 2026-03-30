@extends('layouts.admin')

@section('content')

<div class="card">

    <div class="card-header">
        <h5>Create Shift</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.shifts.store') }}" method="POST">

            @include('hr.shift_scheduling.shift_management.form')

            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">
                    Save Shift
                </button>
            </div>

        </form>

    </div>

</div>

@endsection