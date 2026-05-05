<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryUsageLog;

class InventoryUsageController extends Controller
{
    /**
     * Display usage logs with search & filters
     */
    public function index(Request $request)
    {
        $query = InventoryUsageLog::with(['item', 'user']);

        /**
         * =========================
         * SEARCH (Item Name)
         * =========================
         */
        if ($request->filled('search')) {
            $query->whereHas('item', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        /**
         * =========================
         * FILTER BY DATE RANGE
         * =========================
         */
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        /**
         * =========================
         * SORTING
         * =========================
         */
        $logs = $query->orderBy('created_at', 'desc')->get();

        return view('admin.laboratory.inventory.usage.index', compact('logs'));
    }

    /**
 * API: Get all usage logs
 */
public function apiIndex()
{
    $logs = InventoryUsageLog::with(['item', 'user'])
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'status' => true,
        'data' => $logs
    ]);
}

/**
 * API: Search + Filter usage logs
 */
public function apiSearch(Request $request)
{
    $query = InventoryUsageLog::with(['item', 'user']);

    // 🔍 Search by item name
    if ($request->filled('search')) {
        $query->whereHas('item', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    // 📅 Filter by date range
    if ($request->filled('from_date')) {
        $query->whereDate('created_at', '>=', $request->from_date);
    }

    if ($request->filled('to_date')) {
        $query->whereDate('created_at', '<=', $request->to_date);
    }

    $logs = $query->orderBy('created_at', 'desc')->get();

    return response()->json([
        'status' => true,
        'data' => $logs
    ]);
}

/**
 * API: Get usage logs for a specific item
 */
public function apiByItem($item_id)
{
    $logs = InventoryUsageLog::with(['item', 'user'])
        ->where('item_id', $item_id)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'status' => true,
        'data' => $logs
    ]);
}

/**
 * API: Get usage logs for a specific user
 */
public function apiByUser($user_id)
{
    $logs = InventoryUsageLog::with(['item', 'user'])
        ->where('used_by', $user_id)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'status' => true,
        'data' => $logs
    ]);
}

/**
 * API: Get usage summary (total used per item)
 */
public function apiSummary()
{
    $summary = InventoryUsageLog::selectRaw('item_id, SUM(quantity_used) as total_used')
        ->with('item')
        ->groupBy('item_id')
        ->get();

    return response()->json([
        'status' => true,
        'data' => $summary
    ]);
}
}