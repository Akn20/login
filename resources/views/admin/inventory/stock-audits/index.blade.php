@extends('layouts.admin')

@section('content')

<div class="page-header">
    <h5>Stock Audits</h5>
    <a href="{{ route('admin.inventory.stock-audits.create') }}"
       class="btn btn-primary">New Audit</a>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Item</th>
            <th>System Stock</th>
            <th>Physical Stock</th>
            <th>Difference</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($audits as $audit)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $audit->item->name }}</td>
            <td>{{ $audit->system_stock }}</td>
            <td>{{ $audit->physical_stock }}</td>
            <td>
                @if($audit->difference < 0)
                    <span class="text-danger">{{ $audit->difference }}</span>
                @else
                    <span class="text-success">+{{ $audit->difference }}</span>
                @endif
            </td>
            <td>{{ $audit->created_at->format('d-m-Y') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No audits found</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection