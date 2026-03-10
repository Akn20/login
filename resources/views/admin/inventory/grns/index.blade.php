@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5>GRN List</h5>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
<div class="card-body table-responsive">

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>GRN Number</th>
            <th>PO Number</th>
            <th>Received Date</th>
            <th>Total</th>
            <th width="180">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($grns as $grn)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $grn->grn_number }}</td>
            <td>{{ $grn->purchaseOrder->po_number }}</td>
            <td>{{ \Carbon\Carbon::parse($grn->received_date)->format('d-m-Y') }}</td>
            <td>₹ {{ number_format($grn->total_amount, 2) }}</td>
            <td>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('admin.inventory.grns.show', $grn->id) }}"
                        class="btn btn-outline-secondary btn-icon rounded-circle"
                        title="View">
                        <i class="feather feather-eye"></i>
                    </a>

                    <a href="{{ route('admin.inventory.grns.edit', $grn->id) }}"
                        class="btn btn-outline-secondary btn-icon rounded-circle"
                        title="Edit">
                        <i class="feather feather-edit-2"></i>
                    </a>

                    <form action="{{ route('admin.inventory.grns.destroy', $grn->id) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Delete this GRN?')"
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
            <td colspan="6" class="text-center">
                No GRNs Found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

</div>
</div>

@endsection