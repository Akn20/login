<?php

namespace App\Http\Controllers\Api\Surgery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OTManagement;

class OTApiController extends Controller
{

    // List all OT records
    public function index()
    {
        $ots = OTManagement::with('surgery.patient')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $ots
        ]);
    }

    // Create OT record
    public function store(Request $request)
    {
        $request->validate([
            'surgery_id' => 'required|exists:surgeries,id',
        ]);

        // $ot = OTManagement::updateOrCreate(

        //     ['surgery_id' => $request->surgery_id],

        //     [
        //         'ot_room_used' => $request->ot_room_used,
        //         'start_time' => $request->start_time,
        //         'end_time' => $request->end_time,
        //         'equipment_used' => $request->equipment_used,
        //         'approval_status' => $request->approval_status ?? 'Not Approved',
        //         'notes' => $request->notes
        //     ]
        // );
         $ot = OTManagement::create([
    'surgery_id' => $request->surgery_id,
    'ot_room_used' => $request->ot_room_used,
    'start_time' => $request->start_time,
    'end_time' => $request->end_time,
    'equipment_used' => $request->equipment_used,
    'approval_status' => $request->approval_status ?? 'Not Approved',
    'notes' => $request->notes
]);
        return response()->json([
            'success' => true,
            'message' => 'OT record saved successfully',
            'data' => $ot
        ]);
    }

    // Show single OT
    public function show($id)
    {
        $ot = OTManagement::with('surgery.patient')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $ot
        ]);
    }

    // Update OT
    public function update(Request $request, $id)
    {
        $ot = OTManagement::findOrFail($id);

        $ot->update([
            'ot_room_used' => $request->ot_room_used,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'equipment_used' => $request->equipment_used,
            'approval_status' => $request->approval_status,
            'notes' => $request->notes
        ]);

        return response()->json([
            'success' => true,
            'message' => 'OT record updated successfully',
            'data' => $ot
        ]);
    }

    // Delete OT
    public function destroy($id)
    {
        $ot = OTManagement::findOrFail($id);
        $ot->delete();

        return response()->json([
            'success' => true,
            'message' => 'OT record deleted'
        ]);
    }

    // Toggle approval status
    public function toggleStatus(Request $request, $id)
    {
        $ot = OTManagement::findOrFail($id);

        $ot->update([
            'approval_status' => $request->approval_status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated',
            'data' => $ot
        ]);
    }
}