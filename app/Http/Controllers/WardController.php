<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    /* ================= INDEX ================= */

    public function index(Request $request)
    {
        $query = Ward::query();

        if ($request->filled('search')) {
            $query->where('ward_name', 'like', '%' . $request->search . '%');
        }

        $wards = $query->latest()->paginate(10);

        return view('admin.ward.index', compact('wards'));
    }

    /* ================= CREATE ================= */

    public function create()
    {
        return view('admin.ward.create');
    }

    /* ================= STORE ================= */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ward_name' => 'required|string|max:255',
            'ward_type' => 'required|string|max:100',
            'floor_number' => 'required|integer|min:0',
            'total_beds' => 'required|integer|min:1',
            'status' => 'required|boolean',
        ]);

        Ward::create($validated);

        return redirect()
            ->route('admin.ward.index')
            ->with('success', 'Ward created successfully');
    }

    /* ================= SHOW ================= */

    public function show($id)
    {
        $ward = Ward::findOrFail($id);

        return view('admin.ward.show', compact('ward'));
    }

    /* ================= EDIT ================= */

    public function edit($id)
    {
        $ward = Ward::findOrFail($id);

        return view('admin.ward.edit', compact('ward'));
    }

    /* ================= UPDATE ================= */

    public function update(Request $request, $id)
    {
        $ward = Ward::findOrFail($id);

        $validated = $request->validate([
            'ward_name' => 'required|string|max:255',
            'ward_type' => 'required|string|max:100',
            'floor_number' => 'required|integer|min:0',
            'total_beds' => 'required|integer|min:1',
            'status' => 'required|boolean',
        ]);

        $ward->update($validated);

        return redirect()
            ->route('admin.ward.index')
            ->with('success', 'Ward updated successfully');
    }

    /* ================= DELETE ================= */

    public function destroy($id)
    {
        Ward::findOrFail($id)->delete();

        return redirect()
            ->route('admin.ward.index')
            ->with('success', 'Ward deleted successfully');
    }

    /* ================= DELETED LIST ================= */

    public function deleted()
    {
        $wards = Ward::onlyTrashed()->latest()->paginate(10);

        return view('admin.ward.deleted', compact('wards'));
    }

    /* ================= RESTORE ================= */

    public function restore($id)
    {
        Ward::onlyTrashed()->findOrFail($id)->restore();

        return redirect()
            ->route('admin.ward.deleted')
            ->with('success', 'Ward restored successfully');
    }

    /* ================= FORCE DELETE ================= */

    public function forceDelete($id)
    {
        Ward::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()
            ->route('admin.ward.deleted')
            ->with('success', 'Ward permanently deleted');
    }

    /* ================= STATUS TOGGLE ================= */

    public function toggleStatus($id)
    {
        $ward = Ward::findOrFail($id);

        $ward->status = !$ward->status;
        $ward->save();

        return back()->with('success', 'Status updated');
    }
}