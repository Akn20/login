@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>IPD Admission Details</h4>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.receptionist.ipd.index') }}" class="btn btn-secondary">
                Back
            </a>

            <a href="{{ route('admin.receptionist.ipd.print', $ipd->id) }}"
               target="_blank"
               class="btn btn-dark">
                <i class="fas fa-print"></i> Print
            </a>
        </div>
    </div>

    <!-- ================= STATUS BADGE ================= -->
    <div class="mb-3">
        @if($ipd->status == 'active')
            <span class="badge bg-success">Active</span>
        @else
            <span class="badge bg-danger">Discharged</span>
        @endif
    </div>

    <!-- ================= PATIENT ================= -->
    <div class="card mb-4">
        <div class="card-header"><strong>Patient Details</strong></div>
        <div class="card-body">
            <div class="row">

                <div class="col-md-4">
                    <label>Name</label>
                    <p>{{ $ipd->patient->first_name }} {{ $ipd->patient->last_name }}</p>
                </div>

                <div class="col-md-4">
                    <label>Mobile</label>
                    <p>{{ $ipd->patient->mobile }}</p>
                </div>

                <div class="col-md-4">
                    <label>Gender</label>
                    <p>{{ $ipd->patient->gender }}</p>
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
                    <p>{{ $ipd->admission_id }}</p>
                </div>

                <div class="col-md-3">
                    <label>Admission Date</label>
                    <p>{{ \Carbon\Carbon::parse($ipd->admission_date)->format('d-m-Y H:i') }}</p>
                </div>

                <div class="col-md-3">
                    <label>Department</label>
                    <p>{{ $ipd->department->department_name ?? '-' }}</p>
                </div>

                <div class="col-md-3">
                    <label>Doctor</label>
                    <p>{{ $ipd->doctor->name ?? '-' }}</p>
                </div>

                <div class="col-md-3 mt-3">
                    <label>Admission Type</label>
                    <p>{{ ucfirst($ipd->admission_type) }}</p>
                </div>
            </div>

        </div>
    </div>

    <!-- ================= BED ================= -->
    <div class="card mb-4">
        <div class="card-header"><strong>Ward / Bed Details</strong></div>
        <div class="card-body">

            <div class="row">

                <div class="col-md-4">
                    <label>Ward</label>
                    <p>{{ $ipd->ward->ward_name ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <label>Room</label>
                    <p>{{ $ipd->room->room_number ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <label>Bed</label>
                    <p>{{ $ipd->bed->bed_code ?? '-' }}</p>
                </div>

            </div>

        </div>
    </div>

    <!-- ================= PAYMENT ================= -->
    <div class="card mb-4">
        <div class="card-header"><strong>Payment Details</strong></div>
        <div class="card-body">

            <div class="row">

                <div class="col-md-6">
                    <label>Advance Amount</label>
                    <p>{{ $ipd->advance_amount }}</p>
                </div>

                <div class="col-md-6">
                    <label>Payment Mode</label>
                    <p>Cash</p> 
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
                    <label>Insured</label>
                    <p>{{ $ipd->insurance_flag ? 'Yes' : 'No' }}</p>
                </div>

                <div class="col-md-4">
                    <label>Provider</label>
                    <p>{{ $ipd->insurance_provider ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <label>Policy</label>
                    <p>{{ $ipd->policy_number ?? '-' }}</p>
                </div>

            </div>

        </div>
    </div>

    <!-- ================= NOTES ================= -->
    <div class="card mb-4">
        <div class="card-header"><strong>Remarks</strong></div>
        <div class="card-body">
            <p>{{ $ipd->notes ?? '-' }}</p>
        </div>
    </div>

</div>

@endsection