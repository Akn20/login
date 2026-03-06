<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
//added by sushan for api
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Facades\DB;


class PurchaseOrderApiController extends Controller
{

    public function index()
    {
        return PurchaseOrder::with('vendor','items.item')
            ->latest()
            ->get();
    }


    public function show($id)
    {
        return PurchaseOrder::with(['vendor', 'items.item'])
            ->findOrFail($id);
    }


//     public function store(Request $request)
// {
//     $request->validate([
//         'po_number' => 'required',
//         'vendor_id' => 'required',
//         'order_date' => 'required',
//         'total_amount' => 'required'
//     ]);

//     $po = PurchaseOrder::create([
//         'po_number' => $request->po_number,
//         'vendor_id' => $request->vendor_id,
//         'order_date' => $request->order_date,
//         'expected_date' => $request->expected_date,
//         'total_amount' => $request->total_amount,
//         'status' => 'draft'
//     ]);

//     return response()->json($po);
// }


//     public function update(Request $request, $id)
//     {
//         $po = PurchaseOrder::findOrFail($id);

//         $po->update([
//             'po_number' => $request->po_number,
//             'vendor_id' => $request->vendor_id,
//             'order_date' => $request->order_date,
//             'total_amount' => $request->total_amount,
//             'status' => $request->status,
//         ]);

//         return response()->json($po);
//     }
//updated store method by sushan for api
public function store(Request $request)
{
    DB::beginTransaction();

    try {

        $request->validate([
            'po_number' => 'required',
            'vendor_id' => 'required',
            'order_date' => 'required',
            'total_amount' => 'required',
            'items' => 'required|array|min:1'
        ]);

        $po = PurchaseOrder::create([
            'po_number' => $request->po_number,
            'vendor_id' => $request->vendor_id,
            'order_date' => $request->order_date,
            'expected_date' => $request->expected_date,
            'total_amount' => $request->total_amount,
            'status' => 'draft'
        ]);

        foreach ($request->items as $item) {

            PurchaseOrderItem::create([
                'purchase_order_id' => $po->id,
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        DB::commit();

        return response()->json(
            $po->load('vendor', 'items.item'),
            201
        );

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}

    // public function destroy($id)
    // {
    //     PurchaseOrder::destroy($id);

    //     return response()->json([
    //         'message' => 'Deleted'
    //     ]);
    // }
public function destroy($id)
{
    $po = PurchaseOrder::withTrashed()->findOrFail($id);

    // delete related items first
    PurchaseOrderItem::where('purchase_order_id', $id)->forceDelete();

    // permanently delete PO
    $po->forceDelete();

    return response()->json([
        'message' => 'Purchase Order permanently deleted'
    ]);
}

public function update(Request $request, $id)
{
    DB::beginTransaction();

    try {

        $request->validate([
            'po_number' => 'required',
            'vendor_id' => 'required',
            'order_date' => 'required',
            'total_amount' => 'required',
            'items' => 'required|array|min:1'
        ]);

        $po = PurchaseOrder::findOrFail($id);

        // 1️⃣ Update main purchase order
        $po->update([
            'po_number' => $request->po_number,
            'vendor_id' => $request->vendor_id,
            'order_date' => $request->order_date,
            'expected_date' => $request->expected_date,
            'total_amount' => $request->total_amount,
            'status' => $request->status ?? $po->status,
        ]);

        // 2️⃣ Delete old items
        PurchaseOrderItem::where('purchase_order_id', $po->id)->delete();

        // 3️⃣ Insert updated items
        foreach ($request->items as $item) {

            PurchaseOrderItem::create([
                'purchase_order_id' => $po->id,
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        DB::commit();

        return response()->json(
            $po->load('vendor', 'items.item')
        );

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}
public function approve($id)
{
    $po = PurchaseOrder::with('items.item')->findOrFail($id);

    $po->status = 'approved';
    $po->save();

    return response()->json([
        'message' => 'Purchase Order Approved',
        'data' => $po
    ]);
}
public function approved()
{
    return PurchaseOrder::with(['vendor', 'items.item'])
        ->where('status', 'approved')
        ->latest()
        ->get();
}

}