@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    {{-- HEADER --}}
    <div class="page-header d-flex justify-content-between align-items-center">
        <h5>Edit Scan Request</h5>

        <a href="{{ route('admin.radiology.scan-requests.index') }}" class="btn btn-secondary btn-sm">
            ← Back
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="card">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.radiology.scan-requests.update', $requestData->id) }}">
                @csrf

                {{-- PATIENT --}}
                <div class="mb-3">
                    <label>Patient</label>
                    <select name="patient_id" class="form-control">

                        @foreach($patients as $p)
                        <option value="{{ $p->id }}"
                            {{ $requestData->patient_id == $p->id ? 'selected' : '' }}>

                            {{ $p->first_name }} {{ $p->last_name }}

                        </option>
                        @endforeach

                    </select>
                </div>

                {{-- SCAN TYPE --}}
                <div class="mb-3">
                    <label>Scan Type</label>
                    <select name="scan_type_id" class="form-control">

                        @foreach($scanTypes as $s)
                        <option value="{{ $s->id }}"
                            {{ $requestData->scan_type_id == $s->id ? 'selected' : '' }}>

                            {{ $s->name }}

                        </option>
                        @endforeach

                    </select>
                </div>

                {{-- BODY PART --}}
                <div class="mb-3">
                    <label>Body Part</label>
                    <input type="text"
                        name="body_part"
                        value="{{ $requestData->body_part }}"
                        class="form-control">
                </div>

                {{-- REASON --}}
                <div class="mb-3">
                    <label>Reason</label>
                    <textarea name="reason" class="form-control">{{ $requestData->reason }}</textarea>
                </div>

                {{-- PRIORITY --}}
                <div class="mb-3">
                    <label>Priority</label>
                    <select name="priority" class="form-control">
                        <option value="Normal" {{ $requestData->priority == 'Normal' ? 'selected' : '' }}>Normal</option>
                        <option value="Urgent" {{ $requestData->priority == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>

                {{-- DOCTOR --}}
                <div class="mb-3">
                    <label>Doctor</label>
                    <select name="doctor_id" class="form-control">

                        @foreach($doctors as $d)
                        <option value="{{ $d->id }}"
                            {{ $requestData->doctor_id == $d->id ? 'selected' : '' }}>

                            {{ $d->name ?? $d->email }}

                        </option>
                        @endforeach

                    </select>
                </div>

                {{-- STATUS --}}
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="Pending" {{ $requestData->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Scheduled" {{ $requestData->status == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="Uploaded" {{ $requestData->status == 'Uploaded' ? 'selected' : '' }}>Uploaded</option>
                        <option value="Under Review" {{ $requestData->status == 'Under Review' ? 'selected' : '' }}>Under Review</option>
                        <option value="Approved" {{ $requestData->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ $requestData->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                {{-- SUBMIT --}}
                <button class="btn btn-primary">Update Request</button>

            </form>

        </div>
    </div>

</div>

@endsection