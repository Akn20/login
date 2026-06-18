<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Grn;
use App\Models\Item;
use Illuminate\Http\Request;
use DB;

class GrnApiController extends Controller
{
    public function index()
    {
        return Grn::with('purchaseOrder')->latest()->get();
    }

    public function show($id)
    {
        return Grn::with(['purchaseOrder', 'items.item'])
            ->findOrFail($id);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

        $purchaseOrder = DB::table('purchase_orders')
    ->where('id', $request->purchase_order_id)
    ->first();

$vendor = DB::table('inventory_vendors')
    ->where('id', $purchaseOrder->inventory_vendor_id)
    ->first();
    
          $grn = Grn::create([

    'grn_no' => 'GRN-' . now()->format('YmdHis'),

    'purchase_order_id' => $request->purchase_order_id,

    'po_no' => $purchaseOrder->po_number,

    'vendor_name' => $vendor->vendor_name,

    //'vendor_id' => $vendor->id,

    'grn_date' => now()->toDateString(),

    'invoice_date' => now()->toDateString(),

    'invoice_no' => 'N/A',

    'sub_total' => 0,

    'grand_total' => 0,

    'status' => 'Draft',
]);
            $total = 0;

            foreach ($request->items as $item) {

                $lineTotal = $item['received_quantity'] * $item['unit_price'];

DB::table('grn_items')->insert([

    'grn_id' => $grn->id,

    'item_id' => $item['item_id'],

    'medicine_name' => $item['item_name'],

    'ordered_quantity' => $item['ordered_quantity'],

    'received_quantity' => $item['received_quantity'],

    'unit_price' => $item['unit_price'],

    'qty' => $item['received_quantity'],

    'purchase_rate' => $item['unit_price'],

    'amount' => $lineTotal,

    'total' => $lineTotal,

    'created_at' => now(),

    'updated_at' => now(),

]);
                // Update stock
                Item::where('id', $item['item_id'])
                    ->increment('stock', $item['received_quantity']);

                $total += $lineTotal;
            }

             $grn->update([
            'sub_total' => $total,
            'grand_total' => $total,
        ]);
            DB::commit();

            return response()->json($grn, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}