<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\InventoryAlert;
use App\Models\InventoryItem;

class InventoryAlertController extends Controller
{

    public function index()
{
    $items = InventoryItem::all();

    foreach ($items as $item) {

    if ($item->quantity <= $item->threshold) {

        $alert = InventoryAlert::where('item_id', $item->id)
            ->where('alert_type', 'low_stock')
            ->first();

        if (!$alert) {
            // Create only if not exists
            InventoryAlert::create([
                'item_id' => $item->id,
                'alert_type' => 'low_stock',
                'message' => $item->name . ' is low in stock',
                'status' => 'Pending'
            ]);
        }

    } else {
        // Remove alert if stock is OK
        InventoryAlert::where('item_id', $item->id)
            ->where('alert_type', 'low_stock')
            ->delete();
    }
}

    $alerts = InventoryAlert::with('item')->latest()->get();

    return view('admin.laboratory.inventory.alerts.index', compact('alerts'));
}

    public function acknowledge($id)
    {
        $alert = InventoryAlert::findOrFail($id);

        $alert->update([
            'status' => 'Acknowledged'
        ]);

        return back()->with('success', 'Alert acknowledged');
    }

    public function resolve($id)
    {
        $alert = InventoryAlert::findOrFail($id);

        $alert->update([
            'status' => 'Resolved'
        ]);

        return back()->with('success', 'Alert resolved');
    }
}