<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmergencyCase;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

class EmergencyCaseController extends Controller
{
    public function create()
    {
        $patients = Patient::latest()->get();
        return view('admin.Receptionist.emergency.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'emergency_type' => 'required'
        ]);

        EmergencyCase::create([
            'patient_id' => $request->patient_id,
            'patient_name' => $request->patient_name ?? 'Unknown',
            'gender' => $request->gender,
            'age' => $request->age,
            'mobile' => $request->mobile,
            'emergency_type' => $request->emergency_type,
            'created_by' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Emergency patient registered successfully!');
    }
}
