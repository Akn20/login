<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockTransfer;
use App\Models\StockTransferItem;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class StockTransferController extends Controller
{
    public function index()
    {
        $transfers = StockTransfer::latest()->paginate(10);
        return view('admin.inventory.stock-transfers.index', compact('transfers'));
    }

    public function create()
    {
        $items = Item::all();
        return view('admin.inventory.stock-transfers.create', compact('items'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $transfer = StockTransfer::create([
                'transfer_number' => 'ST-' . time(),
                'transfer_date'   => $request->transfer_date,
            ]);

            foreach ($request->items as $itemData) {

    if (!isset($itemData['item_id']) || !isset($itemData['quantity'])) {
        continue;
    }

    if ($itemData['quantity'] <= 0) {
        continue;
    }

    $item = Item::find($itemData['item_id']);

    if (!$item) {
        continue;
    }

    if ($item->stock < $itemData['quantity']) {
        throw new \Exception('Insufficient stock for ' . $item->name);
    }

    $item->decrement('stock', $itemData['quantity']);

    StockTransferItem::create([
        'stock_transfer_id' => $transfer->id,
        'item_id'           => $itemData['item_id'],
        'quantity'          => $itemData['quantity'],
    ]);
}
        });

        return redirect()
            ->route('admin.inventory.stock-transfers.index')
            ->with('success', 'Stock transferred successfully.');
    }
}