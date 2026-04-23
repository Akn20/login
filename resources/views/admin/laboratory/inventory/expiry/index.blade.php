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

            @foreach($items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->expiry_date }}</td>

                <td>
                    @if($item->expiry_date && now()->gt($item->expiry_date))
                        <span class="badge bg-danger">Expired</span>
                    @elseif($item->expiry_date && now()->diffInDays($item->expiry_date) <= 7)
                        <span class="badge bg-warning">Near Expiry</span>
                    @else
                        <span class="badge bg-success">Safe</span>
                    @endif
                </td>
            </tr>
            @endforeach

        </table>

    </div>
</div>

@endsection