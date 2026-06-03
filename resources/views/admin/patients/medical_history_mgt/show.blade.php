@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4">Patient Medical History</h3>

    {{-- Patient Information --}}
    <div class="card mb-3">
      <div class="card-header">
    <h5 class="mb-0">Patient Information</h5>
</div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <strong>UHID:</strong><br>
                    {{ $patient->patient_code }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Patient Name:</strong><br>
                    {{ $patient->first_name }} {{ $patient->last_name }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Gender:</strong><br>
                    {{ $patient->gender }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Date of Birth:</strong><br>
                    {{ $patient->date_of_birth }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Mobile:</strong><br>
                    {{ $patient->mobile }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Blood Group:</strong><br>
                    {{ $patient->blood_group }}
                </div>

            </div>

        </div>
    </div>
{{-- OPD Visit History --}}
<div class="card mb-3">

    <div class="card-header">
        <h5 class="mb-0">OPD Visit History</h5>
    </div>

    <div class="card-body">


    <div class="table-responsive">
        <table class="table table-bordered table-hover">

            <thead>
                <tr>
                    <th>Visit Date</th>
                    <th>Department</th>
                    <th>Doctor</th>
                    <th>Status</th>
                    <th>Consultation Fee</th>
                </tr>
            </thead>

            <tbody>

            

            @if($opdVisits->count())

                @foreach($opdVisits as $visit)

                    <tr>
                        <td>{{ $visit->appointment_date }}</td>
                        <td>{{ $visit->department->department_name ?? '-' }}</td>
                        <td>{{ $visit->doctor->name ?? '-' }}</td>
                        <td>{{ $visit->appointment_status }}</td>
                        <td>₹ {{ number_format($visit->consultation_fee, 2) }}</td>
                    </tr>

                @endforeach

            @else

                <tr>
                    <td colspan="5" class="text-center">
                        No visit history found
                    </td>
                </tr>

            @endif

            </tbody>

        </table>
    </div>
    </div>
</div>
   {{-- IPD Admission History --}}
<div class="card mb-3">

    <div class="card-header">
    <h5 class="mb-0">IPD Admission History</h5>
</div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>
                    <tr>
    <th>Admission ID</th>
    <th>Admission Date</th>
    <th>Admission Type</th>
    <th>Department</th>
    <th>Doctor</th>
    <th>Ward / Bed</th>
    <th>Status</th>
    <th>Notes</th>
</tr>
                </thead>

                <tbody>

                @if($ipdAdmissions->count())

                    @foreach($ipdAdmissions as $admission)

                        <tr>

    <td>{{ $admission->admission_id ?? '-' }}</td>

    <td>{{ $admission->admission_date ?? '-' }}</td>

    <td>{{ ucfirst($admission->admission_type) ?? '-' }}</td>

    <td>{{ $admission->department->department_name ?? '-' }}</td>

    <td>{{ $admission->doctor->name ?? '-' }}</td>

    <td>
        {{ $admission->ward->ward_name ?? '-' }}
        /
        {{ $admission->bed->bed_number ?? '-' }}
    </td>

    <td>{{ $admission->status ?? '-' }}</td>

    <td>{{ $admission->notes ?? '-' }}</td>

</tr>
                    @endforeach

                @else

                    <tr>
                        <td colspan="8" class="text-center">
                            No IPD admission history found
                        </td>
                    </tr>

                @endif

                </tbody>

            </table>

        </div>

    </div>

</div>
{{-- Diagnosis History --}}
<div class="card mb-3">

    <div class="card-header">
    <h5 class="mb-0">Diagnosis History</h5>
</div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>
    <tr>
        <th>Diagnosis</th>
        <th>Symptoms</th>
        <th>Tests Ordered</th>
        <th>Doctor</th>
        <th>Consultation Date</th>
    </tr>
</thead>

                <tbody>

                    @if($consultations->count())

                        @foreach($consultations as $consultation)

                          <tr>

    <td>
        {{ $consultation->diagnosis ?? '-' }}
    </td>

    <td>
        {{ $consultation->symptoms ?? '-' }}
    </td>

    <td>
        {{ $consultation->tests ?? '-' }}
    </td>

    <td>
        {{ $consultation->doctor->name ?? '-' }}
    </td>

    <td>
        {{ $consultation->consultation_date ?? '-' }}
    </td>

</tr>

                        @endforeach

                    @else

                        <tr>
                            <td colspan="5" class="text-center">
                                No diagnosis history found
                            </td>
                        </tr>

                    @endif

                </tbody>

            </table>

        </div>

    </div>

</div>
    {{-- Medication History --}}
<div class="card mb-3">

    <div class="card-header">
    <h5 class="mb-0">Medication History</h5>
</div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Dosage</th>
                        <th>Frequency</th>
                        <th>Duration</th>
                        <th>Instructions</th>
                        <th>Doctor</th>
                    </tr>
                </thead>

                <tbody>

@if($consultationMedicines->count())

    @foreach($consultationMedicines as $medicine)

        <tr>

            <td>
                {{ $medicine->medicine->medicine_name ?? '-' }}
            </td>

            <td>
                {{ $medicine->dosage ?? '-' }}
            </td>

            <td>
                {{ $medicine->frequency ?? '-' }}
            </td>

            <td>
                {{ $medicine->duration ?? '-' }}
            </td>

            <td>
                {{ $medicine->instructions ?? '-' }}
            </td>

            <td>
                {{ $medicine->consultation->doctor->name ?? '-' }}
            </td>

        </tr>

    @endforeach

@else

    <tr>
        <td colspan="6" class="text-center">
            No medication history found
        </td>
    </tr>

@endif

</tbody>

            </table>

        </div>

    </div>

</div>

   {{-- Allergies & Medical Flags --}}
<div class="card mb-3">

    <div class="card-header">
    <h5 class="mb-0">Allergies & Medical Flags</h5>
</div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>
                    <tr>
                        <th>Flag Type</th>
                        <th>Title</th>
                        <th>Description</th>
                       <th>Severity</th>
<th>Recorded Date</th>
                    </tr>
                </thead>

                <tbody>

                    @if($allergies->count())

                        @foreach($allergies as $allergy)

                            <tr>

    <td>
        {{ $allergy->type ?? '-' }}
    </td>

    <td>
        {{ $allergy->title ?? '-' }}
    </td>

    <td>
        {{ $allergy->description ?? '-' }}
    </td>

    <td>
        {{ $allergy->severity ?? '-' }}
    </td>

    <td>
        {{ $allergy->created_at ? $allergy->created_at->format('Y-m-d') : '-' }}
    </td>

</tr>
                        @endforeach

                    @else

                        <tr>
                            <td colspan="5" class="text-center">
                                No allergy history found
                            </td>
                        </tr>

                    @endif

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- Chronic Condition History --}}
<div class="card mb-3">

    <div class="card-header">
    <h5 class="mb-0">Chronic Condition History</h5>
</div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>
                    <tr>
                        <th>Condition</th>
                        <th>Description</th>
                        <th>Severity</th>
<th>Recorded Date</th>
                    </tr>
                </thead>

                <tbody>

                    @if($chronicConditions->count())

                        @foreach($chronicConditions as $condition)

                            <tr>

                                <td>
                                    {{ $condition->title ?? '-' }}
                                </td>

                                <td>
                                    {{ $condition->description ?? '-' }}
                                </td>

                               <td>
    {{ $condition->severity ?? '-' }}
</td>

<td>
    {{ $condition->created_at ? $condition->created_at->format('Y-m-d') : '-' }}
</td>

                            </tr>

                        @endforeach

                    @else

                        <tr>
                            <td colspan="4" class="text-center">
                                No chronic condition history found
                            </td>
                        </tr>

                    @endif

                </tbody>

            </table>

        </div>

    </div>

</div>
<!-- Surgery History -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Surgery History</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
        <tr>
    <th>Surgery Type</th>
    <th>Surgery Date</th>
    <th>Surgery Time</th>
    <th>Surgeon</th>
    <th>Assistant Doctor</th>
    <th>Anesthetist</th>
    <th>Priority</th>
    <th>Notes</th>
</tr>
                </thead>

                <tbody>
                    @forelse($surgeries as $surgery)
                       <tr>

    <td>{{ $surgery->surgery_type ?? '-' }}</td>

    <td>{{ $surgery->surgery_date ?? '-' }}</td>

    <td>{{ $surgery->surgery_time ?? '-' }}</td>

   <td>{{ $surgery->surgeon->name ?? '-' }}</td>

<td>{{ $surgery->assistantDoctor->name ?? '-' }}</td>

<td>{{ $surgery->anesthetist->name ?? '-' }}</td>

    <td>{{ $surgery->priority ?? '-' }}</td>

    <td>{{ $surgery->notes ?? '-' }}</td>

</tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                No surgery history found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection