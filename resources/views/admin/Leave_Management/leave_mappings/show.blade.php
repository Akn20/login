@extends('layouts.admin')

@section('content')
<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-title">
        <h5 class="m-b-10 mb-1"><i class="feather-eye me-2"></i>Mapping Details</h5>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.leave-mappings.edit', $mapping->id) }}" class="btn btn-primary">
            <i class="feather-edit-2 me-1"></i> Edit
        </a>
        <a href="{{ route('admin.leave-mappings.index') }}" class="btn btn-light">
            <i class="feather-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="row">
            <!-- Core Info -->
            <div class="col-md-6 mb-4">
                <h6 class="text-muted text-uppercase fw-bold mb-3">Core Information</h6>
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Leave Type</th>
                        {{-- Fixed: Using the display_name from the relationship --}}
                        <td><span class="badge bg-soft-primary text-primary px-3">{{ $mapping->leaveType->display_name ?? 'N/A' }}</span></td>
                    </tr>
                    <tr>
                        <th>Priority</th>
                        <td>{{ $mapping->priority }} <small class="text-muted">(Higher overrides lower)</small></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge {{ $mapping->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($mapping->status) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Eligibility Scope -->
            <div class="col-md-6 mb-4">
                <h6 class="text-muted text-uppercase fw-bold mb-3">Eligibility Scope</h6>
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Eligible Status</th>
                        <td>
                            @foreach($mapping->employee_status as $status)
                                <span class="badge border text-dark">{{ $status }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>Designations</th>
                        <td>
                            {{-- Assuming $designationMap was passed from Controller --}}
                            @if(isset($designationMap))
                                @foreach($mapping->designations as $id)
                                    <span class="badge bg-soft-info text-info">{{ $designationMap[$id] ?? 'Unknown' }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Loading designations...</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-12"><hr class="my-2 opacity-25"></div>

            <!-- Policy Details -->
            <div class="col-md-6 mt-4">
                <h6 class="text-muted text-uppercase fw-bold mb-3">Accrual & Nature</h6>
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Accrual Policy</th>
                        <td>{{ $mapping->accrual_value }} leaves credited {{ $mapping->accrual_frequency }}</td>
                    </tr>
                    <tr>
                        <th>Leave Nature</th>
                        <td>
                            <span class="fw-bold {{ $mapping->leave_nature == 'Paid' ? 'text-success' : 'text-danger' }}">
                                {{ $mapping->leave_nature }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Application Limits</th>
                        <td>Min: {{ $mapping->min_leave_per_application }} | Max: {{ $mapping->max_leave_per_application ?? 'No Limit' }}</td>
                    </tr>
                </table>
            </div>

            <!-- Carry Forward & Encashment -->
            <div class="col-md-6 mt-4">
                <h6 class="text-muted text-uppercase fw-bold mb-3">Financial Rules</h6>
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Carry Forward</th>
                        <td>
                            @if($mapping->carry_forward_allowed)
                                <span class="text-success">Allowed (Limit: {{ $mapping->carry_forward_limit }})</span>
                            @else
                                <span class="text-muted">Not Allowed</span>
                            @endif
                        </td>
                    </tr>
                    {{-- New: Encashment Details --}}
                    <tr>
                        <th>Encashment</th>
                        <td>
                            @if($mapping->encashment_allowed)
                                <span class="text-success fw-bold">Allowed</span><br>
                                <small class="text-muted">Trigger: {{ $mapping->encashment_trigger }}</small>
                            @else
                                <span class="text-muted">Not Allowed</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection