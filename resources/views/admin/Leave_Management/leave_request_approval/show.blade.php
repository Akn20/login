@extends('layouts.admin')

@section('title', 'Leave Request Details')

@section('content')

    <div class="card">

        <div class="card-body">

            <h5 class="mb-4">Leave Details</h5>

            <table class="table">

                <tr>
                    <th>Employee</th>
                    <td>{{ $leave->employee->name }}</td>
                </tr>

                <tr>
                    <th>Leave Type</th>
                    <td>{{ $leave->leaveType->display_name }}</td>
                </tr>

                <tr>
                    <th>From</th>
                    <td>{{ $leave->from_date }}</td>
                </tr>

                <tr>
                    <th>To</th>
                    <td>{{ $leave->to_date }}</td>
                </tr>

                <tr>
                    <th>Total Days</th>
                    <td>{{ $leave->total_days }}</td>
                </tr>

                <tr>
                    <th>Reason</th>
                    <td>{{ $leave->purpose }}</td>
                </tr>

            </table>

            @if($leave->status == 'pending')

                <form method="POST" action="{{ route('admin.leave-approvals.approve', $leave->id) }}">

                    @csrf

                    <div class="mb-3">

                        <label>Remarks</label>

                        <textarea name="remarks" class="form-control"></textarea>

                    </div>

                    <button class="btn btn-success">
                        Approve
                    </button>

                </form>


                <form method="POST" action="{{ route('admin.leave-approvals.reject', $leave->id) }}" class="mt-2">

                    @csrf

                    <button class="btn btn-danger">
                        Reject
                    </button>

                </form>

            @endif

        </div>

    </div>

@endsection