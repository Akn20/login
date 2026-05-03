@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Edit IPD Admission</h4>
        <a href="{{ route('admin.receptionist.ipd.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <form action="{{ route('admin.receptionist.ipd.update', $ipd->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- ================= PATIENT ================= -->
        <div class="card mb-4">
            <div class="card-header"><strong>Patient Details</strong></div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4">
                        <label>Name</label>
                        <input type="text" class="form-control"
                        value="{{ $ipd->patient->first_name }} {{ $ipd->patient->last_name }}" readonly>
                    </div>

                    <div class="col-md-4">
                        <label>Mobile</label>
                        <input type="text" class="form-control"
                        value="{{ $ipd->patient->mobile }}" readonly>
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= ADMISSION ================= -->
        <div class="card mb-4">
            <div class="card-header"><strong>Admission Details</strong></div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-3">
                        <label>Admission ID</label>
                        <input type="text" class="form-control"
                        value="{{ $ipd->admission_id }}" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Admission Date</label>
                        <input type="datetime-local" name="admission_date"
                        value="{{ \Carbon\Carbon::parse($ipd->admission_date)->format('Y-m-d\TH:i') }}"
                        class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>Department</label>
                        <select name="department_id" class="form-control">
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}"
                                {{ $ipd->department_id == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->department_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Doctor</label>
                        <select name="doctor_id" class="form-control">
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}"
                                {{ $ipd->doctor_id == $doc->id ? 'selected' : '' }}>
                                    {{ $doc->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mt-3">
                        <label>Admission Type</label>
                        <select name="admission_type" class="form-control">
                            <option value="planned" {{ $ipd->admission_type == 'planned' ? 'selected' : '' }}>Planned</option>
                            <option value="emergency" {{ $ipd->admission_type == 'emergency' ? 'selected' : '' }}>Emergency</option>
                        </select>
                    </div>

                </div>

            </div>
        </div>

        <!-- ================= BED ================= -->
        <div class="card mb-4">
            <div class="card-header"><strong>Ward / Bed</strong></div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">
                        <label>Ward</label>
                        <select name="ward_id" class="form-control">
                            @foreach($wards as $ward)
                                <option value="{{ $ward->id }}"
                                {{ $ipd->ward_id == $ward->id ? 'selected' : '' }}>
                                    {{ $ward->ward_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Room</label>
                        <select name="room_id" class="form-control">
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}"
                                {{ $ipd->room_id == $room->id ? 'selected' : '' }}>
                                    {{ $room->room_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Bed</label>
                        <select name="bed_id" class="form-control">
                            @foreach($beds as $bed)
                                <option value="{{ $bed->id }}"
                                {{ $ipd->bed_id == $bed->id ? 'selected' : '' }}>
                                    {{ $bed->bed_code }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>
        </div>

        <!-- ================= INSURANCE ================= -->
        <div class="card mb-4">
            <div class="card-header"><strong>Insurance</strong></div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">
                        <label>Insured?</label>
                        <select name="insurance_flag" class="form-control">
                            <option value="1" {{ $ipd->insurance_flag ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$ipd->insurance_flag ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Provider</label>
                        <input type="text" name="insurance_provider"
                        value="{{ $ipd->insurance_provider }}" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label>Policy</label>
                        <input type="text" name="policy_number"
                        value="{{ $ipd->policy_number }}" class="form-control">
                    </div>

                </div>

            </div>
        </div>

        <!-- ================= NOTES ================= -->
        <div class="card mb-4">
            <div class="card-header"><strong>Remarks</strong></div>
            <div class="card-body">
                <textarea name="notes" class="form-control">{{ $ipd->notes }}</textarea>
            </div>
        </div>

        <!-- SUBMIT -->
<div class="d-flex justify-content gap-2 mt-3">

    <!-- Update Button -->
    <button type="submit" name="action" value="update" class="btn btn-primary">
        Update Admission
    </button>

    <!-- Discharge Button -->
    @if($ipd->status != 'discharged')
        <button type="submit" name="action" value="discharge"
            class="btn btn-danger"
            onclick="return confirm('Are you sure to discharge this patient?')">
            Discharge
        </button>
    @else
        <button class="btn btn-secondary" disabled>
            Already Discharged
        </button>
    @endif

</div>
    </form>

</div>

@endsection