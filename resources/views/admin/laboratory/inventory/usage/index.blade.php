@extends('layouts.admin')

@section('content')

<h5>Usage Logs</h5>

<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Quantity Used</th>
                        <th>Used By</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($logs as $log)
                        <tr>

                            <!-- SL NO -->
                            <td>{{ $loop->iteration }}</td>

                            <!-- ITEM -->
                            <td>{{ optional($log->item)->name ?? 'N/A' }}</td>

                            <!-- QUANTITY -->
                            <td>
                                <span class="badge bg-info">
                                    {{ $log->quantity_used }}
                                </span>
                            </td>

                            <!-- USER -->
                           <td>{{ optional($log->user)->name ?? 'N/A' }}</td>

                            <!-- DATE -->
                            <td>
                                {{ $log->used_at ? \Carbon\Carbon::parse($log->used_at)->format('d M Y, h:i A') : 'N/A' }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">
                                No usage logs found
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection