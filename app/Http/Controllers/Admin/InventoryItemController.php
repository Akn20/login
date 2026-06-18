<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\InventoryAlert;

class InventoryItemController extends Controller
{
    /**
     * Display list of inventory items with search
     */
    public function index(Request $request)
    {
        $query = InventoryItem::query();

        // SEARCH FUNCTIONALITY
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
            });
        }

        $items = $query->latest()->get();

        return view('admin.laboratory.inventory.items.index', compact('items'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.laboratory.inventory.items.create');
    }

    /**
     * Store new inventory item
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'threshold' => 'nullable|numeric|min:0',
            'expiry_date' => 'nullable|date'
        ]);

        // CREATE ITEM
        $item = InventoryItem::create($request->all());

        // CREATE ALERT IF LOW STOCK
        if ($item->quantity <= $item->threshold) {
            InventoryAlert::firstOrCreate(
                [
                    'item_id' => $item->id,
                    'alert_type' => 'low_stock'
                ],
                [
                    'message' => "{$item->name} is low in stock",
                    'status' => 'Pending'
                ]
            );
        }

        return redirect()
            ->route('admin.laboratory.inventory.items.index')
            ->with('success', 'Item added successfully');
    }

    /**
     * Show item details
     */
    public function show($id)
    {
        $item = InventoryItem::findOrFail($id);

        return view('admin.laboratory.inventory.items.show', compact('item'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $item = InventoryItem::findOrFail($id);

        return view('admin.laboratory.inventory.items.edit', compact('item'));
    }

    /**
     * Update inventory item
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'threshold' => 'nullable|numeric|min:0',
            'expiry_date' => 'nullable|date'
        ]);

        $item = InventoryItem::findOrFail($id);

        // UPDATE ITEM
        $item->update($request->all());

        // HANDLE ALERT LOGIC
        if ($item->quantity <= $item->threshold) {

            $existingAlert = InventoryAlert::where('item_id', $item->id)
                ->where('alert_type', 'low_stock')
                ->first();

            if (!$existingAlert) {
                InventoryAlert::create([
                    'item_id' => $item->id,
                    'alert_type' => 'low_stock',
                    'message' => "{$item->name} is low in stock",
                    'status' => 'Pending'
                ]);
            }

        } else {
            // REMOVE ALERT IF STOCK IS NORMAL
            InventoryAlert::where('item_id', $item->id)
                ->where('alert_type', 'low_stock')
                ->delete();
        }

        return redirect()
            ->route('admin.laboratory.inventory.items.index')
            ->with('success', 'Item updated successfully');
    }

    /**
     * Delete inventory item
     */
    public function destroy($id)
    {
        $item = InventoryItem::findOrFail($id);

        // DELETE RELATED ALERTS FIRST (SAFE)
        InventoryAlert::where('item_id', $item->id)->delete();

        // DELETE ITEM
        $item->delete();

        return redirect()
            ->route('admin.laboratory.inventory.items.index')
            ->with('success', 'Item deleted successfully');
    }

    /**
 * API: Get all inventory items
 */
public function apiIndex()
{
    $items = InventoryItem::latest()->get();

    return response()->json([
        'status' => true,
        'message' => 'Inventory items fetched successfully',
        'data' => $items
    ]);
}


/**
 * API: Store new inventory item
 */
public function apiStore(Request $request)
{
    $validator = \Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'category' => 'nullable|string|max:255',
        'quantity' => 'required|numeric|min:0',
        'unit' => 'nullable|string|max:50',
        'threshold' => 'nullable|numeric|min:0',
        'expiry_date' => 'nullable|date'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $item = InventoryItem::create($request->all());

    // Low stock alert
    if ($item->threshold !== null && $item->quantity <= $item->threshold) {
        InventoryAlert::firstOrCreate(
            [
                'item_id' => $item->id,
                'alert_type' => 'low_stock'
            ],
            [
                'message' => "{$item->name} is low in stock",
                'status' => 'Pending'
            ]
        );
    }

    return response()->json([
        'status' => true,
        'message' => 'Item created successfully',
        'data' => $item
    ]);
}


/**
 * API: Show single item
 */
public function apiShow($id)
{
    $item = InventoryItem::find($id);

    if (!$item) {
        return response()->json([
            'status' => false,
            'message' => 'Item not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'data' => $item
    ]);
}


/**
 * API: Update item
 */
public function apiUpdate(Request $request, $id)
{
    $item = InventoryItem::find($id);

    if (!$item) {
        return response()->json([
            'status' => false,
            'message' => 'Item not found'
        ], 404);
    }

    $validator = \Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'category' => 'nullable|string|max:255',
        'quantity' => 'required|numeric|min:0',
        'unit' => 'nullable|string|max:50',
        'threshold' => 'nullable|numeric|min:0',
        'expiry_date' => 'nullable|date'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $item->update($request->all());

    // Alert logic
    if ($item->threshold !== null && $item->quantity <= $item->threshold) {

        $existingAlert = InventoryAlert::where('item_id', $item->id)
            ->where('alert_type', 'low_stock')
            ->first();

        if (!$existingAlert) {
            InventoryAlert::create([
                'item_id' => $item->id,
                'alert_type' => 'low_stock',
                'message' => "{$item->name} is low in stock",
                'status' => 'Pending'
            ]);
        }

    } else {
        InventoryAlert::where('item_id', $item->id)
            ->where('alert_type', 'low_stock')
            ->delete();
    }

    return response()->json([
        'status' => true,
        'message' => 'Item updated successfully',
        'data' => $item
    ]);
}


/**
 * API: Delete item
 */
public function apiDestroy($id)
{
    $item = InventoryItem::find($id);

    if (!$item) {
        return response()->json([
            'status' => false,
            'message' => 'Item not found'
        ], 404);
    }

    InventoryAlert::where('item_id', $item->id)->delete();
    $item->delete();

    return response()->json([
        'status' => true,
        'message' => 'Item deleted successfully'
    ]);
}

}