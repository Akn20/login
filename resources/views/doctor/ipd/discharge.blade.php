@extends('layouts.admin')

@section('content')

<style>
.card-box {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
}

/* Hide buttons while printing */
.no-print {
    display: block;
}

@media print {

    /* Hide sidebar */
    .nxl-navigation,
    .nxl-sidebar,
    .sidebar,
    .main-sidebar,
    aside,
    nav,
    header,
    .top-header,
    .navbar,
    .header-wrapper,
    .page-header,
    .breadcrumb,
    .footer,
    .no-print {
        display: none !important;
    }

    /* Remove margins/padding */
    body,
    .main-content,
    .content-area,
    .container,
    .container-fluid {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }

    /* Full width print */
    .card-box {
        border: none !important;
        box-shadow: none !important;
        width: 100% !important;
    }

    /* Prevent hidden left spacing */
    .page-wrapper,
    .main-content,
    .content {
        margin-left: 0 !important;
    }
}
</style>

<div class="container mt-4">

    <div class="card-box">

        <div class="d-flex justify-content-between align-items-center mb-3 no-print">
            <h4>Discharge Summary</h4>

            <a href="{{ route('doctor.ipd.show', $ipd->id) }}" class="btn btn-secondary btn-sm">
                ← Back
            </a>
        </div>

        <div class="card-box mb-3">
            <h5>Patient Information</h5>

            <p><strong>Patient Name:</strong>
                {{ $ipd->patient->first_name ?? '' }}
                {{ $ipd->patient->last_name ?? '' }}
            </p>

            <p><strong>Admission Date:</strong>
                {{ $ipd->admission_date ?? 'N/A' }}
            </p>

            <p><strong>Status:</strong>
                @if($ipd->status == 'discharged')
                    <span class="badge bg-danger">Discharged</span>
                @else
                    <span class="badge bg-success">Active</span>
                @endif
            </p>
        </div>

        {{-- ===============================
             IF ALREADY DISCHARGED → VIEW MODE
        ================================ --}}
        @if($ipd->status == 'discharged' && $discharge)

            <div class="mb-3">
                <label><strong>Diagnosis</strong></label>
                <p>{{ $discharge->diagnosis }}</p>
            </div>

            <div class="mb-3">
                <label><strong>Treatment Given</strong></label>
                <p>{{ $discharge->treatment_given }}</p>
            </div>

            <div class="mb-3">
                <label><strong>Medication Advice</strong></label>
                <p>{{ $discharge->medication_advice }}</p>
            </div>

            <div class="mb-3">
                <label><strong>Follow-up Plan</strong></label>
                <p>{{ $discharge->follow_up }}</p>
            </div>

            <div class="mb-3">
                <label><strong>Doctor Name</strong></label>
                <p>{{ $discharge->doctor_name }}</p>
            </div>

            <div class="mb-3">
                <label><strong>Date</strong></label>
                <p>{{ $discharge->date }}</p>
            </div>

            <div class="text-end no-print">
                <button onclick="window.print()" class="btn btn-dark">
                    Print
                </button>
            </div>

        {{-- ===============================
             ACTIVE PATIENT → FORM MODE
        ================================ --}}
        @else

            <form method="POST" action="{{ route('doctor.ipd.dischargeSubmit', $ipd->id) }}">
                @csrf

                <div class="mb-3">
                    <label>Diagnosis</label>
                    <textarea name="diagnosis" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Treatment Given</label>
                    <textarea name="treatment_given" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Medication Advice</label>
                    <textarea name="medication_advice" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Follow-up Plan</label>
                    <textarea name="follow_up" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Doctor Name (Signature)</label>
                    <input type="text"
                           name="doctor_name"
                           class="form-control"
                           value="{{ auth()->user()->name ?? 'Doctor' }}">
                </div>

                <div class="mb-3">
                    <label>Date</label>
                    <input type="date"
                           name="date"
                           class="form-control"
                           value="{{ date('Y-m-d') }}">
                </div>

                <button type="submit"
                        class="btn btn-success"
                        onclick="return confirm('Are you sure you want to discharge this patient?')">
                    Submit & Discharge
                </button>
            </form>

        @endif

    </div>

</div>

@endsection