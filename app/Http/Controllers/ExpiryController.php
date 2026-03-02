<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expiry;
use Illuminate\Http\Request;

class ExpiryController extends Controller
{
    public function index()
    {
        $expiries = Expiry::latest()->get();
        return view('admin.pharmacy.expiry.index', compact('expiries'));
    }

    public function create()
    {
        return view('admin.pharmacy.expiry.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'medicine_name' => 'required|string|max:255',
            'expiry_date'   => 'required|date',
            'quantity'      => 'nullable|integer|min:1',
        ]);

        Expiry::create($request->all());

        return redirect()->route('admin.expiries.index')
            ->with('success', 'Expiry record created successfully.');
    }

    public function show($id)
    {
        $expiry = Expiry::findOrFail($id);
        return view('admin.pharmacy.expiry.show', compact('expiry'));
    }

    public function edit($id)
    {
        $expiry = Expiry::findOrFail($id);
        return view('admin.pharmacy.expiry.edit', compact('expiry'));
    }

    public function update(Request $request, $id)
    {
        $expiry = Expiry::findOrFail($id);

        $request->validate([
            'medicine_name' => 'required|string|max:255',
            'expiry_date'   => 'required|date',
            'quantity'      => 'nullable|integer|min:1',
        ]);

        $expiry->update($request->all());

        return redirect()->route('admin.expiries.index')
            ->with('success', 'Expiry record updated successfully.');
    }

    public function destroy($id)
    {
        $expiry = Expiry::findOrFail($id);
        $expiry->delete();

        return redirect()->back()
            ->with('success', 'Expiry record moved to trash.');
    }

    public function trash()
    {
        $expiries = Expiry::onlyTrashed()->get();
        return view('admin.pharmacy.expiry.trash', compact('expiries'));
    }

    public function restore($id)
    {
        Expiry::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back()
            ->with('success', 'Expiry record restored successfully.');
    }

    public function forceDelete($id)
    {
        Expiry::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->back()
            ->with('success', 'Expiry record permanently deleted.');
    }
}