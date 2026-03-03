@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5>Stock Transfers</h5>
    </div>
    <div class="page-header-right">
        <a href="{{ route('admin.inventory.stock-transfers.create') }}"
           class="btn btn-primary">
            Create Transfer
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

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Transfer Number</th>
            <th>Transfer Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transfers as $transfer)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $transfer->transfer_number }}</td>
            <td>{{ \Carbon\Carbon::parse($transfer->transfer_date)->format('d-m-Y') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">No Transfers Found</td>
        </tr>
        @endforelse
    </tbody>
</table>

</div>
</div>

@endsection