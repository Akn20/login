<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Models\StockAudit;
use App\Models\Item;
use Illuminate\Http\Request;

class StockAuditApiController extends Controller
{
    public function index()
    {
        return StockAudit::with('item')->latest()->get();
    }

    // public function store(Request $request)
    // {
    //     $item = Item::findOrFail($request->item_id);

    //     $difference = $request->physical_stock - $item->stock;

    //     $audit = StockAudit::create([
    //         'item_id' => $item->id,
    //         'system_stock' => $item->stock,
    //         'physical_stock' => $request->physical_stock,
    //         'difference' => $difference,
    //     ]);

    //     // Adjust stock
    //     $item->update([
    //         'stock' => $request->physical_stock
    //     ]);

    //     return response()->json($audit, 201);
    // }
    //updated store
    public function store(Request $request)
{
    // ✅ Validate request
    $request->validate([
        'item_id' => 'required|exists:items,id',
        'physical_stock' => 'required|numeric|min:0'
    ]);

    $item = Item::findOrFail($request->item_id);

    $difference = $request->physical_stock - $item->stock;

    $audit = StockAudit::create([
        'item_id' => $item->id,
        'system_stock' => $item->stock,
        'physical_stock' => $request->physical_stock,
        'difference' => $difference,
        'audit_date' => now()
    ]);

    // ✅ Update stock
    $item->update([
        'stock' => $request->physical_stock
    ]);

    return response()->json($audit, 201);
}
    
}