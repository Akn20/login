@extends('layouts.admin')

@section('content')

<div class="container">
<div class="card">

<div class="card-header d-flex justify-content-between">
    <h4>Billing List</h4>
    <a href="{{ route('admin.billing.create') }}" class="btn btn-primary">+ Add Billing</a>
</div>

<div class="card-body">

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Receipt No</th>
            <th>Patient</th>
            <th>Amount</th>
            <th>Mode</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($billings as $bill)
        <tr>
            <td>{{ $bill->receipt_no }}</td>
            <td>{{ $bill->patient->first_name ?? '' }} {{ $bill->patient->last_name ?? '' }}</td>
            <td>₹ {{ $bill->amount }}</td>
            <td>{{ $bill->payment_mode }}</td>
            <td>{{ $bill->created_at->format('d-m-Y') }}</td>
            <td class="d-flex gap-2">

    {{-- View --}}
    <a href="{{ route('admin.billing.show', $bill->id) }}" title="View">
        <i class="feather-eye text-primary" style="cursor:pointer;"></i>
    </a>

    {{-- Download PDF --}}
    <a href="{{ route('admin.billing.receipt', $bill->id) }}" title="Download Receipt">
        <i class="feather-download text-success" style="cursor:pointer;"></i>
    </a>

</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $billings->links() }}

</div>
</div>
</div>

@endsection