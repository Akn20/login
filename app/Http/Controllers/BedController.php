<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bed;
use App\Models\Ward;
use App\Models\Room;
use Illuminate\Validation\Rule;

class BedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beds = Bed::with('ward')->latest()->get();
        return view('admin.beds.index', compact('beds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wards = Ward::all();
        $bed = null;
        $rooms = Room::all();

        return view('admin.beds.create', compact('wards', 'bed', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ward_id' => 'required|uuid|exists:wards,id',
            'room_number' => 'required|string|max:50',
            'bed_type' => 'required|string|max:50',
            'status' => 'required|string|max:20',
        ]);

        $ward = Ward::findOrFail($validated['ward_id']);

        // Generate bed code automatically
        $prefix = strtoupper(substr($ward->ward_name, 0, 3));

        $count = Bed::where('ward_id', $ward->id)->count() + 1;

        $bedCode = $prefix . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        $bed = Bed::create([
            'bed_code' => $bedCode,
            'ward_id' => $validated['ward_id'],
            'room_number' => $validated['room_number'],
            'bed_type' => $validated['bed_type'],
            'status' => $validated['status'],
        ]);

        // Update ward bed count
        Ward::where('id', $ward->id)->update([
            'total_beds' => Bed::where('ward_id', $ward->id)->count()
        ]);

        return redirect()
            ->route('admin.beds.index')
            ->with('success', 'Bed created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bed = Bed::findOrFail($id);
        $wards = Ward::all();
        $rooms = Room::all();

        return view('admin.beds.edit', compact('bed', 'wards', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $bed = Bed::findOrFail($id);

        // Store old values before update
        $oldWardId = $bed->ward_id;
        $oldRoomNumber = $bed->room_number;

        $validated = $request->validate([
            'bed_code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('beds', 'bed_code')->ignore($bed->id),
            ],
            'ward_id' => 'required|uuid|exists:wards,id',
            'room_number' => 'nullable|string|max:50',
            'bed_type' => 'required|string|max:50',
            'status' => 'required|string|max:20',
        ]);

        // Update bed
        $bed->update($validated);

        /*
        |--------------------------------------------------------------------------
        | Update Ward Bed Counts
        |--------------------------------------------------------------------------
        */

        // Old ward
        Ward::where('id', $oldWardId)->update([
            'total_beds' => Bed::where('ward_id', $oldWardId)->count()
        ]);

        // New ward
        Ward::where('id', $validated['ward_id'])->update([
            'total_beds' => Bed::where('ward_id', $validated['ward_id'])->count()
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Room Bed Counts
        |--------------------------------------------------------------------------
        */

        // Old room
        Room::where('room_number', $oldRoomNumber)->update([
            'total_beds' => Bed::where('room_number', $oldRoomNumber)->count()
        ]);

        // New room
        Room::where('room_number', $validated['room_number'])->update([
            'total_beds' => Bed::where('room_number', $validated['room_number'])->count()
        ]);

        return redirect()
            ->route('admin.beds.index')
            ->with('success', 'Bed updated successfully');
    }

    /**
     * Suggest BedCode based on ward
     */
    public function generateCode($wardId)
    {
        $ward = Ward::findOrFail($wardId);

        $prefix = strtoupper(substr($ward->ward_name, 0, 3));

        $count = Bed::where('ward_id', $wardId)->count() + 1;

        $number = str_pad($count, 3, '0', STR_PAD_LEFT);

        $code = $prefix . '-' . $number;

        return response()->json(['code' => $code]);
    }

    /**
     * Soft delete list
     */
    public function deleted()
    {
        $beds = Bed::onlyTrashed()->with('ward')->latest()->get();

        return view('admin.beds.deleted', compact('beds'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bed = Bed::findOrFail($id);

        $wardId = $bed->ward_id;

        $bed->delete();

        Ward::where('id', $wardId)->update([
            'total_beds' => Bed::where('ward_id', $wardId)->count()
        ]);

        return redirect()
            ->route('admin.beds.index')
            ->with('success', 'Bed moved to trash successfully');
    }

    /**
     * Restore deleted bed
     */
    public function restore($id)
    {
        $bed = Bed::onlyTrashed()->findOrFail($id);

        $bed->restore();

        Ward::where('id', $bed->ward_id)->update([
            'total_beds' => Bed::where('ward_id', $bed->ward_id)->count()
        ]);

        return redirect()
            ->route('admin.beds.deleted')
            ->with('success', 'Bed restored successfully.');
    }

    /**
     * Permanently delete
     */
    public function forceDelete($id)
    {
        $bed = Bed::onlyTrashed()->findOrFail($id);

        $wardId = $bed->ward_id;

        $bed->forceDelete();

        Ward::where('id', $wardId)->update([
            'total_beds' => Bed::where('ward_id', $wardId)->count()
        ]);

        return redirect()
            ->route('admin.beds.deleted')
            ->with('success', 'Bed permanently deleted.');
    }

    /**
     * API - Get beds
     */
    public function apiIndex()
    {
        $beds = Bed::with('ward')->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $beds
        ]);
    }

    /**
     * API - Store bed
     */
    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'bed_code' => 'required|string|max:100|unique:beds,bed_code',
            'ward_id' => 'required|uuid|exists:wards,id',
            'room_number' => 'nullable|string|max:50',
            'bed_type' => 'required|string|max:50',
            'status' => 'required|string|max:20',
        ]);

        $bed = Bed::create($validated);

        Ward::where('id', $validated['ward_id'])->update([
            'total_beds' => Bed::where('ward_id', $validated['ward_id'])->count()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Bed created successfully',
            'data' => $bed
        ], 201);
    }

    /**
     * API - Show
     */
    public function apiShow($id)
    {
        $bed = Bed::with('ward')->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $bed
        ]);
    }

    /**
     * API - Update
     */
    public function apiUpdate(Request $request, $id)
    {
        $bed = Bed::findOrFail($id);

        $validated = $request->validate([
            'bed_code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('beds', 'bed_code')->ignore($bed->id),
            ],
            'ward_id' => 'required|uuid|exists:wards,id',
            'room_number' => 'nullable|string|max:50',
            'bed_type' => 'required|string|max:50',
            'status' => 'required|string|max:20',
        ]);

        $bed->update($validated);

        Ward::where('id', $validated['ward_id'])->update([
            'total_beds' => Bed::where('ward_id', $validated['ward_id'])->count()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Bed updated successfully',
            'data' => $bed
        ]);
    }

    /**
     * API - Soft delete
     */
    public function apiDelete($id)
    {
        $bed = Bed::findOrFail($id);

        $wardId = $bed->ward_id;

        $bed->delete();

        Ward::where('id', $wardId)->update([
            'total_beds' => Bed::where('ward_id', $wardId)->count()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Bed deleted successfully'
        ]);
    }

    /**
     * API - Permanent delete
     */
    public function forceDeleteApi($id)
    {
        $bed = Bed::onlyTrashed()->findOrFail($id);

        $wardId = $bed->ward_id;

        $bed->forceDelete();

        Ward::where('id', $wardId)->update([
            'total_beds' => Bed::where('ward_id', $wardId)->count()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Bed permanently deleted'
        ]);
    }

    /**
     * API - Trash list
     */
    public function trash()
    {
        $beds = Bed::onlyTrashed()->with('ward')->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $beds
        ]);
    }

    /**
     * API - Restore
     */
    public function apiRestore($id)
    {
        $bed = Bed::onlyTrashed()->findOrFail($id);

        $bed->restore();

        Ward::where('id', $bed->ward_id)->update([
            'total_beds' => Bed::where('ward_id', $bed->ward_id)->count()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Bed restored successfully'
        ]);
    }
}