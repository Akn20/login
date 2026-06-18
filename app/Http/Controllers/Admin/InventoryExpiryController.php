<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use Illuminate\Support\Facades\Validator;

class InventoryExpiryController extends Controller
{
    /**
     * =========================
     * WEB: Show expiry items
     * =========================
     */
   public function index(Request $request)
{
    $query = InventoryItem::whereNotNull('expiry_date');

    // Optional search
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Optional filter
    if ($request->filled('type')) {
        if ($request->type === 'expired') {
            $query->where('expiry_date', '<', now());
        } elseif ($request->type === 'expiring_soon') {
            $query->whereBetween('expiry_date', [now(), now()->addDays(7)]);
        }
    }

    $items = $query->orderBy('expiry_date', 'asc')->get();

    return view('admin.laboratory.inventory.expiry.index', compact('items'));
}

    /**
     * =========================
     * API: Get all expiry items
     * =========================
     */
    public function apiIndex()
    {
        $items = InventoryItem::whereNotNull('expiry_date')
            ->orderBy('expiry_date', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $items
        ]);
    }

    /**
     * =========================
     * API: Get ONLY expired items
     * =========================
     */
    public function apiExpired()
    {
        $items = InventoryItem::whereNotNull('expiry_date')
            ->where('expiry_date', '<', now())
            ->orderBy('expiry_date', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $items
        ]);
    }

    /**
     * =========================
     * API: Get expiring soon items
     * (default: next 7 days)
     * =========================
     */
    public function apiExpiringSoon(Request $request)
    {
        $days = $request->get('days', 7);

        $validator = Validator::make(['days' => $days], [
            'days' => 'required|numeric|min:1|max:365'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $items = InventoryItem::whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [now(), now()->addDays($days)])
            ->orderBy('expiry_date', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => "Items expiring in next {$days} days",
            'data' => $items
        ]);
    }
}