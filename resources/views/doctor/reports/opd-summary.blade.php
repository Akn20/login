@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="page-header mb-4">

        <h3 class="fw-bold">
            OPD Case Summary Report
        </h3>

    </div>

    {{-- DASHBOARD CARDS --}}
    <div class="row">

        <div class="col-md-3 mb-4">

            <div class="card p-4 text-center">

                <h5>Total OPD Cases</h5>

                <h2 class="text-primary">
                    {{ $totalOpdCases }}
                </h2>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card p-4 text-center">

                <h5>Today's OPD</h5>

                <h2 class="text-success">
                    {{ $todayOpdCases }}
                </h2>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card p-4 text-center">

                <h5>Follow-up Cases</h5>

                <h2 class="text-warning">
                    {{ $followUpCases }}
                </h2>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card p-4 text-center">

                <h5>Unique Patients</h5>

                <h2 class="text-info">
                    {{ $newPatients }}
                </h2>

            </div>

        </div>

    </div>

    {{-- FILTER SECTION --}}
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

                        <label>Patient Name</label>

                        <input
                            type="text"
                            name="patient_name"
                            value="{{ request('patient_name') }}"
                            class="form-control"
                            placeholder="Search patient">

                    </div>

                    <div class="col-md-2">

                        <label>From Date</label>

                        <input
                            type="date"
                            name="from_date"
                            value="{{ request('from_date') }}"
                            class="form-control">

                    </div>

                    <div class="col-md-2">

                        <label>To Date</label>

                        <input
                            type="date"
                            name="to_date"
                            value="{{ request('to_date') }}"
                            class="form-control">

                    </div>

                    <div class="col-md-2 mt-4">

                        <button
                            class="btn btn-primary w-100">

                            FILTER

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="card">

        <div class="card-header">

            <h4>
                OPD Consultation List
            </h4>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>#</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Symptoms</th>
                            <th>Diagnosis</th>
                            <th>Prescription</th>
                            <th>Date</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($consultations as $key => $consultation)

                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <td>

                                    {{ $consultation->patient->first_name ?? '' }}
                                    {{ $consultation->patient->last_name ?? '' }}

                                </td>

                                <td>

                                    {{ optional($consultation->doctor)->name ?? 'N/A' }}

                                </td>

                                <td>

                                    {{ optional(optional($consultation->doctor)->department)->department_name ?? 'N/A' }}

                                </td>

                                <td>

                                    {{ $consultation->symptoms }}

                                </td>

                                <td>

                                    {{ $consultation->diagnosis }}

                                </td>

                                <td>

                                @if($consultation->medicines->count() > 0)

                                    <span class="badge bg-success">
                                        Yes
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        No
                                    </span>

                                @endif

                            </td>

                                <td>

                                    {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d M Y h:i A') }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center">

                                    No OPD records found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection