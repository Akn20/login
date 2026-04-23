@extends('layouts.admin')

@section('content')

<h5>Usage Logs</h5>

<div class="card">
    <div class="card-body">

        <table class="table">
            <tr>
                <th>Item</th>
                <th>Quantity Used</th>
                <th>Used By</th>
                <th>Date</th>
            </tr>

            @foreach($logs as $log)
            <tr>
                <td>{{ $log->item->name }}</td>
                <td>{{ $log->quantity_used }}</td>
                <td>{{ $log->used_by }}</td>
                <td>{{ $log->created_at }}</td>
            </tr>
            @endforeach

        </table>

    </div>
</div>

@endsection