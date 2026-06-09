@extends('layouts.admin')

@section('content')

<div class="card">

    <div class="card-header">
        <h4>Add Hospital Working Hours</h4>
    </div>

    <div class="card-body">

        <form action="{{ route('hospital-working-hours.store') }}"
              method="POST">

            @csrf

            <div class="mb-3">
                <label>Opening Time</label>
                <input type="time"
                       name="opening_time"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label>Closing Time</label>
                <input type="time"
                       name="closing_time"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label>Break Start</label>
                <input type="time"
                       name="break_start"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Break End</label>
                <input type="time"
                       name="break_end"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>
                    <input type="checkbox"
                           name="emergency_24x7">
                    24x7 Emergency Available
                </label>
            </div>

            <div class="mb-3">

                <label>Status</label>

                <select name="status"
                        class="form-control">

                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>

                </select>

            </div>

            <button type="submit"
                    class="btn btn-primary">

                Save

            </button>

        </form>

    </div>

</div>

@endsection