@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <div class="row align-items-center g-3">

                <div class="col-md-8">

                    <h2 class="fw-bold mb-1">
                        Follow-up Compliance Report
                    </h2>

                    <p class="text-muted mb-0">
                        Monitor patient follow-up compliance and attendance
                    </p>

                </div>

            </div>

        </div>

    </div>



    {{-- DASHBOARD CARDS --}}
    <div class="row mb-4">

        <div class="col">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Total
                    </h6>

                    <h2 class="text-primary fw-bold">
                        {{ $totalFollowups }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Today
                    </h6>

                    <h2 class="text-info fw-bold">
                        {{ $todayFollowups }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Completed
                    </h6>

                    <h2 class="text-success fw-bold">
                        {{ $completedFollowups }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Pending
                    </h6>

                    <h2 class="text-warning fw-bold">
                        {{ $pendingFollowups }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Missed
                    </h6>

                    <h2 class="text-danger fw-bold">
                        {{ $missedFollowups }}
                    </h2>

                </div>

            </div>

        </div>

       

    </div>



    {{-- FILTER SECTION --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row align-items-end">

                    {{-- DOCTOR --}}
                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            Doctor
                        </label>

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

                    {{-- DEPARTMENT --}}
                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            Department
                        </label>

                        <select
                            name="department_id"
                            class="form-control">

                            <option value="">
                                All Departments
                            </option>

                            @foreach($departments as $department)

                                <option
                                    value="{{ $department->id }}"
                                    {{ request('department_id') == $department->id ? 'selected' : '' }}>

                                    {{ $department->department_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- STATUS --}}
                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-control">

                            <option value="">
                                All Status
                            </option>

                            <option value="Pending">
                                Pending
                            </option>

                            <option value="Completed">
                                Completed
                            </option>

                            <option value="Missed">
                                Missed
                            </option>

                        </select>

                    </div>

                    {{-- PATIENT SEARCH --}}
                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            Patient
                        </label>

                        <input
                            type="text"
                            name="patient_name"
                            value="{{ request('patient_name') }}"
                            class="form-control"
                            placeholder="Search patient">

                    </div>

                    {{-- FROM DATE --}}
                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            From Date
                        </label>

                        <input
                            type="date"
                            name="from_date"
                            value="{{ request('from_date') }}"
                            class="form-control">

                    </div>

                    {{-- TO DATE --}}
                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            To Date
                        </label>

                        <input
                            type="date"
                            name="to_date"
                            value="{{ request('to_date') }}"
                            class="form-control">

                    </div>

                </div>

                <div class="mt-2">

                    <button class="btn btn-primary">

                        <i class="fa fa-filter"></i>
                        Filter

                    </button>

                </div>

            </form>

        </div>

    </div>



    {{-- TABLE --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">

            <h5 class="mb-0">
                Follow-up Records
            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Follow-up Date</th>
                            <th>Status</th>
                            <th>Remarks</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($followUps as $key => $followUp)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                {{-- PATIENT --}}
                                <td>

                                    {{ $followUp->patient->first_name ?? '' }}
                                    {{ $followUp->patient->last_name ?? '' }}

                                </td>

                                {{-- DOCTOR --}}
                                <td>

                                    {{ optional($followUp->doctor)->name ?? 'N/A' }}

                                </td>

                                {{-- DEPARTMENT --}}
                                <td>

                                    {{ optional(optional($followUp->doctor)->department)->department_name ?? 'N/A' }}

                                </td>

                                {{-- FOLLOW-UP DATE --}}
                                <td>

                                    {{ \Carbon\Carbon::parse($followUp->follow_up_date)->format('d M Y') }}

                                </td>

                                {{-- STATUS --}}
                                <td>

                                    @if($followUp->status == 'Completed')

                                        <span class="badge bg-success">
                                            Completed
                                        </span>

                                    @elseif($followUp->status == 'Pending')

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Missed
                                        </span>

                                    @endif

                                </td>

                                {{-- REMARKS --}}
                                <td>

                                    {{ $followUp->remarks ?? 'N/A' }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center">

                                    No follow-up records found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="mt-3">

                {{ $followUps->links() }}

            </div>

        </div>

    </div>

</div>

@endsection