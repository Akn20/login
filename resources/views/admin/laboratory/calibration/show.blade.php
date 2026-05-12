@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5 class="m-b-10">View Calibration</h5>
    </div>

    <div class="page-header-right">
        <a href="{{ route('admin.laboratory.calibration.index') }}" class="btn btn-secondary">
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

                <h5 class="mb-4">Calibration Details</h5>

                <p><strong>Equipment:</strong> {{ $calibration->equipment->name ?? '-' }}</p>
                <p><strong>Code:</strong> {{ $calibration->equipment->equipment_code ?? '-' }}</p>
                <p><strong>Type:</strong> {{ $calibration->calibration_type }}</p>
                <p><strong>Date:</strong> {{ $calibration->calibration_date }}</p>

            </div>
        </div>
    </div>

    <!-- RIGHT CARD -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-4">Additional Info</h5>

                <p><strong>Result:</strong> {{ $calibration->result }}</p>
                <p><strong>Next Due:</strong> {{ $calibration->next_due_date ?? '-' }}</p>
                <p><strong>Notes:</strong> {{ $calibration->notes ?? '-' }}</p>

            </div>
        </div>
    </div>

</div>
</div>

@endsection