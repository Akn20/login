@extends('layouts.admin')

@section('content')

<style>
.card-box {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
}
@media print {
    .no-print {
        display: none;
    }
}
</style>

<div class="container mt-4">

    <div class="card-box">

        <h4>Discharge Summary</c></h4>

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

                <button type="submit" class="btn btn-success">
                    Submit & Discharge
                </button>
            </form>

        @endif

    </div>

</div>

@endsection