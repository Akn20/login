@extends('layouts.admin')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0">Pending Report List</h5>
        <small class="text-muted">Reports awaiting verification or release</small>
    </div>

    <div class="d-flex gap-2">
        {{-- SEARCH --}}
        <form method="GET" class="d-flex gap-2">

    {{-- SEARCH --}}
    <input type="text" name="search" class="form-control form-control-sm"
        placeholder="Search Patient / Test"
        value="{{ request('search') }}">

    {{-- FILTER --}}
    <select name="filter" class="form-control form-control-sm">
        <option value="">All</option>
        <option value="Pending" {{ request('filter') == 'Pending' ? 'selected' : '' }}>
            Pending
        </option>
        <option value="Finalized" {{ request('filter') == 'Finalized' ? 'selected' : '' }}>
            Finalized
        </option>
    </select>

    <button class="btn btn-light-brand btn-sm">
        <i class="feather-search"></i>
    </button>

</form>
    </div>
</div>

<div class="card">
    <div class="card-body">

        {{-- SUMMARY --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="border rounded p-3 text-center">
                    <h6 class="text-muted">Total Pending</h6>
                    <h4 class="fw-bold text-warning">{{ $reports->count() }}</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded p-3 text-center">
                    <h6 class="text-muted">Overdue Pending</h6>
                    <h4 class="fw-bold text-danger">
                        
                    {{ $reports->filter(fn($r) => $r->created_at->diffInDays(now()) > 2)->count() }}
                    </h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded p-3 text-center">
                    <h6 class="text-muted">Ready Today</h6>
                    <h4 class="fw-bold text-success">
                        {{ $reports->filter(fn($r) => $r->created_at->isToday())->count() }}
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="pendingReportTable">

                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Test Name</th>
                        <th>Sample ID</th>
                        <th>Status</th>
                        <th>Requested Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    @forelse($reports as $report)

                        @php
                            $patient = $report->sample->labRequest->patient ?? null;
                            $labTest = $report->sample->labRequest->labTest ?? null;
                            $daysPending = $report->created_at->diffInDays(now());
                            $isOverdue = $daysPending > 2;
                        @endphp

                        <tr class="{{ $isOverdue ? 'table-danger' : '' }}">
                            <td>{{ $loop->iteration }}</td>

                            {{-- PATIENT NAME --}}
                            <td>
                               {{ $report->sample->labRequest->patient->first_name ?? 'N/A' }}
                            </td>

                            {{-- TEST REQUESTED --}}
                            <td>
                                {{ $labTest->test_name ?? ($report->sample->labRequest->test_name ?? 'N/A') }}
                            </td>

                            {{-- SAMPLE ID --}}
                            <td>
                                {{ $report->sample->barcode ?? $report->sample_id ?? '-' }}
                            </td>

                            {{-- PENDING STATUS --}}
                            @php
    $daysPending = $report->created_at->diffInDays(now());
    $isOverdue = $daysPending > 2;
@endphp

<td>
    @if($isOverdue)
        <span class="badge bg-danger">Overdue</span>
    @else
        <span class="badge bg-warning">Pending</span>
    @endif
</td>

                            {{-- REQUEST DATE --}}
                            <td>
                                {{ $report->created_at->format('d M Y') }}

                                @if($report->isOverdue)
                                    <br>
                                    <small class="text-danger">
                                        {{ $report->daysPending }} 
                                        {{ $report->daysPending == 1 ? 'day' : 'days' }} overdue
                                    </small>
                                @endif
                            </td>

                            {{-- ACTION --}}
                            <td>
    @if($report->verification_status == 'Pending')
        <form action="{{ route('admin.laboratory.report.verify', $report->id) }}" method="POST">
            @csrf
            <button class="btn btn-sm btn-success">
                Verify
            </button>
        </form>
    @else
        <span class="badge bg-primary">Finalized</span>
    @endif
</td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No pending reports found
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection