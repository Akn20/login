<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'item_id',
        'quantity',
        'unit_price',
        'total'
    ];


    public function item()
    {
        return $this->belongsTo(Item::class);
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
}