@extends('layouts.admin')

@section('page-title', 'Refund Details')

@section('content')

<div class="page-header mb-4">

    <div class="page-header-left">

        <h5>Refund Details</h5>

    </div>

    <div class="page-header-right text-end">

        <a href="{{ route('admin.refunds.index') }}"
           class="btn btn-secondary">

            Back

        </a>

    </div>

</div>

{{-- SUCCESS --}}
@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<div class="row">

    {{-- LEFT SECTION --}}
    <div class="col-md-8">

        {{-- REFUND DETAILS --}}
        <div class="card mb-4">

            <div class="card-header">

                <h6 class="mb-0">

                    Refund Information

                </h6>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <strong>Refund No:</strong><br>

                        {{ $refund->refund_no }}

                    </div>

                    <div class="col-md-6 mb-3">

                        <strong>Status:</strong><br>

                        @if($refund->status == 'Pending')

                            <span class="badge bg-warning">
                                Pending
                            </span>

                        @elseif($refund->status == 'Approved')

                            <span class="badge bg-primary">
                                Approved
                            </span>

                        @elseif($refund->status == 'Processed')

                            <span class="badge bg-success">
                                Processed
                            </span>

                        @elseif($refund->status == 'Rejected')

                            <span class="badge bg-danger">
                                Rejected
                            </span>

                        @endif

                    </div>

                    <div class="col-md-6 mb-3">

                        <strong>Patient:</strong><br>

                        {{ $refund->patient->first_name ?? '' }}
                        {{ $refund->patient->last_name ?? '' }}

                    </div>

                    <div class="col-md-6 mb-3">

                        <strong>Patient Code:</strong><br>

                        {{ $refund->patient->patient_code ?? '' }}

                    </div>

                    <div class="col-md-6 mb-3">

                        <strong>Refund Type:</strong><br>

                        {{ $refund->refund_type }}

                    </div>

                    <div class="col-md-6 mb-3">

                        <strong>Refund Date:</strong><br>

                        {{ $refund->refund_date->format('d-m-Y') }}

                    </div>

                    <div class="col-md-6 mb-3">

                        <strong>Refund Amount:</strong><br>

                        ₹ {{ number_format($refund->refund_amount, 2) }}

                    </div>

                    <div class="col-md-6 mb-3">

                        <strong>Bill Type:</strong><br>

                        {{ $refund->bill_type ?? '-' }}

                    </div>

                    <div class="col-md-12 mb-3">

                        <strong>Refund Reason:</strong><br>

                        {{ $refund->refund_reason }}

                    </div>

                    <div class="col-md-12 mb-3">

                        <strong>Remarks:</strong><br>

                        {{ $refund->remarks ?? '-' }}

                    </div>

                    {{-- DOCUMENT --}}
                    @if($refund->document)

                    <div class="col-md-12 mb-3">

                        <strong>Supporting Document:</strong><br>

                        <a href="{{ asset('storage/' . $refund->document) }}"
                           target="_blank"
                           class="btn btn-sm btn-info">

                            View Document

                        </a>

                    </div>

                    @endif

                </div>

            </div>

        </div>

        {{-- APPROVAL HISTORY --}}
        <div class="card mb-4">

            <div class="card-header">

                <h6 class="mb-0">

                    Approval History

                </h6>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>Approver</th>

                                <th>Status</th>

                                <th>Remarks</th>

                                <th>Time</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($refund->approvalLogs as $log)

                            <tr>

                                <td>

                                    {{ $log->approver->name ?? '-' }}

                                </td>

                                <td>

                                    {{ $log->approval_status }}

                                </td>

                                <td>

                                    {{ $log->remarks ?? '-' }}

                                </td>

                                <td>

                                    {{ $log->action_time->format('d-m-Y h:i A') }}

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center">

                                    No Approval Logs

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- AUDIT LOG --}}
        <div class="card">

            <div class="card-header">

                <h6 class="mb-0">

                    Audit Timeline

                </h6>

            </div>

            <div class="card-body">

                @forelse($refund->auditLogs as $log)

                <div class="border-bottom pb-3 mb-3">

                    <strong>

                        {{ $log->action_type }}

                    </strong>

                    <br>

                    <small class="text-muted">

                        By:
                        {{ $log->performedBy->name ?? '-' }}

                        |

                        {{ $log->action_time->format('d-m-Y h:i A') }}

                    </small>

                    <p class="mb-0 mt-2">

                        {{ $log->action_details }}

                    </p>

                </div>

                @empty

                <p>No Audit Logs</p>

                @endforelse

            </div>

        </div>

    </div>

    {{-- RIGHT SECTION --}}
    <div class="col-md-4">

        {{-- APPROVAL ACTIONS --}}
        @if($refund->status == 'Pending')

        <div class="card mb-4">

            <div class="card-header">

                <h6 class="mb-0">

                    Approval Actions

                </h6>

            </div>

            <div class="card-body">

                {{-- APPROVE --}}
                <form method="POST"
                      action="{{ route('admin.refunds.approve', $refund->id) }}"
                      class="mb-3">

                    @csrf

                    <div class="mb-3">

                        <textarea name="remarks"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Approval Remarks"></textarea>

                    </div>

                    <button type="submit"
                            class="btn btn-success w-100">

                        Approve Refund

                    </button>

                </form>

                {{-- REJECT --}}
                <form method="POST"
                      action="{{ route('admin.refunds.reject', $refund->id) }}">

                    @csrf

                    <div class="mb-3">

                        <textarea name="remarks"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Rejection Reason"></textarea>

                    </div>

                    <button type="submit"
                            class="btn btn-danger w-100">

                        Reject Refund

                    </button>

                </form>

            </div>

        </div>

        @endif

        {{-- PROCESS PAYMENT --}}
        @if($refund->status == 'Approved')

        <div class="card mb-4">

            <div class="card-header">

                <h6 class="mb-0">

                    Process Refund Payment

                </h6>

            </div>

            <div class="card-body">

                <form method="POST"
                      action="{{ route('admin.refunds.process-payment', $refund->id) }}">

                    @csrf

                    {{-- PAYMENT MODE --}}
                    <div class="mb-3">

                        <label class="form-label">

                            Refund Mode

                        </label>

                        <select name="refund_mode"
                                class="form-control"
                                required>

                            <option value="">
                                Select Mode
                            </option>

                            <option value="Cash">
                                Cash
                            </option>

                            <option value="UPI">
                                UPI
                            </option>

                            <option value="Card">
                                Card
                            </option>

                            <option value="Bank Transfer">
                                Bank Transfer
                            </option>

                            <option value="Insurance Adjustment">
                                Insurance Adjustment
                            </option>

                        </select>

                    </div>

                    {{-- TRANSACTION --}}
                    <div class="mb-3">

                        <label class="form-label">

                            Transaction No

                        </label>

                        <input type="text"
                               name="transaction_no"
                               class="form-control">

                    </div>

                    <button type="submit"
                            class="btn btn-primary w-100">

                        Process Refund

                    </button>

                </form>

            </div>

        </div>

        @endif

        {{-- PAYMENT DETAILS --}}
        @if($refund->status == 'Processed')

        <div class="card mb-4">

            <div class="card-header">

                <h6 class="mb-0">

                    Payment Details

                </h6>

            </div>

            <div class="card-body">

                <p>

                    <strong>Refund Mode:</strong><br>

                    {{ $refund->refund_mode }}

                </p>

                <p>

                    <strong>Transaction No:</strong><br>

                    {{ $refund->transaction_no ?? '-' }}

                </p>

                <a href="{{ route('admin.refunds.receipt', $refund->id) }}"
                   class="btn btn-success w-100"
                   target="_blank">

                    Print Receipt

                </a>

            </div>

        </div>

        @endif

    </div>

</div>

@endsection