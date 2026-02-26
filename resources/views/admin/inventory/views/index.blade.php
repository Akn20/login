@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Inventory Items</h3>
    <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary">+ Add Item</a>
</div>

<!-- Search & Filter -->
<form method="GET" action="{{ route('admin.inventory.index') }}" class="row mb-3">
    <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" 
               class="form-control" placeholder="Search by name or code">
    </div>

    <div class="col-md-3">
        <select name="category" class="form-control">
            <option value="">All Categories</option>
            <option value="Medicine" {{ request('category')=='Medicine'?'selected':'' }}>Medicine</option>
            <option value="Equipment" {{ request('category')=='Equipment'?'selected':'' }}>Equipment</option>
            <option value="Consumable" {{ request('category')=='Consumable'?'selected':'' }}>Consumable</option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-secondary">Filter</button>
    </div>
</form>

<!-- Items Table -->
<div class="card">
<div class="card-body table-responsive">

<table class="table table-bordered table-striped">
    <thead class="table-white table-bg">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Code</th>
            <th>Category</th>
            <th>Unit</th>
            <th>Stock</th>
            <th>Reorder</th>
            <th>Status</th>
            <th width="150">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($items as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->code }}</td>
            <td>{{ $item->category }}</td>
            <td>{{ $item->unit }}</td>
            <td>
                @if($item->stock <= $item->reorder_level)
                    <span class="badge bg-danger">{{ $item->stock }}</span>
                @else
                    {{ $item->stock }}
                @endif
            </td>
            <td>{{ $item->reorder_level }}</td>
            <td>
                @if($item->status == 'active')
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-secondary">Inactive</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.inventory.edit',$item->id) }}" 
                   class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('admin.inventory.delete',$item->id) }}" 
                      method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Delete item?')" 
                            class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center">No items found</td>
        </tr>
        @endforelse
    </tbody>
</table>

</div>
</div>

<!-- Pagination -->
<div class="mt-3">
    {{ $items->links() }}
</div>

@endsection