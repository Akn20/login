@extends('layouts.admin')

@section('content')

<div class="container-fluid">

<div class="page-header mb-4">

        <h3 class="fw-bold">
            Prescription Summary Report
        </h3>

    </div>

    <div class="row">

        <div class="col-md-4 mb-4">

            <div class="card p-4 text-center">

                <h5>Total Prescriptions</h5>

                <h2 class="text-primary">
                    {{ $totalPrescriptions }}
                </h2>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card p-4 text-center">

                <h5>Today's Prescriptions</h5>

                <h2 class="text-success">
                    {{ $todayPrescriptions }}
                </h2>

            </div>

        </div>

    </div>

    {{-- FILTER --}}
    <div class="card mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-3">

                        <label>Doctor</label>

                        <select
                            name="doctor_id"
                            class="form-control">

                            <option value="">
                                All Doctors
                            </option>

                            @foreach($doctors as $doctor)

                                <option
                                    value="{{ $doctor->id }}"
                                    {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>

                                    {{ $doctor->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3">

                        <label>From Date</label>

                        <input
                            type="date"
                            name="from_date"
                            value="{{ request('from_date') }}"
                            class="form-control">

                    </div>

                    <div class="col-md-3">

                        <label>To Date</label>

                        <input
                            type="date"
                            name="to_date"
                            value="{{ request('to_date') }}"
                            class="form-control">

                    </div>

                    <div class="col-md-3 mt-4">

                        <button class="btn btn-primary w-100">
                            Filter
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="card">

        <div class="card-header">

            <h4>Prescription Summary List</h4>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Diagnosis</th>
                        <th>Tests</th>
                        <th>Medicines</th>
                        <th>Date</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($consultations as $key => $consultation)

                        <tr>

                            <td>{{ $key + 1 }}</td>

                            <td>
                                {{ $consultation->patient->first_name ?? '' }}
                                {{ $consultation->patient->last_name ?? '' }}
                            </td>

                            <td>
                                {{ optional($consultation->doctor)->name }}
                            </td>

                            <td>
                                {{ optional(optional($consultation->doctor)->department)->department_name }}
                            </td>

                            <td>
                                {{ $consultation->diagnosis }}
                            </td>

                            <td>
                                {{ $consultation->tests }}
                            </td>
                            <td>

    @forelse($consultation->medicines as $medicine)

        <div class="mb-2 p-2 border rounded">

            <strong>
                {{ $medicine->medicine_name }}
            </strong>

            <br>

            Dosage:
            {{ $medicine->pivot->dosage }}

            <br>

            Frequency:
            {{ $medicine->pivot->frequency }}

            <br>

            Duration:
            {{ $medicine->pivot->duration }}

            <br>

            Instructions:
            {{ $medicine->pivot->instructions }}

        </div>

    @empty

        <span class="text-muted">
            No medicines prescribed
        </span>

    @endforelse

</td>

                            <td>
                                {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d M Y') }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center">
                                No prescription records found
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection