<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ReturnMedicine;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index()
    {
        $returns = ReturnMedicine::latest()->get();
        return view('admin.pharmacy.return.index', compact('returns'));
    }

    public function create()
    {
        return view('admin.pharmacy.return.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'medicine_name' => 'required|string|max:255',
            'return_date'   => 'required|date',
            'quantity'      => 'required|integer|min:1',
        ]);

        ReturnMedicine::create($request->all());

        return redirect()->route('admin.returns.index')
            ->with('success', 'Return record created successfully.');
    }

    public function show($id)
    {
        $return = ReturnMedicine::findOrFail($id);
        return view('admin.pharmacy.return.show', compact('return'));
    }

    public function edit($id)
    {
        $return = ReturnMedicine::findOrFail($id);
        return view('admin.pharmacy.return.edit', compact('return'));
    }

    public function update(Request $request, $id)
    {
        $return = ReturnMedicine::findOrFail($id);

        $request->validate([
            'medicine_name' => 'required|string|max:255',
            'return_date'   => 'required|date',
            'quantity'      => 'required|integer|min:1',
        ]);

        $return->update($request->all());

        return redirect()->route('admin.returns.index')
            ->with('success', 'Return record updated successfully.');
    }

    public function destroy($id)
    {
        $return = ReturnMedicine::findOrFail($id);
        $return->delete();

        return redirect()->back()
            ->with('success', 'Return record moved to trash.');
    }

    public function trash()
    {
        $returns = ReturnMedicine::onlyTrashed()->get();
        return view('admin.pharmacy.return.trash', compact('returns'));
    }

    public function restore($id)
    {
        ReturnMedicine::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back()
            ->with('success', 'Return record restored successfully.');
    }

    public function forceDelete($id)
    {
        ReturnMedicine::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->back()
            ->with('success', 'Return record permanently deleted.');
    }
}