@extends('layouts.admin')

@section('page-title', 'Certificate Details')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between align-items-center">

    <div>

        <h5 class="mb-1">
            Medical Certificate Details
        </h5>

    </div>

    <div class="d-flex gap-2">

    {{-- BACK --}}
    <a href="{{ route('doctor.medical-certification.index') }}"
       class="btn btn-secondary btn-sm">

        <i class="feather-arrow-left me-1"></i>

        Back

    </a>

        {{-- DOWNLOAD --}}
        <a href="{{ route(
                'doctor.medical-certification.pdf',
                $record->id
            ) }}"
           class="btn btn-danger btn-sm">

            <i class="feather-download me-1"></i>

            Download PDF

        </a>


        {{-- PRINT --}}
        <a href="{{ route(
                'doctor.medical-certification.print',
                $record->id
            ) }}"
           target="_blank"
           class="btn btn-dark btn-sm">

            <i class="feather-printer me-1"></i>

            Print

        </a>

    </div>

</div>



<div class="card">

<div class="card-body">

<div class="row">

    {{-- CERTIFICATE NUMBER --}}
    <div class="col-md-4 mb-4">

        <label class="fw-bold text-muted">
            Certificate Number
        </label>

        <div>
            {{ $record->certificate_number }}
        </div>

    </div>


    {{-- EMPLOYEE --}}
    <div class="col-md-4 mb-4">

        <label class="fw-bold text-muted">
            Employee Name
        </label>

        <div>
            {{ $record->employee_name }}
        </div>

    </div>


    {{-- STATUS --}}
    <div class="col-md-4 mb-4">

        <label class="fw-bold text-muted">
            Status
        </label>

        <div>

            @if($record->status == 'Signed')

                <span class="badge bg-success">
                    Signed
                </span>

            @elseif($record->status == 'Expired')

                <span class="badge bg-dark">
                    Expired
                </span>

            @elseif($record->status == 'Cancelled')

                <span class="badge bg-danger">
                    Cancelled
                </span>

            @else

                <span class="badge bg-warning">
                    Draft
                </span>

            @endif

        </div>

    </div>


    {{-- DEPARTMENT --}}
    <div class="col-md-4 mb-4">

        <label class="fw-bold text-muted">
            Department
        </label>

        <div>
            {{ $record->department }}
        </div>

    </div>


    {{-- DESIGNATION --}}
    <div class="col-md-4 mb-4">

        <label class="fw-bold text-muted">
            Designation
        </label>

        <div>
            {{ $record->designation }}
        </div>

    </div>


    {{-- CERTIFICATE TYPE --}}
    <div class="col-md-4 mb-4">

        <label class="fw-bold text-muted">
            Certificate Type
        </label>

        <div>
            {{ $record->certificate_type }}
        </div>

    </div>


    {{-- ISSUE DATE --}}
    <div class="col-md-4 mb-4">

        <label class="fw-bold text-muted">
            Issue Date
        </label>

        <div>
            {{ $record->issue_date }}
        </div>

    </div>


    {{-- VALID FROM --}}
    <div class="col-md-4 mb-4">

        <label class="fw-bold text-muted">
            Valid From
        </label>

        <div>
            {{ $record->valid_from }}
        </div>

    </div>


    {{-- VALID UNTIL --}}
    <div class="col-md-4 mb-4">

        <label class="fw-bold text-muted">
            Valid Until
        </label>

        <div>
            {{ $record->valid_until }}
        </div>

    </div>


    {{-- DOCTOR --}}
    <div class="col-md-4 mb-4">

        <label class="fw-bold text-muted">
            Doctor Name
        </label>

        <div>
            {{ $record->doctor_name }}
        </div>

    </div>


    {{-- REGISTRATION --}}
    <div class="col-md-4 mb-4">

        <label class="fw-bold text-muted">
            Registration Number
        </label>

        <div>
            {{ $record->registration_number }}
        </div>

    </div>


    {{-- HOSPITAL --}}
    <div class="col-md-4 mb-4">

        <label class="fw-bold text-muted">
            Hospital Name
        </label>

        <div>
            {{ $record->hospital_name }}
        </div>

    </div>


    {{-- SIGNED STATUS --}}
    <div class="col-md-4 mb-4">

        <label class="fw-bold text-muted">
            Digitally Signed
        </label>

        <div>

            @if($record->signature_status)

                <span class="text-success fw-bold">

                    Yes

                </span>

            @else

                <span class="text-danger fw-bold">

                    No

                </span>

            @endif

        </div>

    </div>


    {{-- SIGNED BY --}}
    <div class="col-md-4 mb-4">

        <label class="fw-bold text-muted">
            Signed By
        </label>

        <div>
            {{ $record->signed_by ?? '-' }}
        </div>

    </div>


    {{-- SIGNED AT --}}
    <div class="col-md-4 mb-4">

        <label class="fw-bold text-muted">
            Signed At
        </label>

        <div>
            {{ $record->signed_at ?? '-' }}
        </div>

    </div>


    {{-- DIAGNOSIS --}}
    <div class="col-md-12 mb-4">

        <label class="fw-bold text-muted">
            Diagnosis / Reason
        </label>

        <div class="border rounded p-3 bg-light">

            {{ $record->diagnosis_reason }}

        </div>

    </div>


    {{-- REMARKS --}}
    <div class="col-md-12 mb-4">

        <label class="fw-bold text-muted">
            Medical Remarks
        </label>

        <div class="border rounded p-3 bg-light">

            {{ $record->medical_remarks }}

        </div>

    </div>


    {{-- AUDIT LOG --}}
    <div class="col-md-12">

        <label class="fw-bold text-muted">
            Audit Log
        </label>

        <div class="border rounded p-3 bg-light">

            {!! nl2br($record->action_history ?? '-') !!}

        </div>

    </div>

</div>

</div>

</div>

@endsection