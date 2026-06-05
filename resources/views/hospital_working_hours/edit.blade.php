@extends('layouts.admin')

@section('content')

<div class="main-content">

    <div class="card">

        <div class="card-header">
            <h4>Edit Hospital Working Hours</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('hospital-working-hours.update', $workingHour->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Opening Time</label>

                    <input type="time"
                           name="opening_time"
                           class="form-control"
                           value="{{ $workingHour->opening_time }}">
                </div>

                <div class="mb-3">
                    <label>Closing Time</label>

                    <input type="time"
                           name="closing_time"
                           class="form-control"
                           value="{{ $workingHour->closing_time }}">
                </div>

                <div class="mb-3">
                    <label>Break Start</label>

                    <input type="time"
                           name="break_start"
                           class="form-control"
                           value="{{ $workingHour->break_start }}">
                </div>

                <div class="mb-3">
                    <label>Break End</label>

                    <input type="time"
                           name="break_end"
                           class="form-control"
                           value="{{ $workingHour->break_end }}">
                </div>

                <div class="mb-3">

                    <label>

                        <input type="checkbox"
                               name="emergency_24x7"
                               {{ $workingHour->emergency_24x7 ? 'checked' : '' }}>

                        24x7 Emergency Available

                    </label>

                </div>

                <div class="mb-3">

                    <label>Status</label>

                    <select name="status"
                            class="form-control">

                        <option value="Active"
                            {{ $workingHour->status == 'Active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="Inactive"
                            {{ $workingHour->status == 'Inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                </div>

                <div class="mt-3 d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary"
                            style="width:auto !important;">

                        Update

                    </button>

                    <a href="{{ route('hospital-working-hours.index') }}"
                       class="btn btn-danger"
                       style="width:auto !important;">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection