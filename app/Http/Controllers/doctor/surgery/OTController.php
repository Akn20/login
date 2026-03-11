<?php

namespace App\Http\Controllers\doctor\surgery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surgery;
use App\Models\OTManagement;

class OTController extends Controller
{

    public function index()
    {
        $ots = OTManagement::with('surgery.patient')->latest()->get();

        return view('doctor.surgery.ot.index', compact('ots'));
    }

    public function create()
    {
        $surgeries = Surgery::with('patient', 'surgeon')->get();

        return view('doctor.surgery.ot.create', compact('surgeries'));
    }

    public function edit($id)
    {
        $ot = OTManagement::with('surgery.patient')->findOrFail($id);

        return view('doctor.surgery.ot.edit', compact('ot'));
    }

    public function store(Request $request)
    {

        OTManagement::updateOrCreate(

            ['surgery_id'=>$request->surgery_id],

            [

                'ot_room_used'=>$request->ot_room_used,
                'start_time'=>$request->start_time,
                'end_time'=>$request->end_time,
                'equipment_used'=>$request->equipment_used,
                'approval_status'=>$request->approval_status,
                'notes'=>$request->notes

            ]

        );

        return redirect()->route('ot.index')
        ->with('success','OT details saved');

    }

    public function update(Request $request, $id)
    {
        $ot = OTManagement::findOrFail($id);

        $ot->update([

            'ot_room_used'=>$request->ot_room_used,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time,
            'equipment_used'=>$request->equipment_used,
            'approval_status'=>$request->approval_status,
            'notes'=>$request->notes

        ]);

        return redirect()->route('ot.index')
        ->with('success','OT details updated');

    }

    public function destroy($id)
    {
        $ot = OTManagement::findOrFail($id);
        $ot->delete();

        return redirect()->route('ot.index')
        ->with('success','OT record deleted');
    }

    public function toggleStatus(Request $request, $id)
    {
        try {
            $ot = OTManagement::findOrFail($id);
            $ot->update([
                'approval_status' => $request->approval_status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }

}