@extends('layouts.admin')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0">Critical Results Report</h5>
        <small class="text-muted">Tests containing critical or abnormal results</small>
    </div>

    <div class="d-flex gap-2">
        {{-- FILTER BY STATUS --}}
        <form method="GET" class="d-flex gap-2">
            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
            @if(request('from_date'))<input type="hidden" name="from_date" value="{{ request('from_date') }}">@endif
            @if(request('to_date'))<input type="hidden" name="to_date" value="{{ request('to_date') }}">@endif
        </form>
    </div>
</div>

{{-- SUMMARY CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="border rounded p-3 text-center">
            <h6 class="text-muted">Total Critical Alerts</h6>
            <h4 class="fw-bold text-danger">{{ $totalCount }}</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="border rounded p-3 text-center">
            <h6 class="text-muted">Unresolved</h6>
            <h4 class="fw-bold text-warning">{{ $unresolvedCount }}</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="border rounded p-3 text-center">
            <h6 class="text-muted">Resolved</h6>
            <h4 class="fw-bold text-success">{{ $resolvedCount }}</h4>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="criticalReportTable">

                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>Test Name</th>
                        <th>Critical Value</th>
                        <th>Alert Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    @forelse($alerts as $alert)

                        @php
                            $patient = $alert->report->sample->labRequest->patient ?? null;
                            $labTest = $alert->report->sample->labRequest->labTest ?? null;
                            $isUnresolved = $alert->status == 'Pending';
                        @endphp

                        <tr class="{{ $isUnresolved ? 'table-danger' : '' }}">
                            <td>{{ $loop->iteration }}</td>

                            {{-- PATIENT NAME --}}
                            <td>
                                {{ $patient ? $patient->first_name . ' ' . $patient->last_name : 'N/A' }}
                            </td>

                            {{-- TEST NAME --}}
                            <td>
                                {{ $labTest ? $labTest->test_name : ($alert->report->sample->labRequest->test_name ?? 'N/A') }}
                            </td>

                            {{-- CRITICAL VALUE --}}
                            <td class="fw-bold text-danger">
                                {{ $alert->value ?? $alert->critical_value ?? '-' }}
                            </td>

                            {{-- ALERT STATUS --}}
                            <td>
                                @if($isUnresolved)
                                    <span class="badge bg-danger">Unresolved</span>
                                @else
                                    <span class="badge bg-success">Resolved</span>
                                @endif
                            </td>

                            {{-- DATE --}}
                            <td>
                                {{ $alert->created_at->format('d M Y') }}
                            </td>

                            {{-- ACTION --}}
                            <td>
                                @if($isUnresolved)
                                    <a href="{{ route('admin.laboratory.reports.critical.resolve', $alert->id) }}" 
                                       class="btn btn-sm btn-outline-danger"
                                       title="Mark as Resolved">
                                        Resolve
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No critical results found
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection