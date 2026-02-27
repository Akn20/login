<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Item::all()
        ]);
    }

    public function store(Request $request)
{
    $item = Item::create([
        'name' => $request->name,
        'code' => $request->code,
        'category' => $request->category,
        'unit' => $request->unit,
        'purchase_price' => $request->purchase_price,
        'reorder_level' => $request->reorder_level,
        'status' => 'active'
    ]);

    return response()->json($item);
}
}