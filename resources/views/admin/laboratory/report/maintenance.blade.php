@extends('layouts.admin')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0">Equipment Maintenance Report</h5>
        <small class="text-muted">Maintenance reports for laboratory equipment</small>
    </div>

    <div class="d-flex gap-2">
        {{-- FILTER BY STATUS --}}
        <form method="GET" class="d-flex gap-2">
            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Overdue" {{ request('status') == 'Overdue' ? 'selected' : '' }}>Overdue</option>
            </select>
            @if(request('equipment_id'))<input type="hidden" name="equipment_id" value="{{ request('equipment_id') }}">@endif
        </form>

        {{-- FILTER BY EQUIPMENT --}}
        <form method="GET" class="d-flex gap-2">
            <select name="equipment_id" class="form-control form-control-sm" onchange="this.form.submit()">
                <option value="">All Equipment</option>
                @foreach($equipment as $eq)
                    <option value="{{ $eq->id }}" {{ request('equipment_id') == $eq->id ? 'selected' : '' }}>
                        {{ $eq->name }}
                    </option>
                @endforeach
            </select>
            @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
        </form>
    </div>
</div>

{{-- SUMMARY CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="border rounded p-3 text-center">
            <h6 class="text-muted">Total Maintenance Records</h6>
            <h4 class="fw-bold">{{ $maintenances->count() }}</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="border rounded p-3 text-center">
            <h6 class="text-muted">Overdue Maintenance</h6>
            <h4 class="fw-bold text-danger">{{ $overdueCount }}</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="border rounded p-3 text-center">
            <h6 class="text-muted">Upcoming (7 days)</h6>
            <h4 class="fw-bold text-warning">{{ $upcomingCount }}</h4>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">

        <table class="table table-hover text-center" id="maintenanceTable">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Equipment Name</th>
                    <th>Last Service Date</th>
                    <th>Next Maintenance Date</th>
                    <th>Maintenance Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($maintenances as $m)
                    @php
    $lastDate = $m->maintenance_date 
        ? \Carbon\Carbon::parse($m->maintenance_date) 
        : null;

    $nextDate = $lastDate 
        ? $lastDate->copy()->addDays(30) 
        : null;

    $isOverdue = $nextDate && $nextDate->isPast() && $m->status != 'Completed';
    $isUpcoming = $nextDate && $nextDate->isFuture() && $nextDate->diffInDays(now()) <= 7 && $m->status != 'Completed';
@endphp
                    <tr class="{{ $isOverdue ? 'table-danger' : ($isUpcoming ? 'table-warning' : '') }}">
                        <td>{{ $loop->iteration }}</td>

                        {{-- EQUIPMENT NAME --}}
                        <td>
                            <strong>{{ $m->equipment->name ?? '-' }}</strong>
                            @if($m->equipment)
                                <br><small class="text-muted">{{ $m->equipment->model_number ?? '' }}</small>
                            @endif
                        </td>

                        {{-- LAST SERVICE DATE --}}
                        
                           <td>
                                {{ $lastDate ? $lastDate->format('d M Y') : '-' }}
                            </td>
                        

                        {{-- NEXT MAINTENANCE DATE --}}
                        <td>
                            {{ $nextDate ? $nextDate->format('d M Y') : '-' }}
                        </td>

                        {{-- MAINTENANCE STATUS --}}
                        <td>
                            @if($isOverdue)
                                <span class="badge bg-danger">Overdue</span>
                            @elseif($isUpcoming)
                                <span class="badge bg-warning">Due Soon</span>
                            @elseif($m->status == 'Completed')
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-secondary">{{ $m->status ?? 'Scheduled' }}</span>
                            @endif
                        </td>

                        {{-- ACTION --}}
                        <td>
                            <a href="{{ route('admin.laboratory.maintenance.show', $m->id) }}" 
                               class="btn btn-sm btn-outline-primary">
                                View History
                            </a>
                        </td>

                    </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No maintenance records found
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

@endsection