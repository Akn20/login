@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="card mb-4">

        <div class="card-body d-flex justify-content-between align-items-center">

            <div>
                <h3 class="mb-1">Laboratory Requests</h3>

                <p class="text-muted mb-0">
                    View all laboratory test requests made during consultations
                </p>
            </div>

            <div>
                <a href="{{ route('doctor.laboratory.reports') }}"
                   class="btn btn-primary">

                    <i class="feather-file-text me-1"></i>
                    View Reports

                </a>
            </div>

        </div>

    </div>


    {{-- SUMMARY CARDS --}}
    <div class="row mb-4">

        {{-- TOTAL REQUESTS --}}
        <div class="col-md-3">

            <div class="card h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Total Requests
                    </h6>

                    <h2 class="fw-bold text-primary">
                        {{ $requests->count() }}
                    </h2>

                </div>

            </div>

        </div>


        {{-- PENDING --}}
        <div class="col-md-3">

            <div class="card h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Pending
                    </h6>

                    <h2 class="fw-bold text-warning">

                        {{ $requests->where('status', 'pending')->count() }}

                    </h2>

                </div>

            </div>

        </div>


        {{-- IN PROCESS --}}
        <div class="col-md-3">

            <div class="card h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        In Progress
                    </h6>

                    <h2 class="fw-bold text-info">

                        {{ $requests->where('status', 'in_progress')->count() }}

                    </h2>

                </div>

            </div>

        </div>


        {{-- COMPLETED --}}
        <div class="col-md-3">

            <div class="card h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Completed
                    </h6>

                    <h2 class="fw-bold text-success">

                        {{ $requests->where('status', 'completed')->count() }}

                    </h2>

                </div>

            </div>

        </div>

    </div>


    {{-- REQUEST TABLE --}}
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Laboratory Request List
            </h5>

            {{-- SEARCH --}}
            <form method="GET"
                  class="d-flex gap-2">

                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Search patient or test..."
                       value="{{ request('search') }}">

                <button class="btn btn-outline-primary">

                    <i class="feather-search"></i>

                </button>

            </form>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Patient Name</th>

                            <th>Test Name</th>

                            <th>Priority</th>

                            <th>Status</th>

                            <th>Sample Status</th>

                            <th>Requested Date</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($requests as $request)

                            @php

                                $patient = $request->patient;

                                $sample = $request->sample;

                            @endphp


                            <tr>

                                {{-- SERIAL --}}
                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                {{-- PATIENT --}}
                                <td>

                                    @if($patient)

                                        <div class="fw-bold">

                                            {{ $patient->first_name ?? '' }}
                                            {{ $patient->last_name ?? '' }}

                                        </div>

                                    @else

                                        <span class="text-muted">
                                            N/A
                                        </span>

                                    @endif

                                </td>


                                {{-- TEST NAME --}}
                                <td>

                                    {{ $request->test_name ?? 'N/A' }}

                                </td>


                                {{-- PRIORITY --}}
                                <td>

                                    @if($request->priority == 'Urgent')

                                        <span class="badge bg-danger">
                                            Urgent
                                        </span>

                                    @elseif($request->priority == 'Emergency')

                                        <span class="badge bg-dark">
                                            Emergency
                                        </span>

                                    @else

                                        <span class="badge bg-primary">
                                            Normal
                                        </span>

                                    @endif

                                </td>


                                {{-- REQUEST STATUS --}}
                                <td>

                                    @if($request->status == 'completed')

                                        <span class="badge bg-success">
                                            Completed
                                        </span>

                                    @elseif($request->status == 'in_progress')

                                        <span class="badge bg-info">
                                            In Process
                                        </span>

                                    @elseif($request->status == 'pending')

                                        <span class="badge bg-danger">
                                            Pending
                                        </span>

                                    @else

                                        <span class="badge bg-warning">
                                            Rejected
                                        </span>

                                    @endif

                                </td>


                                {{-- SAMPLE STATUS --}}
                                <td>

                                    @if($sample)

                                        @if($sample->status == 'Collected')

                                            <span class="badge bg-primary">
                                                Collected
                                            </span>

                                        @elseif($sample->status == 'Completed')

                                            <span class="badge bg-success">
                                                Completed
                                            </span>

                                        @elseif($sample->status == 'In Process')

                                            <span class="badge bg-info">
                                                In Process
                                            </span>

                                        @elseif($sample->status == 'Rejected')

                                            <span class="badge bg-danger">
                                                Rejected
                                            </span>

                                        @else

                                            <span class="badge bg-warning">
                                                Pending
                                            </span>

                                        @endif

                                    @else

                                        <span class="text-muted">
                                            No Sample
                                        </span>

                                    @endif

                                </td>


                                {{-- REQUEST DATE --}}
                                <td>

                                    {{ $request->created_at->format('d M Y') }}

                                    <br>

                                    <small class="text-muted">

                                        {{ $request->created_at->format('h:i A') }}

                                    </small>

                                </td>


                                {{-- ACTION --}}
                                <td>

                        @php

                            $report = \App\Models\LabReport::where(
                                'sample_id',
                                $request->sample->id ?? null
                            )->latest()->first();

                        @endphp

                        @if($report)

                            <a href="{{ route(
                                'doctor.laboratory.reports.details',
                                $report->id
                            ) }}"
                            class="btn btn-success btn-sm">

                                <i class="feather-eye"></i>

                                View Report

                            </a>

                        @else

                            <button class="btn btn-secondary btn-sm"
                                    disabled>

                                Awaiting Result

                            </button>

                        @endif

                    </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8"
                                    class="text-center text-muted py-4">

                                    No laboratory requests found

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