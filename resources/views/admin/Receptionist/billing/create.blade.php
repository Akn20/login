@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">Create Billing</h4>

        <a href="{{ route('admin.billing.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    {{-- Errors --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.billing.store') }}" method="POST" class="card shadow-sm">
        @csrf

        <div class="card-body">

            <!-- Hidden patient -->
            <input type="hidden" name="patient_id" id="patient_id">

            <div class="row g-3">

                <!-- Appointment Dropdown -->
                <div class="col-md-6">
                    <label>Patient</label>

                    <select name="appointment_id" id="appointment_id" class="form-control" required>
                        <option value="">Select Patient</option>

                        @foreach($appointments as $appt)
                            <option value="{{ $appt->id }}"
                                data-fee="{{ $appt->consultation_fee }}"
                                data-patient="{{ $appt->patient_id }}">

                                {{ $appt->patient->first_name }}
                                {{ $appt->patient->last_name }}
                                ({{ $appt->patient->patient_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Fee -->
                <div class="col-md-3">
                    <label>Consultation Fee</label>
                    <input type="number" name="amount" class="form-control">
                </div>

                <!-- Paid -->
                <div class="col-md-3">
                    <label>Amount Paid</label>
                    <input type="number" name="paid_amount" class="form-control">
                </div>

                <!-- Payment Mode -->
                <div class="col-md-3">
                    <label>Payment Mode</label>
                    <input type="text" value="CASH" class="form-control" readonly>
                </div>

            </div>

        </div>

        <div class="card-footer text-end">
            <button class="btn btn-success">Collect Payment</button>
        </div>

    </form>

</div>

<script>
document.getElementById('appointment_id').addEventListener('change', function () {

    let selected = this.options[this.selectedIndex];

    let fee = selected.getAttribute('data-fee');
    let patientId = selected.getAttribute('data-patient');

    if (fee) {
        document.querySelector('input[name="amount"]').value = fee;
        document.querySelector('input[name="paid_amount"]').value = fee;
        document.getElementById('patient_id').value = patientId;
    } else {
        document.querySelector('input[name="amount"]').value = '';
        document.querySelector('input[name="paid_amount"]').value = '';
        document.getElementById('patient_id').value = '';
    }
});
</script>

@endsection