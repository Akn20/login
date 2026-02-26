<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Item;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('vendor')
            ->latest()
            ->paginate(10);

        return view('admin.inventory.purchase-orders.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        $items = Item::where('status', 'active')->get();

        return view('admin.inventory.purchase-orders.create', compact('vendors', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required',
            'order_date' => 'required|date',
            'items' => 'required|array'
        ]);

        DB::transaction(function () use ($request) {

            $po = PurchaseOrder::create([
                'po_number' => 'PO-' . time(),
                'vendor_id' => $request->vendor_id,
                'order_date' => $request->order_date,
                'expected_date' => $request->expected_date,
                'total_amount' => 0,
                'status' => 'draft'
            ]);

            $totalAmount = 0;

            foreach ($request->items as $item) {
                 if (!isset($item['quantity']) || !isset($item['unit_price'])) {
                     continue;
                }

                $lineTotal = $item['quantity'] * $item['unit_price'];

                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $lineTotal
                ]);

                $totalAmount += $lineTotal;
            }

            $po->update(['total_amount' => $totalAmount]);

        });

        return redirect()
            ->route('admin.inventory.purchase-orders.index')
            ->with('success', 'Purchase Order created successfully.');
    }
        public function show($id)
    {
        $purchaseOrder = PurchaseOrder::with(['vendor', 'items.item'])
            ->findOrFail($id);

        return view(
            'admin.inventory.purchase-orders.show',
            compact('purchaseOrder')
        );
    }

            public function edit($id)
        {
            $purchaseOrder = \App\Models\PurchaseOrder::findOrFail($id);

            return view('admin.inventory.purchase-orders.edit', compact('purchaseOrder'));
        }



        public function update(Request $request, $id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        // If only status update
        if ($request->has('status')) {
            $purchaseOrder->update([
                'status' => $request->status
            ]);

            return back()->with('success', 'Purchase Order Approved Successfully.');
        }

        // Normal update logic (if needed later)

        return back();
    }
    public function destroy($id)
{
    $purchaseOrder = PurchaseOrder::findOrFail($id);

    // Allow delete only if Draft
    if ($purchaseOrder->status !== 'draft') {
        return back()->with('error', 'Only draft Purchase Orders can be deleted.');
    }

    $purchaseOrder->delete();

    return redirect()
        ->route('admin.inventory.purchase-orders.index')
        ->with('success', 'Purchase Order deleted successfully.');
}

}