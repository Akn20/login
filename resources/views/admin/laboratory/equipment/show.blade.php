@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5>View Equipment</h5>
    </div>

    <div class="page-header-right">
        <a href="{{ route('admin.laboratory.equipment.index') }}" class="btn btn-secondary">
           <i class="feather-arrow-left me-2"></i> Back to List
        </a>
    </div>
</div>

<div class="main-content">
<div class="row">

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-4">Equipment Details</h5>

                <p><strong>Code:</strong> {{ $equipment->equipment_code }}</p>
                <p><strong>Name:</strong> {{ $equipment->name }}</p>
                <p><strong>Type:</strong> {{ $equipment->type }}</p>
                <p><strong>Manufacturer:</strong> {{ $equipment->manufacturer ?? '-' }}</p>
                <p><strong>Model:</strong> {{ $equipment->model_number ?? '-' }}</p>

            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-4">Additional Info</h5>

                <p><strong>Serial:</strong> {{ $equipment->serial_number ?? '-' }}</p>
                <p><strong>Installation Date:</strong> {{ $equipment->installation_date ?? '-' }}</p>
                <p><strong>Location:</strong> {{ $equipment->location ?? '-' }}</p>

                <p>
                    <strong>Status:</strong>
                    <span class="badge bg-{{ $equipment->status ? 'success' : 'danger' }}">
                        {{ $equipment->status ? 'Active' : 'Inactive' }}
                    </span>
                </p>

                <p><strong>Condition:</strong> {{ $equipment->condition_status }}</p>

            </div>
        </div>
    </div>

</div>
</div>

@endsection