<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\InventoryAlert;
use App\Models\InventoryUsageLog;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * =========================
     * WEB FUNCTIONS
     * =========================
     */

    public function index()
    {
        $items = InventoryItem::latest()->get();
        return view('admin.laboratory.inventory.items.index', compact('items'));
    }

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

        $item = InventoryItem::create($request->only([
            'name', 'category', 'quantity', 'unit', 'threshold', 'expiry_date'
        ]));

        return back()->with('success', 'Item added successfully');
    }

    public function useItem(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1'
        ]);

        $item = InventoryItem::findOrFail($id);

        // Prevent negative stock
        if ($request->quantity > $item->quantity) {
            return back()->with('error', 'Not enough stock available');
        }

        // Reduce stock
        $item->quantity -= $request->quantity;
        $item->save();

        // Log usage
        InventoryUsageLog::create([
            'item_id' => $item->id,
            'quantity_used' => $request->quantity,
            'used_by' => auth()->id()
        ]);

        $this->handleAlerts($item);

        return back()->with('success', 'Stock updated successfully');
    }

    /**
     * =========================
     * API FUNCTIONS
     * =========================
     */

    public function apiIndex()
    {
        $items = InventoryItem::latest()->get();

        return response()->json([
            'status' => true,
            'data' => $items
        ]);
    }

    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        $item = InventoryItem::create($request->only([
            'name', 'category', 'quantity', 'unit', 'threshold', 'expiry_date'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Item created successfully',
            'data' => $item
        ]);
    }

    public function apiUseItem(Request $request, $id)
    {
        $item = InventoryItem::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Item not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Prevent negative stock
        if ($request->quantity > $item->quantity) {
            return response()->json([
                'status' => false,
                'message' => 'Not enough stock available'
            ], 400);
        }

        // Reduce stock
        $item->quantity -= $request->quantity;
        $item->save();

        // Log usage
        InventoryUsageLog::create([
            'item_id' => $item->id,
            'quantity_used' => $request->quantity,
            'used_by' => auth()->id() ?? null
        ]);

        $this->handleAlerts($item);

        return response()->json([
            'status' => true,
            'message' => 'Stock updated successfully',
            'data' => $item
        ]);
    }

    public function apiUsageLogs()
    {
        $logs = InventoryUsageLog::with('item')->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $logs
        ]);
    }

    /**
     * =========================
     * ALERT HANDLER (COMMON)
     * =========================
     */

    private function handleAlerts($item)
    {
        /**
         * LOW STOCK ALERT
         */
        if ($item->threshold !== null && $item->quantity <= $item->threshold) {

            $exists = InventoryAlert::where('item_id', $item->id)
                ->where('alert_type', 'low_stock')
                ->where('status', 'Pending')
                ->exists();

            if (!$exists) {
                InventoryAlert::create([
                    'item_id' => $item->id,
                    'alert_type' => 'low_stock',
                    'message' => "{$item->name} is low in stock",
                    'status' => 'Pending'
                ]);
            }

        } else {
            // Remove alert if stock is normal
            InventoryAlert::where('item_id', $item->id)
                ->where('alert_type', 'low_stock')
                ->delete();
        }

        /**
         * EXPIRY ALERT (already expired)
         */
        if ($item->expiry_date && now()->gt($item->expiry_date)) {

            $exists = InventoryAlert::where('item_id', $item->id)
                ->where('alert_type', 'expiry')
                ->where('status', 'Pending')
                ->exists();

            if (!$exists) {
                InventoryAlert::create([
                    'item_id' => $item->id,
                    'alert_type' => 'expiry',
                    'message' => "{$item->name} is expired",
                    'status' => 'Pending'
                ]);
            }
        }
    }
}