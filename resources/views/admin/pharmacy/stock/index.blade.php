@extends('layouts.admin')

@section('content')
<div class="nxl-content">

    <!-- Success / Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Stock Management</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Pharmacy</li>
                <li class="breadcrumb-item">Stock</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.stock.low') }}" class="btn btn-warning">
                Low Stock
            </a>

            <a href="{{ route('admin.stock.trash') }}" class="btn btn-neutral">
                Deleted Records
            </a>

            <a href="{{ route('admin.stock.create') }}" class="btn btn-primary">
                Add Medicine
            </a>
        </div>
    </div>

    <!-- Main Content -->
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
                                        <th>Expiry</th>
                                        <th>Quantity</th>
                                        <th>MRP</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($batches as $index => $batch)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>

                                            <td>
                                                {{ $batch->medicine->medicine_name ?? '-' }}
                                            </td>

                                            <td>{{ $batch->batch_number }}</td>

                                            <td>
                                                {{ \Carbon\Carbon::parse($batch->expiry_date)->format('d-m-Y') }}
                                            </td>

                                            <td>
                                                {{ $batch->quantity }}

                                                @if($batch->quantity <= $batch->reorder_level)
                                                    <span class="badge bg-soft-danger text-danger">
                                                        Low Stock
                                                    </span>
                                                @endif
                                            </td>

                                            <td>₹ {{ number_format($batch->mrp, 2) }}</td>
                                            @php
                                                $exp = \Carbon\Carbon::parse($batch->expiry_date);
                                                $log = $batch->latestExpiryLog ?? null;

                                                if ($log) {
                                                    $status = $log->status;
                                                } else {
                                                    $status = $exp->isPast() ? 'EXPIRED' : 'ACTIVE';
                                                }
                                            @endphp

                                            <td>

                                            @if($status == 'COMPLETED')
                                            <span class="badge bg-soft-success text-success">Returned</span>

                                            @elseif($status == 'APPROVED')
                                            <span class="badge bg-soft-info text-info">Return Approved</span>

                                            @elseif($status == 'PENDING')
                                            <span class="badge bg-soft-warning text-warning">Return Pending</span>

                                            @elseif($status == 'EXPIRED')
                                            <span class="badge bg-soft-danger text-danger">Expired</span>

                                            @else
                                            <span class="badge bg-soft-success text-success">Active</span>
                                            @endif

                                            </td>

                                            <td class="text-end">
                                                <div class="hstack gap-2 justify-content-end">

                                                    <!-- View -->
                                                    <a href="{{ route('admin.stock.show', $batch->id) }}"
                                                       class="avatar-text avatar-md action-icon">
                                                        <i class="feather-eye"></i>
                                                    </a>

                                                    <!-- Edit -->
                                                    <a href="{{ route('admin.stock.edit', $batch->id) }}"
                                                       class="avatar-text avatar-md action-icon action-edit">
                                                        <i class="feather-edit"></i>
                                                    </a>

                                                    <!-- Delete -->
                                                    <form action="{{ route('admin.stock.delete', $batch->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Are you sure you want to delete this stock?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="avatar-text avatar-md action-icon action-delete">
                                                            <i class="feather-trash-2"></i>
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">
                                                No stock records found.
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