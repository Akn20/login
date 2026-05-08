@extends('layouts.admin')

@section('content')

<h5>Expiry Tracking</h5>

<div class="card">
    <div class="card-body">

        <table class="table">
            <tr>
                <th>Item</th>
                <th>Expiry Date</th>
                <th>Status</th>
            </tr>

          @forelse($items as $item)

@php
    $expiry = $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date) : null;
@endphp

<tr class="{{ $expiry && $expiry->isPast() ? 'table-danger' : '' }}">
    
    <td>{{ $item->name }}</td>

    <td>
        {{ $expiry ? $expiry->format('d M Y') : '-' }}
    </td>

    <td>
        @if($expiry && $expiry->isPast())
            <span class="badge bg-danger">Expired</span>

        @elseif($expiry && now()->lte($expiry) && now()->diffInDays($expiry) <= 7)
            <span class="badge bg-warning text-dark">Near Expiry</span>

        @elseif($expiry)
            <span class="badge bg-success">Safe</span>

        @else
            <span class="badge bg-secondary">No Expiry</span>
        @endif
    </td>

</tr>

@empty
<tr>
    <td colspan="3" class="text-center text-muted">
        No expiry data found
    </td>
</tr>
@endforelse

        </table>

    </div>
</div>

@endsection