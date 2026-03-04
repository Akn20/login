<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Ward;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('ward')->latest()->get();

        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wards = Ward::all();

        return view('admin.rooms.create', compact('wards'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:50|unique:rooms,room_number',
            'ward_id' => 'required|exists:wards,id',
            'room_type' => 'required|string|max:50',
            'status' => 'required|in:available,occupied,maintenance,cleaning',
        ], [
            'ward_id.required' => 'Please select a ward.',
            'room_number.required' => 'Room number is required.',
            'room_number.unique' => 'Room number already exists.',
        ]);

        Room::create([
            'room_number' => $validated['room_number'],
            'ward_id' => $validated['ward_id'],
            'room_type' => $validated['room_type'],
            'total_beds' => 0, // default when room created
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room Created Successfully');
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
    public function edit(Room $room)
    {
        $wards = Ward::all();

        return view('admin.rooms.edit', compact('room', 'wards'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:50|unique:rooms,room_number,' . $room->id,
            'ward_id' => 'required|exists:wards,id',
            'room_type' => 'required|string|max:50',
            'status' => 'required|in:available,occupied,maintenance,cleaning',
        ]);

        // Store old room number before updating
        $oldRoomNumber = $room->room_number;

        // Update room
        $room->update([
            'room_number' => $validated['room_number'],
            'ward_id' => $validated['ward_id'],
            'room_type' => $validated['room_type'],
            'status' => $validated['status'],
        ]);

        // Update beds if room number changed
        \App\Models\Bed::where('room_number', $oldRoomNumber)
            ->update([
                'room_number' => $validated['room_number']
            ]);

        // Update room bed count
        $room->total_beds = \App\Models\Bed::where('room_number', $validated['room_number'])->count();
        $room->save();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room Updated Successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room Deleted Successfully');
    }

    /**
     * Deleted Rooms List
     */
    public function deleted()
    {
        $rooms = Room::onlyTrashed()->with('ward')->latest()->get();

        return view('admin.rooms.deleted', compact('rooms'));
    }

    /**
     * Restore Deleted Room
     */
    public function restore($id)
    {
        Room::onlyTrashed()->findOrFail($id)->restore();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room restored successfully');
    }

    /**
     * Permanently Delete Room
     */
    public function forceDelete($id)
    {
        Room::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()
            ->route('admin.rooms.deleted')
            ->with('success', 'Room permanently deleted');
    }


    /* ============================================================
       API INDEX
    ============================================================ */

    public function apiIndex()
    {
        return response()->json([
            'status' => true,
            'message' => 'Room list fetched successfully',
            'data' => Room::with('ward')->latest()->get()
        ]);
    }

    /* ============================================================
       API SHOW
    ============================================================ */

    public function apiShow($id)
    {
        $room = Room::with('ward')->find($id);

        if (!$room) {
            return response()->json([
                'status' => false,
                'message' => 'Room not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $room
        ]);
    }

    /* ============================================================
       API STORE
    ============================================================ */

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'room_number' => 'required|string|max:50|unique:rooms,room_number',
            'room_type' => 'nullable|string|max:50',
            'total_beds' => 'nullable|integer',
            'status' => 'required|in:available,occupied,maintenance,cleaning',
        ]);

        $room = Room::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Room created successfully',
            'data' => $room
        ], 201);
    }

    /* ============================================================
       API UPDATE
    ============================================================ */

    public function apiUpdate(Request $request, $id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json([
                'status' => false,
                'message' => 'Room not found'
            ], 404);
        }

        $validated = $request->validate([
            'ward_id' => 'sometimes|exists:wards,id',
            'room_number' => 'sometimes|string|max:50|unique:rooms,room_number,' . $id,
            'room_type' => 'sometimes|nullable|string|max:50',
            'total_beds' => 'sometimes|nullable|integer',
            'status' => 'sometimes|in:available,occupied,maintenance,cleaning',
        ]);

        $room->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Room updated successfully',
            'data' => $room
        ]);
    }

    /* ============================================================
       API DELETE (SOFT DELETE)
    ============================================================ */

    public function apiDelete($id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json([
                'status' => false,
                'message' => 'Room not found'
            ], 404);
        }

        $room->delete();

        return response()->json([
            'status' => true,
            'message' => 'Room deleted successfully'
        ]);
    }

    /* ============================================================
       API TRASH
    ============================================================ */

    public function apiTrash()
    {
        return response()->json([
            'status' => true,
            'data' => Room::onlyTrashed()->with('ward')->get()
        ]);
    }

    /* ============================================================
       API RESTORE
    ============================================================ */

    public function apiRestore($id)
    {
        $room = Room::onlyTrashed()->find($id);

        if (!$room) {
            return response()->json([
                'status' => false,
                'message' => 'Room not found in trash'
            ], 404);
        }

        $room->restore();

        return response()->json([
            'status' => true,
            'message' => 'Room restored successfully'
        ]);
    }

    /* ============================================================
       API FORCE DELETE
    ============================================================ */

    public function apiForceDelete($id)
    {
        $room = Room::onlyTrashed()->find($id);

        if (!$room) {
            return response()->json([
                'status' => false,
                'message' => 'Room not found in trash'
            ], 404);
        }

        $room->forceDelete();

        return response()->json([
            'status' => true,
            'message' => 'Room permanently deleted successfully'
        ]);
    }

    /* ============================================================
       API TOGGLE STATUS
    ============================================================ */

    public function apiToggleStatus($id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json([
                'status' => false,
                'message' => 'Room not found'
            ], 404);
        }

        $room->status = $room->status === 'available'
            ? 'maintenance'
            : 'available';

        $room->save();

        return response()->json([
            'status' => true,
            'message' => 'Status updated successfully',
            'data' => $room
        ]);
    }

    /* ============================================================
       GET ROOMS BY WARD
    ============================================================ */

    public function getRoomsByWard($id)
    {
        $rooms = Room::where('ward_id', $id)
            ->with('ward')
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Rooms fetched successfully',
            'data' => $rooms
        ]);
    }
}