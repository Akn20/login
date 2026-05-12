@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5 class="m-b-10">View Breakdown</h5>
    </div>

    <div class="page-header-right">
        <a href="{{ route('admin.laboratory.breakdown.index') }}" class="btn btn-secondary">
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

                <h5 class="mb-4">Breakdown Details</h5>

                <p><strong>Equipment:</strong> {{ $breakdown->equipment->name ?? '-' }}</p>
                <p><strong>Code:</strong> {{ $breakdown->equipment->equipment_code ?? '-' }}</p>
                <p><strong>Date:</strong> {{ $breakdown->breakdown_date }}</p>
                <p><strong>Reported By:</strong> {{ $breakdown->reported_by }}</p>

            </div>
        </div>
    </div>

    <!-- RIGHT CARD -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-4">Additional Info</h5>

                <p><strong>Description:</strong> {{ $breakdown->description }}</p>
                <p><strong>Severity:</strong> {{ $breakdown->severity }}</p>

                <p>
                    <strong>Status:</strong>
                    <span class="badge bg-{{
                        $breakdown->status == 'Resolved' ? 'success' :
                        ($breakdown->status == 'In Progress' ? 'warning' : 'danger')
                    }}">
                        {{ $breakdown->status }}
                    </span>
                </p>

            </div>
        </div>
    </div>

</div>
</div>

@endsection