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
            $grn = Grn::create([
                'grn_number' => 'GRN-' . now()->format('YmdHis'),
                'purchase_order_id' => $request->purchase_order_id,
                'received_date' => $request->received_date,
                'total_amount' => 0,
            ]);

            $total = 0;

            foreach ($request->items as $item) {

                $lineTotal = $item['received_quantity'] * $item['unit_price'];

                $grn->items()->create([
                    'item_id' => $item['item_id'],
                    'ordered_quantity' => $item['ordered_quantity'],
                    'received_quantity' => $item['received_quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $lineTotal,
                ]);

                // Update stock
                Item::where('id', $item['item_id'])
                    ->increment('stock', $item['received_quantity']);

                $total += $lineTotal;
            }

            $grn->update(['total_amount' => $total]);

            DB::commit();

            return response()->json($grn, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}