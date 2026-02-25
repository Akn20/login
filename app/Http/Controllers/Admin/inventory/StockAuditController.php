<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockAudit;
use App\Models\Item;

class StockAuditController extends Controller
{
    public function index()
    {
        $audits = StockAudit::with('item')->latest()->paginate(10);
        return view('admin.inventory.stock-audits.index', compact('audits'));
    }

    public function create()
    {
        $items = Item::all();
        return view('admin.inventory.stock-audits.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'physical_stock' => 'required|integer|min:0'
        ]);

        $item = Item::findOrFail($request->item_id);

        $difference = $request->physical_stock - $item->stock;

        StockAudit::create([
            'audit_date' => now(),
            'item_id' => $item->id,
            'system_stock' => $item->stock,
            'physical_stock' => $request->physical_stock,
            'difference' => $difference
        ]);

        // 🔥 Adjust system stock
        $item->update([
            'stock' => $request->physical_stock
        ]);

        return redirect()
            ->route('admin.inventory.stock-audits.index')
            ->with('success', 'Stock audit completed successfully.');
    }
}