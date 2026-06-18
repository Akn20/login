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
        $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'items' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {

            $po = PurchaseOrder::with('items')
                ->findOrFail($request->purchase_order_id);

            // CREATE GRN
            $grn = Grn::create([

                'purchase_order_id' => $po->id,

                'grn_no' => 'GRN-' . time(),

                'grn_date' => now(),

                'vendor_name' => $po->vendor_name ?? 'Unknown Vendor',

                'invoice_no' => $request->invoice_no ?? 'N/A',

                'invoice_date' => $request->invoice_date ?? now(),

                'po_no' => $po->po_number ?? null,

                'status' => 'Draft',

                'sub_total' => 0,

                'total_discount' => 0,

                'total_tax' => 0,

                'grand_total' => 0,
            ]);

            $totalAmount = 0;
            $allReceived = true;

            foreach ($request->items as $itemData) {

                if (
                    empty($itemData['received_quantity']) ||
                    $itemData['received_quantity'] <= 0
                ) {
                    continue;
                }

                $item = Item::findOrFail($itemData['item_id']);

                $receivedQty = $itemData['received_quantity'];

                $unitPrice = $itemData['unit_price'];

                $lineTotal = $receivedQty * $unitPrice;

                // CREATE GRN ITEM
                GrnItem::create([

                    'grn_id' => $grn->id,

                    'medicine_name' => $item->name,

                    'batch_no' => $itemData['batch_no'] ?? null,

                    'expiry' => $itemData['expiry'] ?? null,

                    'qty' => $receivedQty,

                    'free_qty' => $itemData['free_qty'] ?? 0,

                    'purchase_rate' => $unitPrice,

                    'discount_percent' => $itemData['discount_percent'] ?? 0,

                    'tax_percent' => $itemData['tax_percent'] ?? 0,

                    'amount' => $lineTotal,
                ]);

                // UPDATE STOCK
                $item->increment('stock', $receivedQty);

                // CHECK FULLY RECEIVED
                if (
                    $receivedQty <
                    $itemData['ordered_quantity']
                ) {
                    $allReceived = false;
                }

                $totalAmount += $lineTotal;
            }

            // UPDATE TOTALS
            $grn->update([

                'sub_total' => $totalAmount,

                'grand_total' => $totalAmount,
            ]);

            // COMPLETE PO
            if ($allReceived) {

                $po->update([
                    'status' => 'completed'
                ]);
            }
        });

        return redirect()
            ->route('admin.inventory.grns.index')
            ->with(
                'success',
                'GRN Created & Stock Updated Successfully.'
            );
    }
    public function show($id)
{
    $grn = Grn::with([
        'items',
        'purchaseOrder'
    ])->findOrFail($id);

    return view(
        'admin.inventory.grns.show',
        compact('grn')
    );
}
public function edit($id)
{
    $grn = Grn::with([
        'items',
        'purchaseOrder'
    ])->findOrFail($id);

    return view(
        'admin.inventory.grns.edit',
        compact('grn')
    );
}
public function update(Request $request, $id)
{
    $grn = Grn::findOrFail($id);

    $grn->update([

        'remarks' => $request->remarks,

        'status' => $request->status ?? $grn->status,

        'verify_remarks' => $request->verify_remarks,

        'reject_reason' => $request->reject_reason,
    ]);

    return redirect()
        ->route('admin.inventory.grns.index')
        ->with(
            'success',
            'GRN Updated Successfully.'
        );
}
public function destroy($id)
{
    $grn = Grn::findOrFail($id);

    // OPTIONAL:
    // restore stock before delete

    foreach ($grn->items as $item) {

        $inventoryItem = Item::where(
            'name',
            $item->medicine_name
        )->first();

        if ($inventoryItem) {

            $inventoryItem->decrement(
                'stock',
                $item->qty
            );
        }
    }

    // delete child items
    $grn->items()->delete();

    // delete grn
    $grn->delete();

    return redirect()
        ->route('admin.inventory.grns.index')
        ->with(
            'success',
            'GRN Deleted Successfully.'
        );
}
}