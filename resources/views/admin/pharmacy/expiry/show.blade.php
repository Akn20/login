@extends('layouts.admin')

@section('content')
<div class="nxl-content">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Expiry Details</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Pharmacy</li>
                <li class="breadcrumb-item">Expiry</li>
                <li class="breadcrumb-item">View</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.expiry.index') }}" class="btn btn-neutral">Back</a>
        </div>
    </div>
    @php
        $exp = \Carbon\Carbon::parse($batch->expiry_date);
        $log = $expiryLog ?? null;
        $status = $log->status ?? ($exp->isPast() ? 'EXPIRED' : 'EXPIRING');
    @endphp

    <div class="main-content">
        <div class="row">
            <div class="col-lg-6">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">Batch Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th style="width:160px;">Medicine</th>
                                <td>{{ $batch->medicine->medicine_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Batch</th>
                                <td>{{ $batch->batch_number }}</td>
                            </tr>
                            <tr>
                                <th>Expiry Date</th>
                                <td>{{ $exp->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th>Quantity</th>
                                <td>{{ $batch->quantity }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><strong>{{ $status }}</strong></td>
                            </tr>
                        </table>

                        <div class="d-flex gap-2 mt-3">

                            {{-- Mark Expired --}}
                            <form action="{{ route('admin.expiry.markExpired', $batch->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Mark this batch as EXPIRED?');">
                                @csrf
                                <button class="btn btn-warning" type="submit">Mark Expired</button>
                            </form>

                            {{-- Return to Vendor --}}
                            <form action="{{ route('admin.expiry.returnToVendor', $batch->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Create vendor return request?');">
                                @csrf
                                <button class="btn btn-danger" type="submit">Return to Vendor</button>
                            </form>
                            
                            {{-- Approve --}}
                            <form action="{{ route('admin.expiry.approve', $batch->id) }}" method="POST"
                                  onsubmit="return confirm('Approve return?');">
                                @csrf
                                <button class="btn btn-info" type="submit" {{ $status === 'PENDING' ? '' : 'disabled' }}>
                                    Approve
                                </button>
                            </form>

                            {{-- Complete --}}
                            <form action="{{ route('admin.expiry.complete', $batch->id) }}" method="POST"
                                  onsubmit="return confirm('Complete return?');">
                                @csrf
                                <button class="btn btn-success" type="submit" {{ $status === 'APPROVED' ? '' : 'disabled' }}>
                                    Complete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection