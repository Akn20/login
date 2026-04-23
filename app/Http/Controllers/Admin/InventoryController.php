<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\InventoryAlert;
use App\Models\InventoryUsageLog;

class InventoryController extends Controller
{
    public function index()
{
    $items = InventoryItem::latest()->get();
    return view('admin.laboratory.inventory.items.index', compact('items'));
}

public function store(Request $request)
{
    $item = InventoryItem::create($request->all());

    return back()->with('success', 'Item added');
}
public function useItem(Request $request, $id)
{
    $item = InventoryItem::findOrFail($id);

    // 1. Reduce stock
    $item->quantity -= $request->quantity;
    $item->save();

    // 2. Save usage log
    InventoryUsageLog::create([
        'item_id' => $item->id,
        'quantity_used' => $request->quantity,
        'used_by' => auth()->id()
    ]);

    // =========================
    // 3. LOW STOCK ALERT
    // =========================
    if ($item->quantity < $item->threshold) {

        // avoid duplicate alerts
        $exists = InventoryAlert::where('item_id', $item->id)
            ->where('alert_type', 'LOW_STOCK')
            ->where('status', 'Pending')
            ->exists();

        if (!$exists) {
            InventoryAlert::create([
                'item_id' => $item->id,
                'alert_type' => 'LOW_STOCK',
                'message' => "{$item->name} is low in stock"
            ]);
        }
    }

    // =========================
    // 4. EXPIRY ALERT
    // =========================
    if ($item->expiry_date && now()->gt($item->expiry_date)) {

        $exists = InventoryAlert::where('item_id', $item->id)
            ->where('alert_type', 'EXPIRY')
            ->where('status', 'Pending')
            ->exists();

        if (!$exists) {
            InventoryAlert::create([
                'item_id' => $item->id,
                'alert_type' => 'EXPIRY',
                'message' => "{$item->name} is expired"
            ]);
        }
    }

    return back()->with('success', 'Stock updated successfully');
}

}
