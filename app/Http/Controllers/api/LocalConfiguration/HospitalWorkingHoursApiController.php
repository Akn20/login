<?php

namespace App\Http\Controllers\Api\LocalConfiguration;

use App\Http\Controllers\Controller;
use App\Models\HospitalWorkingHour;
use Illuminate\Http\Request;

class HospitalWorkingHoursApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => HospitalWorkingHour::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'opening_time' => 'required',
            'closing_time' => 'required',
        ]);

        $workingHour = HospitalWorkingHour::create([
            'hospital_id' => $request->hospital_id ?? 1,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'break_start' => $request->break_start,
            'break_end' => $request->break_end,
            'emergency_24x7' => $request->boolean('emergency_24x7'),
            'status' => $request->status ?? 'Active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Working Hours Added Successfully',
            'data' => $workingHour
        ], 201);
    }

    public function show($id)
    {
        $workingHour = HospitalWorkingHour::find($id);

        if (!$workingHour) {
            return response()->json([
                'success' => false,
                'message' => 'Working Hours Not Found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $workingHour
        ]);
    }

    public function update(Request $request, $id)
    {
        $workingHour = HospitalWorkingHour::find($id);

        if (!$workingHour) {
            return response()->json([
                'success' => false,
                'message' => 'Working Hours Not Found'
            ], 404);
        }

        $request->validate([
            'opening_time' => 'required',
            'closing_time' => 'required',
        ]);

        $workingHour->update([
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'break_start' => $request->break_start,
            'break_end' => $request->break_end,
            'emergency_24x7' => $request->boolean('emergency_24x7'),
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Working Hours Updated Successfully',
            'data' => $workingHour->fresh()
        ]);
    }

    public function destroy($id)
    {
        $workingHour = HospitalWorkingHour::find($id);

        if (!$workingHour) {
            return response()->json([
                'success' => false,
                'message' => 'Working Hours Not Found'
            ], 404);
        }

        $workingHour->delete();

        return response()->json([
            'success' => true,
            'message' => 'Working Hours Deleted Successfully'
        ]);
    }
}