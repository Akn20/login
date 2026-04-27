@extends('layouts.admin')

@section('content')

<style>
.card-box {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
}
.nav-tabs .nav-link.active {
    background-color: #0d6efd;
    color: #fff;
}
</style>

<div class="container mt-4">

    <!-- ✅ Patient Info -->
    <div class="card-box mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Patient Details</h4>

            <a href="{{ route('doctor.ipd.index') }}" class="btn btn-secondary btn-sm">
                ← Back
            </a>
        </div>

        <p><strong>Name:</strong>
            {{ $ipd->patient ? $ipd->patient->first_name . ' ' . $ipd->patient->last_name : 'N/A' }}
        </p>

        <p><strong>Ward:</strong>
            {{ $ipd->ward->ward_name ?? 'N/A' }}
        </p>

        <p><strong>Room:</strong>
            {{ $ipd->bed->room_number ?? 'N/A' }}
        </p>
    </div>

    {{-- ADD THIS near top of blade file after patient details --}}
    @php
        $isDischarged = $ipd->status == 'discharged';
    @endphp

    <!-- Tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#notes">Notes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#treatment">Treatment</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#medications">Prescription</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#lab">Lab / Radiology</a>
        </li>
    </ul>

    <div class="tab-content mt-3">

        <!-- ✅ NOTES -->
        <div class="tab-pane fade show active" id="notes">
            <div class="card-box">

            @if(!$isDischarged)
            <form method="POST" action="{{ route('doctor.ipd.storeNote', $ipd->id) }}">
                @csrf
                <textarea name="notes" class="form-control mb-2" required></textarea>
                <button class="btn btn-success btn-sm">Save</button>
            </form>
            @else
            <div class="alert alert-secondary">
                Patient is discharged. Notes cannot be added.
            </div>
            @endif

                <hr>

                <h6>Previous Notes</h6>
                <ul>
                    @foreach($notes as $note)
                        <li>{{ $note->notes }}</li>
                    @endforeach
                </ul>

            </div>
        </div>

        <!-- ✅ TREATMENT -->
        <div class="tab-pane fade" id="treatment">
            <div class="card-box">

                @if(!$isDischarged)
                <form method="POST" action="{{ route('doctor.ipd.updateTreatment', $ipd->id) }}">
                    @csrf
                    <textarea name="treatment" class="form-control mb-2">{{ $treatment->treatment ?? '' }}</textarea>
                    <button class="btn btn-primary btn-sm">Update</button>
                </form>
                @else
                <div class="mb-2">
                    <textarea class="form-control" readonly>{{ $treatment->treatment ?? '' }}</textarea>
                </div>

                <div class="alert alert-secondary">
                    Patient is discharged. Treatment cannot be updated.
                </div>
                @endif

            </div>
        </div>

        <!-- ✅ PRESCRIPTION -->
        <div class="tab-pane fade" id="medications">
            <div class="card-box">

                @if(!$isDischarged)
                <form method="POST" action="{{ route('doctor.ipd.storePrescription', $ipd->id) }}">
                    @csrf


                    <select name="medicine_id[]" class="form-control mb-2" required>
                        <option value="">Select Medicine</option>

                        @foreach($medicines as $med)
                            <option value="{{ $med->id }}">
                                {{ $med->medicine_name }}
                            </option>
                        @endforeach
                    </select>

                    <input name="dosage[]" class="form-control mb-2" placeholder="Dosage">
                    <input name="frequency[]" class="form-control mb-2" placeholder="Frequency">
                    <input name="duration[]" class="form-control mb-2" placeholder="Duration">
                    <input name="instructions[]" class="form-control mb-2" placeholder="Instructions">

                    <button class="btn btn-success btn-sm mb-3">Add</button>
                </form>
                @else
                <div class="alert alert-secondary">
                    Patient is discharged. Prescription cannot be added.
                </div>
                @endif

                <table class="table table-bordered">
                    <tr>
                        <th>Medicine</th>
                        <th>Dosage</th>
                        <th>Frequency</th>
                        <th>Duration</th>
                    </tr>

                    @foreach($prescriptionItems as $item)
                    <tr>
                        <td>{{ $item->medicine_name }}</td>
                        <td>{{ $item->dosage }}</td>
                        <td>{{ $item->frequency }}</td>
                        <td>{{ $item->duration }}</td>
                    </tr>
                    @endforeach
                </table>

            </div>
        </div>

        <!-- ✅ LAB + RADIOLOGY -->
        <div class="tab-pane fade" id="lab">
            <div class="card-box">

            @if(!$isDischarged)
                <form method="POST" action="{{ route('doctor.ipd.storeLabRadiology', $ipd->id) }}">
                    @csrf

                    <input type="hidden" name="patient_id" value="{{ $ipd->patient_id }}">

                    <!-- ✅ TYPE SELECT -->
                    <select name="type" id="testType" class="form-control mb-2" required onchange="toggleFields()">
                        <option value="">Select Type</option>
                        <option value="lab">Lab</option>
                        <option value="radiology">Radiology</option>
                    </select>

                    <!-- ================= LAB FIELDS ================= -->
                    <div id="labFields" style="display:none;">

                        <select name="test_name" class="form-control mb-2">
                            <option value="">Select Lab Test</option>

                            @foreach($availableLabTests as $lab)
                                <option value="{{ $lab->test_name }}">
                                    {{ $lab->test_name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="lab_priority" class="form-control mb-2">
                            <option value="routine">Routine</option>
                            <option value="urgent">Urgent</option>
                            <option value="stat">STAT</option>
                        </select>

                    </div>

                    <!-- ================= RADIOLOGY FIELDS ================= -->
                    <div id="radiologyFields" style="display:none;">

                        <select name="scan_type_id" class="form-control mb-2">
                            <option value="">Select Scan Type</option>
                            @foreach($scanTypes as $scan)
                                <option value="{{ $scan->id }}">
                                    {{ $scan->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" name="body_part" class="form-control mb-2" placeholder="Body Part">

                        <textarea name="reason" class="form-control mb-2" placeholder="Reason"></textarea>

                        <select name="scan_priority" class="form-control mb-2">
                            <option value="Normal">Normal</option>
                            <option value="Urgent">Urgent</option>
                        </select>

                    </div>

                    <button class="btn btn-success btn-sm">Submit</button>
                </form>

                @else
                <div class="alert alert-secondary">
                    Patient is discharged. Lab and Radiology requests cannot be added.
                </div>
                @endif

                <hr>

                <!-- SHOW LAB TESTS -->
                <h6>Lab Tests</h6>
                <ul>
                    @forelse($labTests as $test)
                        <li>{{ $test->test_name }} ({{ $test->status }})</li>
                    @empty
                        <li>No lab test requests found</li>
                    @endforelse
                </ul>

                <h6>Radiology</h6>
                <ul>
                    @forelse($scans as $scan)
                        <li>
                            {{ $scan->name }}
                            - {{ $scan->body_part ?? 'N/A' }}
                            ({{ $scan->status }})
                        </li>
                    @empty
                        <li>No radiology requests found</li>
                    @endforelse
                </ul>

            </div>
        </div>

        <!-- ✅ SCRIPT -->
        <script>
        function toggleFields() {
            let type = document.getElementById('testType').value;

            document.getElementById('labFields').style.display =
                (type === 'lab') ? 'block' : 'none';

            document.getElementById('radiologyFields').style.display =
                (type === 'radiology') ? 'block' : 'none';
        }
        </script>

    </div>

    <!-- ✅ DISCHARGE -->
    <div class="mt-3 text-end">

        @if($ipd->status == 'discharged')

            <a href="{{ route('doctor.ipd.discharge', $ipd->id) }}"
            class="btn btn-primary">
                View Discharge Summary
            </a>

        @else

            <a href="{{ route('doctor.ipd.discharge', $ipd->id) }}"
            class="btn btn-danger">
                Discharge Patient
            </a>

        @endif

    </div>

</div>

@endsection