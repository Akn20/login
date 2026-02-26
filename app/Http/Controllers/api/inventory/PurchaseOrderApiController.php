<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Item;

class PurchaseOrderApiController extends Controller
{
    public function index()
    {
        $orders = PurchaseOrder::with('items')->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $orders
        ]);
    }

            public function store(Request $request)
            {
            $request->validate([
                'vendor_id' => 'required|exists:vendors,id',
                'order_date' => 'required|date',
                'items' => 'required|array|min:1',
                'items.*.item_id' => 'required|integer',
                'items.*.quantity' => 'required|numeric|min:1',
                'items.*.unit_price' => 'required|numeric|min:0'
            ]);

            DB::beginTransaction();

            try {

                $grandTotal = 0;

                foreach ($request->items as $item) {
                    $grandTotal += $item['quantity'] * $item['unit_price'];
                }

                // ✅ GENERATE PO NUMBER PROPERLY
                $poNumber = 'PO-' . str_pad(
                    PurchaseOrder::count() + 1,
                    5,
                    '0',
                    STR_PAD_LEFT
                );

                $purchaseOrder = PurchaseOrder::create([
    'po_number'     => $poNumber,
    'vendor_id'     => $request->vendor_id,
    'order_date'    => $request->order_date,
    'expected_date' => $request->expected_date,
    'total_amount'  => $grandTotal,
    'status'        => 'draft'   // ✅ MUST MATCH ENUM EXACTLY
]);

                foreach ($request->items as $itemData) {

                    $total = $itemData['quantity'] * $itemData['unit_price'];

                    PurchaseOrderItem::create([
                        'purchase_order_id' => $purchaseOrder->id,
                        'item_id'           => $itemData['item_id'],
                        'quantity'          => $itemData['quantity'],
                        'unit_price'        => $itemData['unit_price'],
                        'total'             => $total
                    ]);
                }

                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Purchase Order Created Successfully',
                    'data' => $purchaseOrder
                ]);

            } catch (\Exception $e) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        }
}