@extends('layouts.admin')

@section('content')

<h5>New Stock Audit</h5>

<form method="POST"
      action="{{ route('admin.inventory.stock-audits.store') }}">
@csrf

<div class="mb-3">
    <label>Item</label>
    <select name="item_id" class="form-control" required>
        <option value="">Select Item</option>
        @foreach($items as $item)
        <option value="{{ $item->id }}">
            {{ $item->name }} (Current: {{ $item->stock }})
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Physical Stock</label>
    <input type="number"
           name="physical_stock"
           class="form-control"
           min="0"
           required>
</div>

<button type="submit" class="btn btn-success">
    Complete Audit
</button>

</form>

@endsection