<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use App\Models\PurchaseOrderItem;

class PurchaseOrderApiController extends Controller
{

    public function index()
    {
        return PurchaseOrder::with('vendor')
            ->latest()
            ->get();
    }


    public function show($id)
    {
        return PurchaseOrder::with(['vendor', 'items.item'])
            ->findOrFail($id);
    }


   public function store(Request $request)
{
    $request->validate([
        'po_number' => 'required',
        'vendor_id' => 'required',
        'order_date' => 'required',
        'total_amount' => 'required'
    ]);

    $po = PurchaseOrder::create([
        'po_number' => $request->po_number,
        'vendor_id' => $request->vendor_id,
        'order_date' => $request->order_date,
        'expected_date' => $request->expected_date,
        'total_amount' => $request->total_amount,
        'status' => 'draft'
    ]);

    // ✅ save items
    if ($request->items) {

        foreach ($request->items as $item) {

            PurchaseOrderItem::create([
                'purchase_order_id' => $po->id,
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['quantity'] * $item['unit_price'],
            ]);

        }

    }

    return response()->json($po);
}

    public function update(Request $request, $id)
    {
        $po = PurchaseOrder::findOrFail($id);

        $po->update([
            'po_number' => $request->po_number,
            'vendor_id' => $request->vendor_id,
            'order_date' => $request->order_date,
            'total_amount' => $request->total_amount,
            'status' => $request->status,
        ]);

        return response()->json($po);
    }


    public function destroy($id)
    {
        PurchaseOrder::destroy($id);

        return response()->json([
            'message' => 'Deleted'
        ]);
    }


    // ✅ APPROVE
    public function approve($id)
    {
        $po = PurchaseOrder::findOrFail($id);

        if ($po->status != 'draft') {
            return response()->json([
                'message' => 'Only draft can be approved'
            ], 400);
        }

        $po->status = 'approved';
        $po->save();

        return response()->json($po);
    }


    // ✅ ORDERED
    public function ordered($id)
    {
        $po = PurchaseOrder::findOrFail($id);

        if ($po->status != 'approved') {
            return response()->json([
                'message' => 'Only approved can be ordered'
            ], 400);
        }

        $po->status = 'ordered';
        $po->save();

        return response()->json($po);
    }


    // ✅ COMPLETED
    public function completed($id)
    {
        $po = PurchaseOrder::findOrFail($id);

        if ($po->status != 'ordered') {
            return response()->json([
                'message' => 'Only ordered can be completed'
            ], 400);
        }

        $po->status = 'completed';
        $po->save();

        return response()->json($po);
    }


    // ✅ CANCEL
    public function cancel($id)
    {
        $po = PurchaseOrder::findOrFail($id);

        $po->status = 'cancelled';
        $po->save();

        return response()->json($po);
    }

}