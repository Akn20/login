@extends('layouts.admin')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0">Test Completion Summary</h5>
        <small class="text-muted">Overview of test performance and trends</small>
    </div>

    {{-- PERIOD FILTER --}}
    <form method="GET" class="d-flex gap-2">
        <select name="period" class="form-control form-control-sm" onchange="this.form.submit()">
            <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Daily</option>
            <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly</option>
            <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
        </select>
    </form>
</div>

{{-- SUMMARY CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="border rounded p-3 text-center">
            <p class="text-muted mb-1">Total Completed Tests</p>
            <h4 class="fw-bold text-success">{{ $completed }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="border rounded p-3 text-center">
            <p class="text-muted mb-1">Pending Tests</p>
            <h4 class="fw-bold text-warning">{{ $pending }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="border rounded p-3 text-center">
            <p class="text-muted mb-1">Total Tests</p>
            <h4 class="fw-bold">{{ $total }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="border rounded p-3 text-center">
            <p class="text-muted mb-1">Completion Rate</p>
            <h4 class="fw-bold">{{ $completionRate }}%</h4>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- TEST CATEGORY COUNTS --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">Test Category Counts</h6>
            </div>
            <div class="card-body">
                @if($categoryCounts->count() > 0)
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th class="text-end">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categoryCounts as $category => $count)
                            <tr>
                                <td>{{ $category ?? 'Uncategorized' }}</td>
                                <td class="text-end"><span class="badge bg-primary">{{ $count }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted text-center">No category data available</p>
                @endif
            </div>
        </div>
    </div>

    {{-- DAILY/WEEKLY/MONTHLY SUMMARY --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">{{ ucfirst($period) }} Summary Trends</h6>
            </div>
            <div class="card-body">
                @if($period == 'daily' && $dailySummary->count() > 0)
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th class="text-end">Tests Completed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dailySummary as $day)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($day->date)->format('d M Y') }}</td>
                                <td class="text-end"><span class="badge bg-success">{{ $day->count }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif($period == 'weekly' && $weeklySummary->count() > 0)
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Week</th>
                                <th class="text-end">Tests Completed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($weeklySummary as $week)
                            <tr>
                                <td>{{ $week->label }}</td>
                                <td class="text-end"><span class="badge bg-success">{{ $week->count }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif($period == 'monthly' && $monthlySummary->count() > 0)
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th class="text-end">Tests Completed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlySummary as $month)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($month->month . '-01')->format('M Y') }}</td>
                                <td class="text-end"><span class="badge bg-success">{{ $month->count }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted text-center">No trend data available for {{ $period }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- CHARTS SECTION --}}
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Completion Trends (Last 7 Days)</h6>
            </div>
            <div class="card-body">
                @if($dailySummary->count() > 0)
                    <div class="progress" style="height: 30px;">
                        @foreach($dailySummary as $day)
                            @php $maxCount = $dailySummary->max('count'); @endphp
                            <div class="progress-bar" 
                                 role="progressbar" 
                                 style="width: {{ $maxCount > 0 ? ($day->count / $maxCount) * 100 : 0 }}%; background-color: {{ ['#28a745', '#17a2b8', '#007bff', '#6f42c1', '#fd7e14', '#20c997', '#e83e8c'][$loop->index % 7] }};"
                                 title="{{ \Carbon\Carbon::parse($day->date)->format('d M Y') }}: {{ $day->count }} tests">
                                {{ $day->count }}
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        @foreach($dailySummary as $day)
                            <small class="text-muted">{{ \Carbon\Carbon::parse($day->date)->format('d M') }}</small>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">No chart data available</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection