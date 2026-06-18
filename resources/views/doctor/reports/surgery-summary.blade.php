@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="page-header mb-4">
        <h3 class="fw-bold">
            Surgery Count Report
        </h3>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="row">

        <div class="col-md-3 mb-4">

            <div class="card p-4 text-center">

                <h5>Total Surgeries</h5>

                <h2 class="text-primary">
                    {{ $totalSurgeries }}
                </h2>

            </div>

        </div>

        <div class="col-md-3 mb-4">

    <div class="card p-4 text-center">

        <h5>Emergency Surgery</h5>

        <h2 class="text-danger">
            {{ $emergencySurgeries }}
        </h2>

    </div>

</div>

<div class="col-md-3 mb-4">

    <div class="card p-4 text-center">

        <h5>Normal Surgeries</h5>

        <h2 class="text-success">
            {{ $normalSurgeries }}
        </h2>

    </div>

</div>

        <div class="col-md-3 mb-4">

            <div class="card p-4 text-center">

                <h5>Today's Surgeries</h5>

                <h2 class="text-info">
                    {{ $todaySurgeries }}
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

                        <button class="btn btn-primary w-100">

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
                Surgery List
            </h4>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Surgery Type</th>
                        <th>Priority</th>
                        <th>Date</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($surgeries as $key => $surgery)

                        <tr>

                            <td>{{ $key + 1 }}</td>

                            <td>

                                {{ $surgery->patient->first_name ?? '' }}
                                {{ $surgery->patient->last_name ?? '' }}

                            </td>

                            <td>

                                {{ optional($surgery->doctor)->name ?? 'N/A' }}

                            </td>

                            <td>

                                {{ optional(optional($surgery->doctor)->department)->department_name ?? 'N/A' }}

                            </td>

                            <td>

                                {{ $surgery->surgery_type ?? 'N/A' }}

                            </td>

                            <td>

    @if($surgery->priority == 'Emergency')

        <span class="badge bg-danger">
            Emergency
        </span>

    @else

        <span class="badge bg-success">
            Normal
        </span>

    @endif

</td>

                            <td>

                                {{ \Carbon\Carbon::parse($surgery->surgery_date)->format('d M Y h:i A') }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center">

                                No surgery records found

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection