@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">Insurance Management</h4>
        <a href="{{ route('admin.insurance.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle"></i> Add Insurance
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">

                <!-- Patient Name -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Patient Name</label>
                    <input type="text" name="patient_name"
                        value="{{ request('patient_name') }}"
                        class="form-control shadow-sm"
                        placeholder="Search Patient">
                </div>

                <!-- Policy -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Policy Number</label>
                    <input type="text" name="policy_number"
                        value="{{ request('policy_number') }}"
                        class="form-control shadow-sm">
                </div>

                <!-- Provider -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Provider</label>
                    <input type="text" name="provider_name"
                        value="{{ request('provider_name') }}"
                        class="form-control shadow-sm">
                </div>

                <!-- Status -->
                <div class="col-md-2">
                    <label class="form-label small text-muted">Status</label>
                    <select name="status" class="form-select shadow-sm">
                        <option value="">All</option>
                        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                        <option value="claimed" {{ request('status')=='claimed'?'selected':'' }}>Claimed</option>
                        <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
                    </select>
                </div>

                <!-- Search -->
                <div class="col-md-1 d-flex align-items-end">
                    <button class="btn btn-primary w-100 shadow-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

            </div>

            <div class="mt-2 text-end">
                <a href="{{ route('admin.insurance.index') }}"
                   class="btn btn-outline-secondary btn-sm px-3 py-1">
                    Reset
                </a>
            </div>
        </div>
    </form>

    <!-- Success -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table align-middle mb-0">

                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="ps-3">Patient</th>
                            <th>Provider</th>
                            <th>Policy</th>
                            <th>Validity</th>
                            <th>Status</th>
                            <th class="text-center pe-3">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($insurances as $insurance)
                        <tr>

                            <!-- Patient Name -->
                            <td class="ps-3 fw-semibold">
                                {{ $insurance->patient->first_name ?? '' }}
                                {{ $insurance->patient->last_name ?? '' }}
                                <br>
                                <small class="text-muted">
                                    {{ $insurance->patient->patient_code ?? '' }}
                                </small>
                            </td>

                            <td>{{ $insurance->provider_name }}</td>

                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ $insurance->policy_number }}
                                </span>
                            </td>

                            <td>
                                <small class="text-muted">
                                    {{ $insurance->valid_from }}
                                </small><br>
                                <small>to</small><br>
                                <small class="text-muted">
                                    {{ $insurance->valid_to }}
                                </small>
                            </td>

                            <td>
                                @if($insurance->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>

                                @elseif($insurance->status == 'verified' || $insurance->status == 'claimed')
                                    <span class="badge bg-success">Claimed</span>

                                @elseif($insurance->status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>

                                @endif
                            </td>

                            <td class="text-center pe-3">

                                <div class="d-flex justify-content-center gap-3">

                                    <a href="{{ route('admin.insurance.show',$insurance->id) }}" class="text-info">
                                        <i class="bi bi-eye fs-5"></i>
                                    </a>

                                    @if($insurance->status == 'pending')
                                    <a href="{{ route('admin.insurance.edit',$insurance->id) }}" class="text-primary">
                                        <i class="bi bi-pencil fs-5"></i>
                                    </a>
                                    @endif

                                </div>

                            </td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No insurance records found
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection