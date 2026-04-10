@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>IPD Admission</h4>
        <a href="{{ route('admin.receptionist.ipd.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <form action="{{ route('admin.receptionist.ipd.store') }}" method="POST">
        @csrf

        <!-- ================= PATIENT SECTION ================= -->
        <div class="card mb-4">
            <div class="card-header"><strong>Patient Details</strong></div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-4">
                        <label>Search Patient</label>
                        <input type="text" class="form-control" placeholder="UHID / Mobile / Name">
                    </div>

                   <div class="col-md-4">
    <label>Select Patient</label>
    <select name="patient_id" id="patient_id" class="form-control" required>
    <option value="">Select Patient</option>

    @foreach($patients as $patient)
        <option value="{{ $patient->id }}">
            {{ $patient->first_name }} {{ $patient->last_name }}
        </option>
    @endforeach

</select>
</div>
                    <div class="col-md-2">
                        <label>Age</label>
                        <input type="text" id="age" class="form-control" readonly>
                    </div>

                    <div class="col-md-2">
                        <label>Gender</label>
                        <input type="text" id="gender" class="form-control" readonly>
                    </div>
                </div>

            </div>
        </div>

        <!-- ================= ADMISSION DETAILS ================= -->
        <div class="card mb-4">
            <div class="card-header"><strong>Admission Details</strong></div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-3">
                        <label>Admission Date</label>
                        <input type="datetime-local" name="admission_date" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>Department</label>
                        <select name="department_id" class="form-control" required>
    <option value="">Select</option>
    @foreach($departments as $dept)
        <option value="{{ $dept->id }}"> {{ $dept->department_name }}</option>
    @endforeach
</select>
                    </div>

                    <div class="col-md-3">
                        <label>Doctor</label>
                        <select name="doctor_id" class="form-control" required>
    <option value="">Select</option>
    @foreach($doctors as $doc)
        <option value="{{ $doc->id }}">{{ $doc->name }}</option>
    @endforeach
</select>
                    </div>

                    <div class="col-md-3">
                        <label>Admission Type</label>
                        <select name="admission_type" class="form-control">
                            <option value="planned">Planned</option>
                            <option value="emergency">Emergency</option>
                        </select>
                    </div>

                </div>

            </div>
        </div>

        <!-- ================= BED SECTION ================= -->
        <div class="card mb-4">
            <div class="card-header"><strong>Ward / Bed Allocation</strong></div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">
                        <label>Ward</label>
                       <select name="ward_id" class="form-control">
    <option value="">Select Ward</option>

    @foreach($wards as $ward)
        <option value="{{ $ward->id }}">
            {{ $ward->ward_name }}
        </option>
    @endforeach

</select>
                    </div>

                    <div class="col-md-4">
                        <label>Room</label>
                       <select name="room_id" class="form-control">
    <option value="">Select Room</option>

    @foreach($rooms as $room)
        <option value="{{ $room->id }}">
            {{ $room->room_number }}
        </option>
    @endforeach

</select>
                    </div>

                    <div class="col-md-4">
                        <label>Bed</label>
                        <select name="bed_id" class="form-control" required>
    <option value="">Select Bed</option>
    @foreach($beds as $bed)
        <option value="{{ $bed->id }}">
            {{ $bed->bed_code }}
        </option>
    @endforeach
</select>
                    </div>

                </div>

            </div>
        </div>

        <!-- ================= PAYMENT SECTION ================= -->
        <div class="card mb-4">
            <div class="card-header"><strong>Advance Payment</strong></div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">
                        <label>Advance Amount</label>
                        <input type="number" name="advance_amount" class="form-control" placeholder="Enter amount">
                    </div>

                    <div class="col-md-6">
                        <label>Payment Mode</label>
                        <select name="payment_mode" class="form-control">
                            <option value="">Select</option>
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="upi">UPI</option>
                        </select>
                    </div>

                </div>

            </div>
        </div>

        <!-- ================= INSURANCE ================= -->
        <div class="card mb-4">
            <div class="card-header"><strong>Insurance Details</strong></div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">
                        <label>Insured?</label>
                        <select name="insurance_flag" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Provider</label>
                        <input type="text" name="insurance_provider" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label>Policy Number</label>
                        <input type="text" name="policy_number" class="form-control">
                    </div>

                </div>

            </div>
        </div>

        <!-- ================= NOTES ================= -->
        <div class="card mb-4">
            <div class="card-header"><strong>Remarks</strong></div>
            <div class="card-body">
                <textarea name="notes" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <!-- ================= BUTTON ================= -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Admit Patient</button>
        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('patient_id').addEventListener('change', function () {

        let patientId = this.value;

        if (patientId) {
            fetch('/admin/receptionist/get-patient/' + patientId)
                .then(response => response.json())
                .then(data => {

                    document.getElementById('gender').value = data.gender ?? '';

                    if (data.date_of_birth) {
                        let dob = new Date(data.date_of_birth);
                        let today = new Date();

                        let age = today.getFullYear() - dob.getFullYear();
                        let m = today.getMonth() - dob.getMonth();

                        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                            age--;
                        }

                        document.getElementById('age').value = age;
                    } else {
                        document.getElementById('age').value = '';
                    }

                });
        }

    });

});
</script>
@endsection


