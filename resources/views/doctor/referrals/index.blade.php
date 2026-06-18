@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Referral Management
            </h3>

            <p class="text-muted mb-0">
                Manage patient referrals and specialist consultations
            </p>

        </div>
        <div class="d-flex align-items-center gap-2 mb-4"
            style="max-width: 300px;">
    
            <a href="{{ route('doctor.referrals.create') }}"
            class="btn btn-primary">

                <i class="fa fa-plus me-1"></i>
                Create Referral

            </a>

            <a href="{{ route('doctor.referrals.trash') }}"
                class="btn btn-danger">

                <i class="fa fa-trash me-1"></i>
                Deleted Records

            </a>
        </div>

    </div>

    <!-- Success Message -->
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>

        </div>

    @endif

    <!-- Filters Section -->
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('doctor.referrals.index') }}">

                <div class="row g-3">

                    <!-- Search -->
                    <div class="col-md-3">

                        <label class="form-label">
                            Search Patient
                        </label>

                        <input type="text"
                               class="form-control"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Enter patient name">

                    </div>

                    <!-- Status -->
                    <div class="col-md-2">

                        <label class="form-label">
                            Status
                        </label>

                        <select class="form-select"
                                name="status">

                            <option value="">
                                All
                            </option>

                            <option value="Pending"
                                {{ request('status') == 'Pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="Accepted"
                                {{ request('status') == 'Accepted' ? 'selected' : '' }}>
                                Accepted
                            </option>

                            <option value="In Progress"
                                {{ request('status') == 'In Progress' ? 'selected' : '' }}>
                                In Progress
                            </option>                       

                            <option value="Completed"
                                {{ request('status') == 'Completed' ? 'selected' : '' }}>
                                Completed
                            </option>

                            <option value="Rejected"
                                {{ request('status') == 'Rejected' ? 'selected' : '' }}>
                                Rejected
                            </option>

                        </select>

                    </div>

                    <!-- Priority -->
                    <div class="col-md-2">

                        <label class="form-label">
                            Priority
                        </label>

                        <select class="form-select"
                                name="priority">

                            <option value="">
                                All
                            </option>

                            <option value="Normal"
                                {{ request('priority') == 'Normal' ? 'selected' : '' }}>
                                Normal
                            </option>

                            <option value="Urgent"
                                {{ request('priority') == 'Urgent' ? 'selected' : '' }}>
                                Urgent
                            </option>

                            <option value="Emergency"
                                {{ request('priority') == 'Emergency' ? 'selected' : '' }}>
                                Emergency
                            </option>

                        </select>

                    </div>

                    <!-- Date -->
                    <div class="col-md-3">

                        <label class="form-label">
                            Referral Date
                        </label>

                        <input type="date"
                               class="form-control"
                               name="date"
                               value="{{ request('date') }}">

                    </div>

                    <!-- Filter Button -->
                    <div class="col-md-2 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-success w-100">

                            <i class="fa fa-search me-1"></i>
                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Referral Table -->
    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Patient Name</th>

                            <th>Referred Doctor</th>

                            <th>Department</th>

                            <th>Referral Type</th>

                            <th>Priority</th>

                            <th>Status</th>

                            <th>Referral Date</th>

                            <th width="180">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($referrals as $key => $referral)

                            <tr>

                                <td>
                                    {{ $referrals->firstItem() + $key }}
                                </td>

                                <!-- Patient -->
                                <td>

                                    <strong>
                                        {{ $referral->patient->first_name ?? '' }}
                                        {{ $referral->patient->last_name ?? '' }}
                                    </strong>

                                </td>

                                <!-- Doctor -->
                                <td>

                                    {{ $referral->referredDoctor->name ?? '-' }}
                                </td>

                                <!-- Department -->
                                <td>

                                    {{ $referral->department->department_name ?? '-' }}
                                </td>

                                <!-- Referral Type -->
                                <td>

                                    <span class="badge bg-info">

                                        {{ $referral->referral_type }}

                                    </span>

                                </td>

                                <!-- Priority -->
                                <td>

                                    @if($referral->priority == 'Emergency')

                                        <span class="badge bg-danger">
                                            Emergency
                                        </span>

                                    @elseif($referral->priority == 'Urgent')

                                        <span class="badge bg-warning text-dark">
                                            Urgent
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Normal
                                        </span>

                                    @endif

                                </td>

                                <!-- Status -->
                                <td>

                                    @if($referral->status == 'Pending')

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @elseif($referral->status == 'Accepted')

                                        <span class="badge bg-primary">
                                            Accepted
                                        </span>

                                    @elseif($referral->status == 'Completed')

                                        <span class="badge bg-success">
                                            Completed
                                        </span>

                                    @elseif($referral->status == 'Rejected')

                                        <span class="badge bg-danger">
                                            Rejected
                                        </span>

                                    @else

                                        <span class="badge bg-info">
                                            {{ $referral->status }}
                                        </span>

                                    @endif

                                </td>

                                <!-- Date -->
                                <td>

                                    {{ $referral->created_at->format('d-M-Y') }}

                                </td>

                                <!-- Actions -->
                                <td>

                                    <div class="d-flex gap-2">

                                        <!-- View -->
                                        <a href="{{ route('doctor.referrals.view', $referral->id) }}"
                                           class="btn btn-sm btn-info text-white">

                                            <i class="fa fa-eye"></i>

                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('doctor.referrals.edit', $referral->id) }}"
                                           class="btn btn-sm btn-warning text-white">

                                            <i class="fa fa-edit"></i>

                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('doctor.referrals.destroy', $referral->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure to delete this referral?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger">

                                                <i class="fa fa-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9"
                                    class="text-center py-5 text-muted">

                                    No Referrals Found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- Pagination -->
            <div class="mt-3">

                {{ $referrals->links() }}

            </div>

        </div>

    </div>

</div>

@endsection