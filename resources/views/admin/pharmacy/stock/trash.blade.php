@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5>Deleted Stock</h5>
            </div>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.stock.index') }}" class="btn btn-neutral">
                Back
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="card">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Sl.No.</th>
                                <th>Medicine</th>
                                <th>Batch</th>
                                <th>Quantity</th>
                                <th>Expiry</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($batches as $index => $batch)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $batch->medicine->medicine_name ?? '-' }}</td>
                                    <td>{{ $batch->batch_number }}</td>
                                    <td>{{ $batch->quantity }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($batch->expiry_date)->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        @if(\Carbon\Carbon::parse($batch->expiry_date)->isPast())
                                            <span class="badge bg-soft-dark text-dark">
                                                Expired
                                            </span>
                                        @else
                                            <span class="badge bg-soft-success text-success">
                                                Active
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="hstack gap-2 justify-content-end">

                                            {{-- Restore --}}
                                            <a href="{{ route('admin.stock.restore', $batch->id) }}"
                                               class="avatar-text avatar-md action-icon action-restore">
                                                <i class="feather-refresh-ccw"></i>
                                            </a>

                                            {{-- Permanent Delete --}}
                                            <a href="{{ route('admin.stock.forceDelete', $batch->id) }}"
                                               class="avatar-text avatar-md action-icon action-delete"
                                               onclick="return confirm('This will permanently delete the stock. Continue?')">
                                                <i class="feather-trash"></i>
                                            </a>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">
                                        No deleted stock records found.
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

@endsection