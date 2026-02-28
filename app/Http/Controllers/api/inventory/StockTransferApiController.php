<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Models\StockTransfer;
use App\Models\Item;
use Illuminate\Http\Request;
use DB;

class StockTransferApiController extends Controller
{
    public function index()
    {
        return StockTransfer::latest()->get();
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $transfer = StockTransfer::create([
                'transfer_date' => $request->transfer_date,
            ]);

            foreach ($request->items as $item) {

                $transfer->items()->create([
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                ]);

                // Reduce stock
                Item::where('id', $item['item_id'])
                    ->decrement('stock', $item['quantity']);
            }

            DB::commit();

            return response()->json($transfer, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}