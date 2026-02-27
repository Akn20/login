<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grn;
use App\Models\GrnItem;
use App\Models\PurchaseOrder;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class GrnController extends Controller
{
    public function index()
    {
        $grns = Grn::with('purchaseOrder')
            ->latest()
            ->paginate(10);

        return view('admin.inventory.grns.index', compact('grns'));
    }

    public function create(Request $request)
    {
        $po = PurchaseOrder::with('items.item')
            ->where('status', 'approved')
            ->findOrFail($request->po_id);

        return view('admin.inventory.grns.create', compact('po'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $po = PurchaseOrder::with('items')->findOrFail($request->purchase_order_id);

            $grn = Grn ::create([ 
                'grn_number' => 'GRN-' . time(),
                'purchase_order_id' => $po->id,
                'received_date' => $request->received_date,
                'total_amount' => 0
            ]);

            $totalAmount = 0;
            $allReceived = true;

            foreach ($request->items as $itemData) {

                if (empty($itemData['received_quantity'])) {
                    continue;
                }

                $lineTotal = $itemData['received_quantity'] * $itemData['unit_price'];

                GrnItem::create([
                    'grn_id' => $grn->id,
                    'item_id' => $itemData['item_id'],
                    'ordered_quantity' => $itemData['ordered_quantity'],
                    'received_quantity' => $itemData['received_quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total' => $lineTotal
                ]);

                // 🔥 UPDATE STOCK
                $item = Item::find($itemData['item_id']);
                $item->increment('stock', $itemData['received_quantity']);

                if ($itemData['received_quantity'] < $itemData['ordered_quantity']) {
                    $allReceived = false;
                }

                $totalAmount += $lineTotal;
            }

            $grn->update(['total_amount' => $totalAmount]);

            if ($allReceived) {
                $po->update(['status' => 'completed']);
            }

        });

        return redirect()
            ->route('admin.inventory.grns.index')
            ->with('success', 'GRN Created & Stock Updated Successfully.');
    }
}