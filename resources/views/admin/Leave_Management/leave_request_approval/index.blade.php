@extends('layouts.admin')

@section('page-title', 'Leave Approvals | ' . config('app.name'))
@section('title', 'Leave Approvals')

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-title">
            <h5 class="m-b-10 mb-1">
                <i class="feather-check-circle me-2"></i>Leave Approvals
            </h5>

            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">Leave Approvals</li>
            </ul>
        </div>

        <div class="d-flex gap-2 align-items-center">

            <form method="GET" action="{{ route('admin.leave-approvals.index') }}" class="d-flex">

                <select name="status" class="form-control form-control-sm me-2">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>

                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search Employee"
                    value="{{ request('search') }}">

                <button class="btn btn-light-brand btn-sm">
                    <i class="feather-search"></i>
                </button>

            </form>

        </div>
    </div>


    <div class="card stretch stretch-full">
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Duration</th>
                            <th>No of Days</th>
                            <th>Applied Date</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @if($leaveRequests->count())

                            @foreach ($leaveRequests as $index => $leave)

                                <tr>

                                    <td>{{  $index }}</td>

                                    <td>{{ $leave['employee'] }}</td>

                                    <td>{{ $leave['leave_type'] }}</td>

                                    <td>
                                        {{ $leave['from_date'] }} → {{ $leave['to_date'] }}
                                    </td>

                                    <td>{{ $leave['total_days'] }}</td>

                                    <td>{{ \Carbon\Carbon::parse($leave['created_at'])->format('d-m-Y') }}</td>

                                    <td>
                                        @if ($leave['status'] === 'pending')
                                            <span class="badge bg-soft-warning text-warning">Pending</span>
                                        @elseif ($leave['status'] === 'approved')
                                            <span class="badge bg-soft-success text-success">Approved</span>
                                        @else
                                            <span class="badge bg-soft-danger text-danger">Rejected</span>
                                        @endif
                                    </td>

                                    <td class="text-end">

                                        <div class="d-flex justify-content-end gap-2">
                                            <form method="get" action="{{ route('admin.leave-approvals.show', $leave['id']) }}">
                                                @csrf
                                            <button class="btn btn-outline-primary btn-icon rounded-circle">
                                                <i class="feather-eye"></i>
                                            </button>
                                            </form>

                                            @if ($leave['status'] === 'pending')

                                                <button class="btn btn-outline-success btn-icon rounded-circle">
                                                    <i class="feather-check"></i>
                                                </button>

                                                <button class="btn btn-outline-danger btn-icon rounded-circle">
                                                    <i class="feather-x"></i>
                                                </button>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @endforeach
                        @else

                            <tr>
                                <td colspan="8" class="text-center">
                                    No Leave Requests Found
                                </td>
                            </tr>

                        @endif

                    </tbody>

                </table>

            </div>



        </div>
    </div>

@endsection