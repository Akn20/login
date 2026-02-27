<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Item::query();

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%");
            });
        }

        // Category filter
        if ($request->category) {
            $query->where('category', $request->category);
        }

        $items = $query->latest()->paginate(10);

        return view('admin.inventory.views.index', compact('items'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.inventory.views.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
{
    $request->validate([
        'name'           => 'required|string|max:255',
        'code'           => 'nullable|unique:items,code',
        'category'       => 'required',
        'stock'          => 'required|integer|min:0',
        'reorder_level'  => 'required|integer|min:0',
        'purchase_price' => 'nullable|numeric|min:0',
        'selling_price'  => 'nullable|numeric|min:0',
    ]);

    Item::create([
        'name'           => $request->name,
        'code'           => $request->code,
        'category'       => $request->category,
        'stock'          => $request->stock,
        'reorder_level'  => $request->reorder_level,
        'purchase_price' => $request->purchase_price,
        'selling_price'  => $request->selling_price,
    ]);

    return redirect()
        ->route('admin.inventory.index')
        ->with('success', 'Item created successfully.');
}

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $item = Item::findOrFail($id);

        return view('admin.inventory.views.edit', compact('item'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
{
    $item = Item::findOrFail($id);

    $request->validate([
        'name'           => 'required|string|max:255',
        'code'           => 'nullable|unique:items,code,' . $id,
        'category'       => 'required',
        'stock'          => 'required|integer|min:0',
        'reorder_level'  => 'required|integer|min:0',
        'purchase_price' => 'nullable|numeric|min:0',
        'selling_price'  => 'nullable|numeric|min:0',
    ]);

    $item->update([
        'name'           => $request->name,
        'code'           => $request->code,
        'category'       => $request->category,
        'stock'          => $request->stock,
        'reorder_level'  => $request->reorder_level,
        'purchase_price' => $request->purchase_price,
        'selling_price'  => $request->selling_price,
    ]);

    return redirect()
        ->route('admin.inventory.index')
        ->with('success', 'Item updated successfully.');
}

    /*
    |--------------------------------------------------------------------------
    | DELETE (Soft Delete)
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Item moved to trash.');
    }

    /*
    |--------------------------------------------------------------------------
    | TRASH LIST
    |--------------------------------------------------------------------------
    */

    public function deleted()
    {
        $items = Item::onlyTrashed()->paginate(10);

        return view('admin.inventory.views.deleted', compact('items'));
    }

    /*
    |--------------------------------------------------------------------------
    | RESTORE
    |--------------------------------------------------------------------------
    */

    public function restore($id)
    {
        $item = Item::onlyTrashed()->findOrFail($id);
        $item->restore();

        return back()->with('success', 'Item restored successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | FORCE DELETE
    |--------------------------------------------------------------------------
    */

    public function forceDelete($id)
    {
        $item = Item::onlyTrashed()->findOrFail($id);
        $item->forceDelete();

        return back()->with('success', 'Item permanently deleted.');
    }

    /*
    |--------------------------------------------------------------------------
    | TOGGLE STATUS
    |--------------------------------------------------------------------------
    */

    public function toggleStatus($id)
    {
        $item = Item::findOrFail($id);

        $item->status = $item->status === 'active'
            ? 'inactive'
            : 'active';

        $item->save();

        return back()->with('success', 'Item status updated.');
    }
}