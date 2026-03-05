@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5>Purchase Orders</h5>
    </div>

    <div class="page-header-right">
        <a href="{{ route('admin.inventory.purchase-orders.create') }}" 
           class="btn btn-primary">
            + Create Purchase Order
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
<div class="card-body table-responsive">

<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>PO Number</th>
            <th>Vendor</th>
            <th>Order Date</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th width="180">Actions</th>
        </tr>
    </thead>
    <tbody>

        @forelse($purchaseOrders as $po)
        <tr>
            <td>{{ $loop->iteration }}</td>

            <td>{{ $po->po_number }}</td>

            <td>{{ $po->inventoryVendor->name ?? '-' }}</td>

            <td>{{ \Carbon\Carbon::parse($po->order_date)->format('d-m-Y') }}</td>

            <td>₹ {{ number_format($po->total_amount, 2) }}</td>

            <td>
                @if($po->status == 'draft')
                    <span class="badge bg-secondary">Draft</span>
                @elseif($po->status == 'approved')
                    <span class="badge bg-info">Approved</span>
                @elseif($po->status == 'ordered')
                    <span class="badge bg-primary">Ordered</span>
                @elseif($po->status == 'completed')
                    <span class="badge bg-success">Completed</span>
                @elseif($po->status == 'cancelled')
                    <span class="badge bg-danger">Cancelled</span>
                @endif
            </td>

            <td class="text-end">
                <div class="d-flex justify-content-end gap-2 align-items-center">

                    <!-- View -->
                    <a href="{{ route('admin.inventory.purchase-orders.show', $po->id) }}"
                    class="btn btn-outline-secondary btn-icon rounded-circle"
                    title="View">
                        <i class="feather feather-eye"></i>
                    </a>

                    @if($po->status == 'draft')
                    <!-- Edit -->
                    <a href="{{ route('admin.inventory.purchase-orders.edit', $po->id) }}"
                    class="btn btn-outline-secondary btn-icon rounded-circle"
                    title="Edit">
                        <i class="feather feather-edit-2"></i>
                    </a>
                    @endif

                    <!-- Delete -->
                    <form action="{{ route('admin.inventory.purchase-orders.destroy', $po->id) }}"
                        method="POST"
                        onsubmit="return confirm('Delete this PO?')"
                        class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="btn btn-outline-secondary btn-icon rounded-circle"
                            title="Delete">
                            <i class="feather feather-trash-2"></i>
                        </button>
                    </form>

                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">
                No Purchase Orders Found
            </td>
        </tr>
        @endforelse

    </tbody>
</table>

</div>
</div>

<div class="mt-3">
    {{ $purchaseOrders->links() }}
</div>

@endsection