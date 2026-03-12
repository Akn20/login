@extends('layouts.admin')

@section('page-title', 'Approved Leave History | ' . config('app.name'))
@section('title', 'Approved Leave History')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary"><i class="fas fa-check-circle me-2"></i>All Leave History</h5>
                        <a href="{{ route('hr.leave-approvals.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Pending
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('hr.leave-approvals.approved') }}" method="GET" class="mb-4">
                            <div class="d-flex justify-content-between gap-2">
                                <div style="min-width: 150px;">
                                    <select name="status" class="form-select" onchange="this.form.submit()">
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                            Approved</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                            Rejected</option>
                                    </select>
                                </div>

                                <div style="min-width: 250px;">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Search Name or ID..." value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Employee</th>
                                        <th>Leave Type</th>
                                        <th>Duration</th>
                                        <th>Days</th>
                                        <th>Approved Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($approvedLeaves as $leave)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-light rounded-circle p-2 me-2">
                                                        <i class="fas fa-user text-secondary"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $leave->staff->name ?? 'Unknown' }}</div>
                                                        <small class="text-muted">{{ $leave->staff->employee_id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info-soft text-info border">
                                                    {{ $leave->leaveType->display_name ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="small">
                                                    <strong>From:</strong>
                                                    {{ \Carbon\Carbon::parse($leave->from_date)->format('d M, Y') }}<br>
                                                    <strong>To:</strong>
                                                    {{ \Carbon\Carbon::parse($leave->to_date)->format('d M, Y') }}
                                                </div>
                                            </td>
                                            <td><span class="fw-bold text-primary">{{ $leave->leave_days }}</span></td>
                                            <td>{{ $leave->updated_at->format('d M, Y H:i') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('hr.leave-approvals.show', $leave->id) }}"
                                                    class="btn btn-sm btn-light border">
                                                    <i class="fas fa-eye me-1"></i> Details
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <img src="https://illustrations.popsy.co/gray/no-data.svg" style="width: 150px"
                                                    alt="No data">
                                                <p class="mt-3 text-muted">No approved leave records found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $approvedLeaves->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-info-soft {
            background-color: #e0f7fa;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transition: 0.2s;
        }
    </style>
@endsection

