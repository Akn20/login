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
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">
                No GRNs Found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

</div>
</div>

@endsection