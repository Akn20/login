@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE TITLE --}}
    <div class="page-header mb-4">

        <h3 class="fw-bold">
            IPD Case Summary Report
        </h3>

    </div>

    {{-- SUMMARY CARDS --}}
    <div class="row">

        <div class="col-md-3 mb-4">

            <div class="card p-4 text-center">

                <h5>Total Admissions</h5>

                <h2 class="text-primary">
                    {{ $totalAdmissions }}
                </h2>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card p-4 text-center">

                <h5>Active Admissions</h5>

                <h2 class="text-success">
                    {{ $activeAdmissions }}
                </h2>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card p-4 text-center">

                <h5>Discharged Patients</h5>

                <h2 class="text-danger">
                    {{ $dischargedPatients }}
                </h2>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card p-4 text-center">

                <h5>Today's Admissions</h5>

                <h2 class="text-info">
                    {{ $todayAdmissions }}
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

                    <div class="col-md-2">

                        <label>Status</label>

                        <select
                            name="status"
                            class="form-control">

                            <option value="">
                                All Status
                            </option>

                            <option value="Active"
                                {{ request('status') == 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="Discharged"
                                {{ request('status') == 'discharged' ? 'selected' : '' }}>
                                Discharged
                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

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

                    <div class="col-md-1 mt-4">

                        <button
                            class="btn btn-primary w-100">

                            GO

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
                IPD Admission List
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
                            <th>Status</th>
                            <th>Admission Date</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($admissions as $key => $admission)

                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <td>

                                    {{ $admission->patient->first_name ?? '' }}
                                    {{ $admission->patient->last_name ?? '' }}

                                </td>

                                <td>

                                    {{ optional($admission->doctor)->name ?? 'N/A' }}

                                </td>

                                <td>

                                    {{ optional(optional($admission->doctor)->department)->department_name ?? 'N/A' }}

                                </td>

                                <td>

                                    @if($admission->status == 'active')

                                        <span class="badge bg-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Discharged
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    {{ \Carbon\Carbon::parse($admission->admission_date)->format('d M Y h:i A') }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center">

                                    No IPD records found

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