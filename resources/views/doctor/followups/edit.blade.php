
@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header">

            <h4 class="mb-0">
                Edit Follow-up
            </h4>

            <a href="{{ route('doctor.followups.index') }}"
               class="btn btn-primary btn-sm">
                <i class="feather-arrow-left"></i>
                Back
            </a>

        </div>

        <div class="card-body">

            <form action="{{ route('doctor.followups.update', $followup->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Follow-up Date
                        </label>

                        <input type="date"
                               name="follow_up_date"
                               class="form-control"
                               value="{{ $followup->follow_up_date }}"
                               required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-control">

                            <option value="Pending"
                                {{ $followup->status == 'Pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="Completed"
                                {{ $followup->status == 'Completed' ? 'selected' : '' }}>
                                Completed
                            </option>

                            <option value="Missed"
                                {{ $followup->status == 'Missed' ? 'selected' : '' }}>
                                Missed
                            </option>

                        </select>

                    </div>

                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Remarks
                        </label>

                        <textarea name="remarks"
                                  rows="4"
                                  class="form-control">{{ $followup->remarks }}</textarea>

                    </div>

                </div>

                <button class="btn btn-primary">

                    Update Follow-up

                </button>

                
            </form>

        </div>

    </div>

</div>

@endsection

