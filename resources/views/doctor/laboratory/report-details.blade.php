@extends('layouts.admin')

@section('content')
<style>

@media print {

    body {

        background: white !important;
        font-size: 12px !important;
        color: #000 !important;

    }

    /* Hide UI */

    .nxl-navigation,
    .nxl-header,
    .btn,
    .no-print,
    nav,
    aside,
    footer {

        display: none !important;

    }

    /* Full page */

    .container-fluid,
    .main-content,
    .content-area {

        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;

    }

    /* Cards */

    .card {

        border: 1px solid #ddd !important;
        box-shadow: none !important;
        margin-bottom: 12px !important;
        border-radius: 6px !important;
        page-break-inside: avoid;

    }

    .card-body {

        padding: 12px !important;

    }

    /* Headings */

    h1,h2,h3,h4,h5 {

        margin-bottom: 10px !important;

    }

    /* Remove huge spacing */

    .row {

        margin-bottom: 8px !important;

    }

    /* Tables */

    table {

        width: 100% !important;
        border-collapse: collapse !important;

    }

    table th,
    table td {

        border: 1px solid #ccc !important;
        padding: 8px !important;
        font-size: 12px !important;

    }

    /* Prevent weird page breaks */

    .avoid-break {

        page-break-inside: avoid;

    }

    /* Reduce empty height */

    .card,
    .info-box {

        min-height: auto !important;

    }

}

</style>

<div class="container-fluid">

{{-- SUCCESS MESSAGE --}}
@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show mb-4">

        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif



{{-- ERROR MESSAGE --}}
@if(session('error'))

    <div class="alert alert-danger alert-dismissible fade show mb-4">

        {{ session('error') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif

    @php

        $sample = $report->sample;

        $labRequest = optional($sample)->labRequest;

        $patient = optional($labRequest)->patient;

    @endphp


    {{-- PAGE HEADER --}}
    <div class="card mb-4">

        <div class="card-body d-flex justify-content-between align-items-center">

            <div>

                <h3 class="mb-1">
                    Laboratory Report Details
                </h3>

                <p class="text-muted mb-0">
                    Detailed laboratory report information and clinical notes
                </p>

            </div>


            <div class="d-flex gap-2">

    <a href="{{ route('doctor.laboratory.reports') }}"
       class="btn btn-outline-secondary">

        <i class="feather-arrow-left me-1"></i>
        Back

    </a>


    @if($patient && $labRequest)

        <a href="{{ route(
            'doctor.laboratory.compare',
            [
                'patientId' => $patient->id,
                'testName' => $labRequest->test_name
            ]
        ) }}"
           class="btn btn-info">

            <i class="feather-bar-chart-2 me-1"></i>
            Compare Reports

        </a>

    @endif


    {{-- DOWNLOAD --}}
    <a href="{{ route('doctor.laboratory.report.pdf', ['id' => $report->id]) }}"
       class="btn btn-danger no-print">

        <i class="feather-download me-1"></i>

        Download Report

    </a>

</div>

        </div>

    </div>



    {{-- PATIENT + REPORT SUMMARY --}}
    <div class="row mb-4">

        {{-- PATIENT --}}
        <div class="col-md-3">

            <div class="card h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Patient Name
                    </h6>

                    <h5 class="fw-bold">

                        {{ $patient->first_name ?? 'N/A' }}
                        {{ $patient->last_name ?? '' }}

                    </h5>

                </div>

            </div>

        </div>



        {{-- TEST --}}
        <div class="col-md-3">

            <div class="card h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Test Name
                    </h6>

                    <h5 class="fw-bold">

                        {{ $labRequest->test_name ?? 'N/A' }}

                    </h5>

                </div>

            </div>

        </div>



        {{-- SAMPLE --}}
        <div class="col-md-3">

            <div class="card h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Sample ID
                    </h6>

                    <h5 class="fw-bold">

                        {{ $sample->barcode ?? '-' }}

                    </h5>

                </div>

            </div>

        </div>



        {{-- STATUS --}}
        <div class="col-md-3">

            <div class="card h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Status
                    </h6>

                    @if($report->status == 'Completed')

                        <span class="badge bg-success fs-6">

                            Completed

                        </span>

                    @elseif($report->status == 'Pending')

                        <span class="badge bg-warning fs-6">

                            Pending

                        </span>

                    @else

                        <span class="badge bg-info fs-6">

                            {{ $report->status }}

                        </span>

                    @endif

                </div>

            </div>

        </div>

    </div>



    {{-- REPORT INFORMATION --}}
    <div class="card mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Report Information
            </h5>

        </div>


        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="fw-bold">
                        Report Date
                    </label>

                    <p class="mb-0">

                        {{ $report->created_at->format('d M Y h:i A') }}

                    </p>

                </div>



                <div class="col-md-6 mb-3">

                    <label class="fw-bold">
                        Verification Status
                    </label>

                    <p class="mb-0">

                        @if($report->verification_status == 'Finalized')

                            <span class="badge bg-success">

                                Finalized

                            </span>

                        @else

                            <span class="badge bg-warning">

                                Pending

                            </span>

                        @endif

                    </p>

                </div>



                <div class="col-md-6 mb-3">

                    <label class="fw-bold">
                        Priority
                    </label>

                    <p class="mb-0">

                        {{ $labRequest->priority ?? 'Normal' }}

                    </p>

                </div>



                <div class="col-md-6 mb-3">

                    <label class="fw-bold">
                        Requested Date
                    </label>

                    <p class="mb-0">

                        {{ optional($labRequest?->created_at)->format('d M Y h:i A') }}

                    </p>

                </div>

            </div>

        </div>

    </div>



    {{-- RESULT DATA --}}
    <div class="card mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Laboratory Result Values
            </h5>

        </div>


        <div class="card-body">

            @if(is_array($report->result_data) && count($report->result_data) > 0)

                <div class="table-responsive">

                    <table class="table table-bordered align-middle">

                        <thead class="table-light">

                            <tr>

                                <th width="40%">
                                    Parameter
                                </th>

                                <th width="60%">
                                    Result Value
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($report->result_data as $key => $value)

                                @if($key != 'attachments')

                                    <tr>

                                        <td class="fw-bold">

                                            {{ ucfirst(str_replace('_', ' ', $key)) }}

                                        </td>


                                        <td>

                                            @if(is_array($value))

                                                {{ json_encode($value) }}

                                            @else

                                                {{ $value }}

                                            @endif

                                        </td>

                                    </tr>

                                @endif

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="alert alert-warning mb-0">

                    No result data available

                </div>

            @endif

        </div>

    </div>



    {{-- ATTACHMENTS --}}
    <div class="card mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Attachments
            </h5>

        </div>


        <div class="card-body">

            @if(
                isset($report->result_data['attachments']) &&
                is_array($report->result_data['attachments']) &&
                count($report->result_data['attachments']) > 0
            )

                <div class="row">

                    @foreach($report->result_data['attachments'] as $file)

                        <div class="col-md-4 mb-3">

                            <div class="border rounded p-3">

                                <div class="d-flex justify-content-between align-items-center">

                                    <div>

                                        <i class="feather-file-text text-primary"></i>

                                        <span class="ms-2">

                                            Attachment

                                        </span>

                                    </div>


                                    <a href="{{ asset('storage/' . $file) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-primary">

                                        View

                                    </a>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="alert alert-secondary mb-0">

                    No attachments uploaded

                </div>

            @endif

        </div>

    </div>



    {{-- CLINICAL NOTES FORM --}}
    <div class="card mb-4 no-print">

        <div class="card-header">

            <h5 class="mb-0">
                Add Clinical Notes
            </h5>

        </div>


        <div class="card-body">

            <form action="{{ route('doctor.laboratory.clinical-notes.store') }}"
                  method="POST">

                @csrf


                <input type="hidden"
                       name="patient_id"
                       value="{{ $patient->id ?? '' }}">


                <input type="hidden"
                       name="report_id"
                       value="{{ $report->id }}">



                {{-- OBSERVATION --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">

                        Clinical Observation

                    </label>

                    <textarea name="clinical_observation"
                              class="form-control"
                              rows="3"
                              placeholder="Enter clinical observation"></textarea>

                </div>



                {{-- DIAGNOSIS --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">

                        Diagnosis

                    </label>

                    <textarea name="diagnosis"
                              class="form-control"
                              rows="3"
                              placeholder="Enter diagnosis"></textarea>

                </div>



                {{-- FOLLOW UP --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">

                        Follow-up Advice

                    </label>

                    <textarea name="follow_up_advice"
                              class="form-control"
                              rows="3"
                              placeholder="Enter follow-up advice"></textarea>

                </div>



                {{-- BUTTON --}}
                <button class="btn btn-primary">

                    <i class="feather-save me-1"></i>
                    Save Clinical Notes

                </button>

            </form>

        </div>

    </div>



    {{-- PREVIOUS NOTES --}}
    <div class="card">

        <div class="card-header">

            <h5 class="mb-0">
                Previous Clinical Notes
            </h5>

        </div>


        <div class="card-body">

            @forelse($report->clinicalNotes as $note)

                <div class="border rounded p-3 mb-3">

                    <div class="d-flex justify-content-between align-items-center mb-2">

                        <h6 class="mb-0">

                            Clinical Note

                        </h6>

                        <small class="text-muted">

                            {{ $note->created_at->format('d M Y h:i A') }}

                        </small>

                    </div>



                    {{-- OBSERVATION --}}
                    <div class="mb-3">

                        <label class="fw-bold">
                            Observation
                        </label>

                        <p class="mb-0">

                            {{ $note->clinical_observation ?? '-' }}

                        </p>

                    </div>



                    {{-- DIAGNOSIS --}}
                    <div class="mb-3">

                        <label class="fw-bold">
                            Diagnosis
                        </label>

                        <p class="mb-0">

                            {{ $note->diagnosis ?? '-' }}

                        </p>

                    </div>



                    {{-- FOLLOW UP --}}
                    <div>

                        <label class="fw-bold">
                            Follow-up Advice
                        </label>

                        <p class="mb-0">

                            {{ $note->follow_up_advice ?? '-' }}

                        </p>

                    </div>

                </div>

            @empty

                <div class="alert alert-secondary mb-0">

                    No clinical notes available

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection