@extends('layouts.admin')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0">Inventory Alerts</h5>
        <small class="text-muted">Low stock and expiry alerts</small>
    </div>
</div>

<div class="card">
    <div class="card-body">

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Threshold</th>
                        <th>Expiry</th>
                        <th>Alert Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    @forelse($alerts as $alert)

                        @php
                            $item = $alert->item;
                        @endphp

                        <tr class="{{ $alert->status == 'Pending' ? 'table-danger' : '' }}">

                            <!-- SL NO -->
                            <td>{{ $loop->iteration }}</td>

                            <!-- ITEM -->
                            <td>{{ $item->name ?? 'N/A' }}</td>

                            <!-- CATEGORY -->
                            <td>{{ $item->category ?? '-' }}</td>

                            <!-- QUANTITY -->
                            <td>{{ $item->quantity ?? '-' }}</td>

                            <!-- THRESHOLD -->
                            <td>{{ $item->threshold ?? '-' }}</td>

                            <!-- EXPIRY -->
                            <td>
                                {{ $item->expiry_date 
                                    ? \Carbon\Carbon::parse($item->expiry_date)->format('d M Y') 
                                    : '-' 
                                }}
                            </td>

                            <!-- ALERT TYPE -->
                            <td>
                                @if($alert->alert_type == 'low_stock')
                                    <span class="badge bg-danger">Low Stock</span>
                                @elseif($alert->alert_type == 'expiry')
                                    <span class="badge bg-warning">Expiry</span>
                                @else
                                    <span class="badge bg-secondary">{{ $alert->alert_type }}</span>
                                @endif
                            </td>

                            <!-- STATUS -->
                            <td>
                                @if($alert->status == 'Pending')
                                    <span class="badge bg-danger">Pending</span>
                                @else
                                    <span class="badge bg-success">Resolved</span>
                                @endif
                            </td>

                            <!-- ACTION -->
                            <td>
                                @if($alert->status == 'Pending')
                                    <form action="{{ route('admin.laboratory.inventory.alerts.resolve', $alert->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-success">
                                            RESOLVE
                                        </button>
                                    </form>
                                @else
                                    <span class="text-success fw-bold">Resolved</span>
                                @endif
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                No inventory alerts found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection