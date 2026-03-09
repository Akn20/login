@extends('layouts.admin')

@section('content')
<div class="nxl-content">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Expiry & Return Management</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Pharmacy</li>
                <li class="breadcrumb-item">Expiry</li>
            </ul>
        </div>

        
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card stretch stretch-full">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Medicine</th>
                                        <th>Batch</th>
                                        <th>Expiry Date</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($batches as $index => $batch)
                                        @php
                                            $exp = \Carbon\Carbon::parse($batch->expiry_date);
                                            $log = $batch->latestExpiryLog ?? null;

                                            if ($log) {
                                                $status = $log->status;
                                            } else {
                                                $status = $exp->isPast() ? 'EXPIRED' : 'EXPIRING';
                                            }
                                        @endphp

                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $batch->medicine->medicine_name ?? '-' }}</td>
                                            <td>{{ $batch->batch_number }}</td>
                                            <td>{{ \Carbon\Carbon::parse($batch->expiry_date)->format('d-m-Y') }}</td>
                                            <td>{{ $batch->quantity }}</td>



                                            <td>
                                                @switch($status)
                                                    @case('EXPIRING')
                                                        <span class="badge bg-soft-warning text-warning">Expiring</span>
                                                        @break

                                                    @case('EXPIRED')
                                                        <span class="badge bg-soft-danger text-danger">Expired</span>
                                                        @break

                                                    @case('PENDING')
                                                        <span class="badge bg-soft-warning text-warning">Pending</span>
                                                        @break

                                                    @case('APPROVED')
                                                        <span class="badge bg-soft-info text-info">Approved</span>
                                                        @break

                                                    @case('COMPLETED')
                                                        <span class="badge bg-soft-success text-success">Completed</span>
                                                        @break
                                                @endswitch
                                            </td>

                                            <td class="text-end">
                                                <div class="hstack gap-2 justify-content-end">

                                                    {{-- View --}}
                                                    <a href="{{ route('admin.expiry.show', $batch->id) }}"
                                                       class="avatar-text avatar-md action-icon">
                                                        <i class="feather-eye"></i>
                                                    </a>

                                                    {{-- Mark Expired --}}
                                                    <form action="{{ route('admin.expiry.markExpired', $batch->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Mark this batch as EXPIRED?');">
                                                        @csrf
                                                        <button type="submit"
                                                            class="avatar-text avatar-md action-icon"
                                                            {{ $status === 'EXPIRING' ? '' : 'disabled' }}>
                                                            <i class="feather-alert-triangle"></i>
                                                        </button>
                                                    </form>

                                                   {{-- Return to Vendor --}}
                                                    <form action="{{ route('admin.expiry.returnToVendor', $batch->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Create return request to vendor?');">
                                                        @csrf
                                                       <button type="submit"
                                                            class="avatar-text avatar-md action-icon"
                                                            {{ $status === 'EXPIRED' ? '' : 'disabled' }}>
                                                            <i class="feather-corner-up-left"></i>
                                                        </button>
                                                    </form>
                                                   
                                                    {{-- Approve --}}
                                                    <form action="{{ route('admin.expiry.approve', $batch->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Approve this return?');">
                                                        @csrf
                                                        <button type="submit"
                                                            class="avatar-text avatar-md action-icon"
                                                            {{ $status === 'PENDING' ? '' : 'disabled' }}>
                                                            <i class="feather-check-circle"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    {{-- Complete --}}
                                                    <form action="{{ route('admin.expiry.complete', $batch->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Complete this return?');">
                                                        @csrf
                                                        <button type="submit"
                                                            class="avatar-text avatar-md action-icon"
                                                            {{ $status === 'APPROVED' ? '' : 'disabled' }}>
                                                            <i class="feather-flag"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                No expiring/expired batches found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection