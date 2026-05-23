@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <h2 class="fw-bold mb-1">
                        Consultation Summary Report
                    </h2>

                    <p class="text-muted mb-0">
                        Doctor consultation analytics and patient summary
                    </p>

                </div>

                <div class="col-md-4 text-md-end mt-3 mt-md-0">

    <a href="{{ route('doctor.reports.consultations.download', request()->all()) }}"
       class="btn btn-success btn-lg me-2">

        <i class="fa fa-download"></i>
        Download Report

    </a>

</div>

            </div>

        </div>

    </div>

    {{-- DASHBOARD CARDS --}}
    <div class="row mb-4">

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body text-center">

                <h6 class="text-muted mb-3">
                    Total Consultations
                </h6>

                <h2 class="text-primary fw-bold">
                    {{ $totalConsultations }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body text-center">

                <h6 class="text-muted mb-3">
                    Today's Consultations
                </h6>

                <h2 class="text-success fw-bold">
                    {{ $todayConsultations }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body text-center">

                <h6 class="text-muted mb-3">
                    OPD Appointments
                </h6>

                <h2 class="text-info fw-bold">
                    {{ $opdCount }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body text-center">

                <h6 class="text-muted mb-3">
                    IPD Admissions
                </h6>

                <h2 class="text-danger fw-bold">
                    {{ $ipdCount }}
                </h2>

            </div>

        </div>

    </div>

</div>

    {{-- FILTER SECTION --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-white">
            <h5 class="mb-0">Filter Reports</h5>
        </div>

        <div class="card-body">

            <form method="GET">

            <div class="row align-items-end">

    <div class="col-md-3 mb-3">

        <label class="form-label">
            Department
        </label>

        <select name="department_id" class="form-control">

            <option value="">
                All Departments
            </option>

            @foreach($departments as $department)

                <option value="{{ $department->id }}">

                    {{ $department->department_name }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-2 mb-3">

        <label class="form-label">
            From Date
        </label>

        <input type="date"
               name="from_date"
               class="form-control">

    </div>

    <div class="col-md-2 mb-3">

        <label class="form-label">
            To Date
        </label>

        <input type="date"
               name="to_date"
               class="form-control">

    </div>

    <div class="col-md-3 mb-3">

        <label class="form-label">
            Patient Name
        </label>

        <input type="text"
               name="patient_name"
               class="form-control"
               placeholder="Search patient">

    </div>

    <div class="col-md-2 mb-3 d-grid">

        <button class="btn btn-primary">
            <i class="fa fa-filter"></i>
            Filter
        </button>

    </div>

</div>

            </form>

        </div>

    </div>

    {{-- VALIDATION ERROR --}}
    @if(request('from_date') && request('to_date'))

        @if(request('from_date') > request('to_date'))

            <div class="alert alert-danger">
                Invalid date range selected.
            </div>

        @endif

    @endif

    {{-- CONSULTATION TABLE --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">Consultation List</h5>

            <span class="badge bg-primary">
                Total Records: {{ $consultations->count() }}
            </span>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-light">

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
                                    {{ $loop->iteration }}
                                </td>

                                {{-- PATIENT --}}
                                <td>

                                    {{ $consultation->patient->first_name ?? '' }}
                                    {{ $consultation->patient->last_name ?? '' }}

                                </td>

                                {{-- DOCTOR --}}
                                <td>
                                    {{ optional($consultation->doctor)->name ?? 'N/A' }}
                                </td>

                                {{-- DEPARTMENT --}}
                                <td>
                                    {{ optional(optional($consultation->doctor)->department)->department_name ?? 'N/A' }}
                                </td>

                                {{-- SYMPTOMS --}}
                                <td>
                                    {{ $consultation->symptoms ?? 'N/A' }}
                                </td>

                                {{-- DIAGNOSIS --}}
                                <td>
                                    {{ $consultation->diagnosis ?? 'N/A' }}
                                </td>

                                {{-- PRESCRIPTION --}}
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

                                {{-- DATE --}}
                                <td>

                                    {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d M Y h:i A') }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="10" class="text-center text-muted">

                                    No consultation records found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="mt-3">
                {{ $consultations->appends(request()->query())->links() }}
            </div>

        </div>

    </div>

</div>

@endsection