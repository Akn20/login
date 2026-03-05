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
            @foreach($categories ?? [] as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
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
                @include('partials.status-toggle', [
                    'id'      => $item->id,
                    'url'     => route('admin.inventory.toggleStatus', $item->id),
                    'checked' => $item->status === 'active',
                ])
            </td>
            <td class="text-end">
                <div class="d-flex justify-content-end gap-2 align-items-center">

                    <!-- Edit -->
                    <a href="{{ route('admin.inventory.edit',$item->id) }}"
                    class="btn btn-outline-secondary btn-icon rounded-circle"
                    title="Edit">
                        <i class="feather feather-edit-2"></i>
                    </a>

                    <!-- Delete -->
                    <form action="{{ route('admin.inventory.delete',$item->id) }}"
                        method="POST"
                        onsubmit="return confirm('Delete item?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('.status-toggle-input[data-url*="inventory"]');

    toggles.forEach(toggle => {
        if (toggle.dataset.bound === '1') return;
        toggle.dataset.bound = '1';

        toggle.addEventListener('change', function () {
            const url     = this.getAttribute('data-url');
            const checked = this.checked;

            fetch(url, {
                method: 'PATCH',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.json();
            })
            .then(data => {
                if (!data.success) {
                    alert('Failed to update status.');
                    this.checked = !checked;
                    return;
                }

                const textEl = this.parentElement.querySelector('.status-toggle-text');
                if (textEl) {
                    const active = (data.status === 'active' || data.is_active);
                    textEl.textContent = active ? 'Active' : 'Inactive';
                }
            })
            .catch(() => {
                alert('Failed to update status.');
                this.checked = !checked;
            });
        });
    });
});
</script>
@endpush

@endsection