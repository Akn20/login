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
                <h5>Deleted Expiry Records</h5>
            </div>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.expiry.index') }}" class="btn btn-neutral">Back</a>
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
                                <th>Expiry Date</th>
                                <th>Quantity</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                             @forelse($logs as $index => $log)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $log->batch->medicine->medicine_name ?? '-' }}</td>
                                    <td>{{ $log->batch->batch_number ?? '-' }}</td>
                                    <td>{{ $log->status }}</td>
                                    <td>{{ $log->deleted_at }}</td>

                                    <td class="text-end">
                                        <div class="hstack gap-2 justify-content-end">
                                            <a href="{{ route('admin.expiry.restore', $batch->id) }}"
                                               class="avatar-text avatar-md action-icon action-restore">
                                                <i class="feather-refresh-ccw"></i>
                                            </a>

                                            <a href="{{ route('admin.expiry.forceDelete', $batch->id) }}"
                                               class="avatar-text avatar-md action-icon action-delete"
                                               onclick="return confirm('This will permanently delete the record. Continue?');">
                                                <i class="feather-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">
                                        No deleted records found.
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