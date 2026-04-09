@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5 class="m-b-10">View Maintenance</h5>
    </div>

    <div class="page-header-right">
        <a href="{{ route('admin.laboratory.maintenance.index') }}" class="btn btn-secondary">
            <i class="feather-arrow-left me-2"></i> Back to List
        </a>
    </div>
</div>

<div class="main-content">
<div class="row">

    <!-- LEFT -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-4">Maintenance Details</h5>

                <p><strong>Equipment:</strong> {{ $maintenance->equipment->name ?? '-' }}</p>
                <p><strong>Code:</strong> {{ $maintenance->equipment->equipment_code ?? '-' }}</p>
                <p><strong>Type:</strong> {{ $maintenance->maintenance_type }}</p>
                <p><strong>Date:</strong> {{ $maintenance->maintenance_date }}</p>

            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-4">Additional Info</h5>

                <p><strong>Technician:</strong> {{ $maintenance->technician ?? '-' }}</p>
                <p><strong>Description:</strong> {{ $maintenance->description ?? '-' }}</p>

                <p>
                    <strong>Status:</strong>
                    <span class="badge bg-{{
                        $maintenance->status == 'Completed' ? 'success' :
                        ($maintenance->status == 'In Progress' ? 'warning' : 'secondary')
                    }}">
                        {{ $maintenance->status }}
                    </span>
                </p>

            </div>
        </div>
    </div>

</div>
</div>

@endsection