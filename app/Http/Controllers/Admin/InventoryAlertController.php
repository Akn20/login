<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryAlert;
use App\Models\InventoryItem;

class InventoryAlertController extends Controller
{
    /**
     * =========================
     * WEB: Show alerts
     * =========================
     */
    public function index()
    {
        // Sync alerts before showing
        $this->syncAlerts();

        $alerts = InventoryAlert::with('item')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.laboratory.inventory.alerts.index', compact('alerts'));
    }

    /**
     * Acknowledge alert
     */
    public function acknowledge($id)
    {
        $alert = InventoryAlert::findOrFail($id);

        $alert->update([
            'status' => 'Acknowledged'
        ]);

        return back()->with('success', 'Alert acknowledged');
    }

    /**
     * Resolve alert
     */
    public function resolve($id)
    {
        $alert = InventoryAlert::findOrFail($id);

        $alert->update([
            'status' => 'Resolved'
        ]);

        return back()->with('success', 'Alert resolved');
    }

    /**
     * =========================
     * API: Get all alerts
     * =========================
     */
    public function apiIndex()
    {
        $this->syncAlerts();

        $alerts = InventoryAlert::with('item')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $alerts
        ]);
    }

    /**
     * API: Filter alerts by status
     */
    public function apiByStatus($status)
    {
        $alerts = InventoryAlert::with('item')
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $alerts
        ]);
    }

    /**
     * API: Acknowledge alert
     */
    public function apiAcknowledge($id)
    {
        $alert = InventoryAlert::find($id);

        if (!$alert) {
            return response()->json([
                'status' => false,
                'message' => 'Alert not found'
            ], 404);
        }

        $alert->update([
            'status' => 'Acknowledged'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Alert acknowledged'
        ]);
    }

    /**
     * API: Resolve alert
     */
    public function apiResolve($id)
    {
        $alert = InventoryAlert::find($id);

        if (!$alert) {
            return response()->json([
                'status' => false,
                'message' => 'Alert not found'
            ], 404);
        }

        $alert->update([
            'status' => 'Resolved'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Alert resolved'
        ]);
    }

    /**
     * =========================
     * ALERT SYNC LOGIC (IMPORTANT)
     * =========================
     */
    private function syncAlerts()
    {
        $items = InventoryItem::all();

        foreach ($items as $item) {

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
                        'message' => $item->name . ' is low in stock',
                        'status' => 'Pending'
                    ]);
                }

            } else {
                // Remove if stock normal
                InventoryAlert::where('item_id', $item->id)
                    ->where('alert_type', 'low_stock')
                    ->delete();
            }

            /**
             * EXPIRY ALERT
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
                        'message' => $item->name . ' is expired',
                        'status' => 'Pending'
                    ]);
                }
            }
        }
    }
}