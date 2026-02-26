@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5>Low Stock Items</h5>
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
                                <th>Reorder Level</th>
                                <th>Expiry</th>
                                <th class="text-end">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($batches as $index => $batch)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $batch->medicine->medicine_name ?? '-' }}</td>
                                    <td>{{ $batch->batch_number }}</td>

                                    <td class="text-danger fw-bold">
                                        {{ $batch->quantity }}
                                    </td>

                                    <td>{{ $batch->reorder_level }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($batch->expiry_date)->format('d-m-Y') }}
                                    </td>

                                    <td class="text-end">
                                        <span class="badge bg-soft-danger text-danger">
                                            Low Stock
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">
                                        No low stock items.
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