<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemApiController extends Controller
{
    public function index()
    {
        return Item::latest()->get();
    }

    public function show($id)
    {
        return Item::findOrFail($id);
    }

    public function store(Request $request)
    {
        $item = Item::create($request->all());
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->update($request->all());
        return response()->json($item);
    }

    public function destroy($id)
    {
        Item::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}