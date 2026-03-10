@extends('layouts.admin')

@section('page-title', 'Leave Request Details | ' . config('app.name'))
@section('title', 'Leave Request Details')

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
                <i class="feather-file-text me-2"></i>Leave Request Details
            </h5>

            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('hr.leave-approvals.index') }}">
                        Leave Approvals
                    </a>
                </li>

                <li class="breadcrumb-item">
                    Details
                </li>
            </ul>
        </div>

    </div>



    <div class="card stretch stretch-full">

        <div class="card-body">

            <div class="row">
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Employee Name</label>
                    <p>{{ $leave->staff->name }}</p>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Leave Type</label>
                    <p>{{ $leave->leaveType->display_name }}</p>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">From Date</label>
                    <p>
                        {{ \Carbon\Carbon::parse($leave->from_date)->format('d-m-Y') }}
                    </p>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">To Date</label>
                    <p>
                        {{ \Carbon\Carbon::parse($leave->to_date)->format('d-m-Y') }}
                    </p>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">From Session</label>
                    <p>{{ ucfirst(str_replace('_', ' ', $leave->from_session)) }}</p>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">To Session</label>
                    <p>{{ ucfirst(str_replace('_', ' ', $leave->to_session)) }}</p>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Total Leave Days</label>
                    <p>{{ $leave->total_leave_days }}</p>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Applied Date</label>
                    <p>{{ $leave->created_at->format('d-m-Y') }}</p>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Balance Before</label>
                    <p>{{ $leave->balance_before }}</p>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Balance After</label>
                    <p>{{ $leave->balance_after }}</p>
                </div>


                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Purpose</label>
                    <p>{{ $leave->purpose }}</p>
                </div>


                @if($leave->attachment)

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Attachment</label>

                        <div>
                            <a href="{{ asset('storage/' . $leave->attachment) }}" target="_blank" class="btn btn-sm btn-light">
                                <i class="feather-paperclip"></i>
                                View Attachment
                            </a>
                        </div>

                    </div>

                @endif


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status</label>

                    <p>

                        @if($leave->status == 'pending')

                            <span class="badge bg-soft-warning text-warning">
                                Pending
                            </span>

                        @elseif($leave->status == 'approved')

                            <span class="badge bg-soft-success text-success">
                                Approved
                            </span>

                        @else

                            <span class="badge bg-soft-danger text-danger">
                                Rejected
                            </span>

                        @endif

                    </p>

                </div>


            </div>



            @if($leave->status == 'pending')

                <div class="mt-4 d-flex gap-2">

                    <form action="{{ route('hr.leave-approvals.approve', $leave->id) }}" method="POST">
                        @csrf

                        <button class="btn btn-success">
                            <i class="feather-check"></i> Approve
                        </button>

                    </form>


                    <form action="{{ route('hr.leave-approvals.reject', $leave->id) }}" method="POST">
                        @csrf

                        <button class="btn btn-danger">
                            <i class="feather-x"></i> Reject
                        </button>

                    </form>

                </div>

            @endif


        </div>

    </div>

@endsection