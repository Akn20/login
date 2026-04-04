@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5 class="m-b-10">View Preventive Maintenance</h5>
    </div>

    <div class="page-header-right">
        <a href="{{ route('admin.laboratory.preventive.index') }}" class="btn btn-secondary">
            <i class="feather-arrow-left me-2"></i> Back to List
        </a>
    </div>
</div>

<div class="main-content">
<div class="row">

    <!-- LEFT CARD -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-4">Maintenance Details</h5>

                <p><strong>Equipment:</strong> {{ $record->equipment->name ?? '-' }}</p>
                <p><strong>Code:</strong> {{ $record->equipment->equipment_code ?? '-' }}</p>
                <p><strong>Frequency:</strong> {{ $record->frequency }}</p>
                <p><strong>Next Date:</strong> {{ $record->next_maintenance_date }}</p>

            </div>
        </div>
    </div>

    <!-- RIGHT CARD -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-4">Additional Info</h5>

                <p><strong>Technician:</strong> {{ $record->technician ?? '-' }}</p>

                <!-- Optional status -->
                <p>
                    <strong>Status:</strong>
                    <span class="badge bg-{{ 
                        \Carbon\Carbon::parse($record->next_maintenance_date)->isPast() 
                        ? 'danger' : 'success' 
                    }}">
                        {{ \Carbon\Carbon::parse($record->next_maintenance_date)->isPast() ? 'Overdue' : 'Scheduled' }}
                    </span>
                </p>

            </div>
        </div>
    </div>

</div>
</div>

@endsection