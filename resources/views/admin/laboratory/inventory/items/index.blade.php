@extends('layouts.admin')

@section('content')

 <div class="page-header mb-4">
    <div class="page-header-left">
        <h5 class="m-b-10">Inventory Management</h5>
    </div>

    <div class="page-header-right ms-auto d-flex gap-2 flex-wrap">

        <form method="GET" action="{{ route('admin.laboratory.inventory.items.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control form-control-sm me-2"
                placeholder="Search Item" value="{{ request('search') }}">
            <button class="btn btn-light-brand btn-sm">
                <i class="feather-search"></i>
            </button>
        </form>

        {{-- Add Item --}}
        <a href="{{ route('admin.laboratory.inventory.items.create') }}" class="btn btn-primary btn-sm">
            <i class="feather-plus me-1"></i> Add Item
        </a>

        {{-- Usage Logs --}}
        <a href="{{ route('admin.laboratory.inventory.usage.index') }}" class="btn btn-light-brand btn-sm">
            <i class="feather-activity me-1"></i> Usage Logs
        </a>

        {{-- Alerts --}}
        <a href="{{ route('admin.laboratory.inventory.alerts.index') }}" class="btn btn-danger btn-sm">
            <i class="feather-alert-triangle me-1"></i> Alerts
        </a>

        {{-- Track Expiry --}}
        <a href="{{ route('admin.laboratory.inventory.expiry.index') }}" class="btn btn-warning btn-sm">
            <i class="feather-clock me-1"></i> Expiry
        </a>

    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card stretch stretch-full">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                    <thead align="center">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Minimum Stock</th>
                            <th>Expiry Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody align="center">
                        @foreach($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->threshold }}</td>
                            <td>{{ $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('Y-m-d') : '-' }}</td>

                            <td>
                                @if($item->quantity < $item->threshold)
                                    <span class="badge bg-danger">Low</span>
                                @else
                                    <span class="badge bg-success">OK</span>
                                @endif
                            </td>

                            <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2 align-items-center">

                                            <!-- View -->
                                            <a href="{{ route('admin.laboratory.inventory.items.show', $item->id) }}"
                                                class="btn btn-outline-secondary btn-icon rounded-circle" title="View">
                                                <i class="feather feather-eye"></i>
                                            </a>


                                                <!-- Edit -->
                                                <a href="{{ route('admin.laboratory.inventory.items.edit', $item->id) }}"
                                                    class="btn btn-outline-secondary btn-icon rounded-circle" title="Edit">
                                                    <i class="feather feather-edit-2"></i>
                                                </a>
                                            

                                            <!-- Delete -->
                                            <form action="{{ route('admin.laboratory.inventory.items.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Delete this item?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-outline-secondary btn-icon rounded-circle"
                                                    title="Delete">
                                                    <i class="feather feather-trash-2"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection