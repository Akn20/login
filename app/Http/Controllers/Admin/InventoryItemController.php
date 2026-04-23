<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\InventoryAlert;

class InventoryItemController extends Controller
{
    public function index()
    {
        $items = InventoryItem::latest()->get();
        return view('admin.laboratory.inventory.items.index', compact('items'));
    }

    public function create()
    {
        return view('admin.laboratory.inventory.items.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'quantity' => 'required|numeric|min:0',
        'threshold' => 'nullable|numeric|min:0',
        'expiry_date' => 'nullable|date'
    ]);

    // CREATE ONLY ONCE
    $item = InventoryItem::create($request->all());

    // CREATE ALERT
    if ($item->quantity <= $item->threshold) {
        InventoryAlert::create([
            'item_id' => $item->id,
            'alert_type' => 'low_stock',
            'message' => "{$item->name} is low in stock",
            'status' => 'Pending'
        ]);
    }

    return redirect()->route('admin.laboratory.inventory.items.index')
        ->with('success', 'Item added');
}

    public function edit($id)
    {
        $item = InventoryItem::findOrFail($id);
        return view('admin.laboratory.inventory.items.edit', compact('item'));
    }


    public function update(Request $request, $id)
    {
        $item = InventoryItem::findOrFail($id);

        $item->update($request->all());

         if ($item->quantity <= $item->threshold) {
        InventoryAlert::create([
            'item_id' => $item->id,
            'alert_type' => 'low_stock',
            'message' => "{$item->name} is low in stock",
            'status' => 'Pending'
        ]);
    }


        return redirect()->route('admin.laboratory.inventory.items.index')->with('success', 'Item updated');
    }
    public function destroy($id)
    {
        $item = InventoryItem::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Item deleted');
    }

    public function show($id)
    {
        $item = InventoryItem::findOrFail($id);
        return view('admin.laboratory.inventory.items.show', compact('item'));
    }
}