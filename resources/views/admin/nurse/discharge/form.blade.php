@extends('layouts.admin')

@section('content')

    <div class="nxl-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Discharge Preparation</h5>
                </div>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Nurse</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.nurse-discharge.index') }}">Discharge Preparation</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row justify-content-center">
                <div class="col-lg-7">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.nurse-discharge.save') }}">
                        @csrf
                        <input type="hidden" name="ipd_admission_id" value="{{ $ipd->id }}">

                        <!-- Patient Details -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Patient Details</h5>
                            </div>

                            <div class="card-body">
                                <p><strong>Name:</strong> {{ $ipd->patient->first_name ?? '' }} {{ $ipd->patient->last_name ?? '' }}</p>
                                <p><strong>Admission ID:</strong> {{ $ipd->admission_id }}</p>
                                <p><strong>Ward:</strong> {{ $ipd->ward->ward_name ?? '-' }} </p>
                            </div>
                        </div>

                        <!-- Checklist -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Discharge Checklist</h5>
                            </div>

                            <div class="card-body">
                                @php $check = $record->checklist ?? []; @endphp

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="checklist[iv_removed]"
                                                {{ isset($check['iv_removed']) ? 'checked' : '' }}>
                                            <label class="form-check-label">IV Removed</label>
                                        </div>

                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="checklist[catheter_removed]"
                                                {{ isset($check['catheter_removed']) ? 'checked' : '' }}>
                                            <label class="form-check-label">Catheter Removed</label>
                                        </div>                           
                                    
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="checklist[dressing_done]"
                                                {{ isset($check['dressing_done']) ? 'checked' : '' }}>
                                            <label class="form-check-label">Dressing Done</label>
                                        </div>

                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="checklist[vitals_recorded]"
                                                {{ isset($check['vitals_recorded']) ? 'checked' : '' }}>
                                            <label class="form-check-label">Final Vitals Recorded</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                        <!-- Belongings -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Belongings </h5>
                            </div>

                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Belongings Status</label>
                                    <select name="belongings_status" class="form-control">
                                        <option value="1" {{ isset($record) && $record->belongings_status ? 'selected' : '' }}>
                                            Returned
                                        </option>
                                        <option value="0" {{ isset($record) && !$record->belongings_status ? 'selected' : '' }}>
                                            Not Returned
                                        </option>
                                    </select>
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex gap-2 mt-5">
                                    <button type="submit" class="btn btn-primary">Save</button>

                                    @if(isset($record))
                                        <a href="{{ route('admin.nurse-discharge.ready', $record->id) }}"
                                            class="btn btn-success">Mark as Ready
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.nurse-discharge.index') }}" class="btn btn-secondary"> Back</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection