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
    /* ============================================================
   API SECTION
============================================================ */

    public function apiIndex()
    {
        return response()->json([
            'status' => true,
            'message' => 'Ward list fetched successfully',
            'data' => Ward::latest()->get()
        ]);
    }

    /* ============================================================
       API SHOW
    ============================================================ */

    public function apiShow($id)
    {
        $ward = Ward::find($id);

        if (!$ward) {
            return response()->json([
                'status' => false,
                'message' => 'Ward not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $ward
        ]);
    }

    /* ============================================================
       API STORE
    ============================================================ */

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'ward_name' => 'required|string|max:100',
            'ward_type' => 'nullable|string|max:50',
            'floor_number' => 'nullable|integer',
            'total_beds' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $ward = Ward::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Ward created successfully',
            'data' => $ward
        ], 201);
    }

    /* ============================================================
       API UPDATE
    ============================================================ */

    public function apiUpdate(Request $request, $id)
    {
        $ward = Ward::find($id);

        if (!$ward) {
            return response()->json([
                'status' => false,
                'message' => 'Ward not found'
            ], 404);
        }

        $validated = $request->validate([
            'ward_name' => 'sometimes|string|max:100',
            'ward_type' => 'sometimes|nullable|string|max:50',
            'floor_number' => 'sometimes|nullable|integer',
            'total_beds' => 'sometimes|nullable|integer',
            'status' => 'sometimes|boolean',
        ]);

        $ward->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Ward updated successfully',
            'data' => $ward
        ]);
    }

    /* ============================================================
       API DELETE (SOFT DELETE)
    ============================================================ */

    public function apiDelete($id)
    {
        $ward = Ward::find($id);

        if (!$ward) {
            return response()->json([
                'status' => false,
                'message' => 'Ward not found'
            ], 404);
        }

        $ward->delete();

        return response()->json([
            'status' => true,
            'message' => 'Ward deleted successfully'
        ]);
    }

    /* ============================================================
       API FORCE DELETE (PERMANENT DELETE)
    ============================================================ */

    public function apiForceDelete($id)
    {
        $ward = Ward::onlyTrashed()->find($id);

        if (!$ward) {
            return response()->json([
                'status' => false,
                'message' => 'Ward not found in trash'
            ], 404);
        }

        $ward->forceDelete();

        return response()->json([
            'status' => true,
            'message' => 'Ward permanently deleted successfully'
        ]);
    }
    /* ============================================================
   API TOGGLE STATUS
============================================================ */

    public function apiToggleStatus($id)
    {
        $ward = Ward::find($id);

        if (!$ward) {
            return response()->json([
                'status' => false,
                'message' => 'Ward not found'
            ], 404);
        }

        $ward->status = !$ward->status;
        $ward->save();

        return response()->json([
            'status' => true,
            'message' => 'Status updated successfully',
            'data' => $ward
        ]);
    }
    /* ============================================================
API Trash List
============================================================ */
    public function apiTrash()
    {
        return response()->json([
            'status' => true,
            'message' => 'Deleted wards fetched successfully',
            'data' => Ward::onlyTrashed()->latest()->get()
        ]);
    }

    /* ============================================================
       API Restore
    ============================================================ */

    public function apiRestore($id)
    {
        $ward = Ward::withTrashed()->find($id);

        if (!$ward) {
            return response()->json([
                'status' => false,
                'message' => 'Ward not found'
            ], 404);
        }

        $ward->restore();

        return response()->json([
            'status' => true,
            'message' => 'Ward restored successfully',
            'data' => $ward
        ]);
    }
}