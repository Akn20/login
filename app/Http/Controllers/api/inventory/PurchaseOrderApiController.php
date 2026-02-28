<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

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
}