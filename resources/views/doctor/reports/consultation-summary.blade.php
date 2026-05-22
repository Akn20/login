@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Consultation Report</h5>
    </div>
    </div>

    {{-- DASHBOARD CARDS --}}
    <div class="row">

        <div class="col-md-4 mb-4">

            <div class="card p-4 text-center">
                <div class="card-body text-center">
                    <h5>Total Consultations</h5>
                    <h2 class="text-primary">
                        {{ $totalConsultations }}
                    </h2>
                </div>
            </div>
        </div>

      <div class="col-md-4 mb-4">

            <div class="card p-4 text-center">
                <div class="card-body text-center">
                    <h5>Today's Consultations</h5>
                    <h2 class="text-success">
                        {{ $todayConsultations }}
                    </h2>
                </div>
            </div>
        </div>

    </div>

    {{-- FILTER SECTION --}}
    <div class="card mt-4">

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

    {{-- CONSULTATION TABLE --}}
    <div class="card mt-4">

        <div class="card-header">
            <h4>Consultation List</h4>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Symptoms</th>
                        <th>Diagnosis</th>
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
                                {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d M Y h:i A') }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center">
                                No consultation records found
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection