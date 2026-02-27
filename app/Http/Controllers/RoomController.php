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
        $rooms = Room::with('ward')->get();
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
        $request->validate([
        'room_number' => 'required|string|max:50|unique:rooms,room_number',
        'ward_id' => 'required|exists:wards,id',
        'room_type' => 'required|string|max:50',
        'total_beds' => 'required|integer|min:1',
        'status' => 'required|in:available,occupied,maintenance,cleaning',
    ], [
        'ward_id.required' => 'Please select a ward.',
        'room_number.required' => 'Room number is required.',
        'room_number.unique' => 'Room number already exists.',
        'total_beds.min' => 'Room must have at least 1 bed.'
    ]);

    Room::create($request->all());

    return redirect()->route('admin.rooms.index')
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
        return view('admin.rooms.edit', compact('room','wards'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms,room_number,' . $room->id,
            'ward_id' => 'required|exists:wards,id',
            'room_type' => 'required|string|max:50',
            'total_beds' => 'required|integer|min:1',
            'status' => 'required|in:available,occupied,maintenance,cleaning'
        ]);

        $room->update($request->all());

        return redirect()->route('admin.rooms.index')
                         ->with('success', 'Room Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')
                     ->with('success', 'Room Deleted Successfully');
    }

    //deleted rooms
    public function deleted()
    {
        $rooms = Room::onlyTrashed()->get();
        return view('admin.rooms.deleted', compact('rooms'));
    }

    //restore
    public function restore($id)
    {
        Room::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.rooms.index');
    }

    //forcedelete
    public function forceDelete($id)
    {
        Room::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.rooms.deleted');
    }
}

