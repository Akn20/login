<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vital;
use App\Models\MedicationAdministration;

class NurseReportController extends Controller
{
    public function vitals(Request $request)
    {
        $query = Vital::with(['patient', 'nurse']);

        // ✅ Filter: Patient
        if ($request->patient_id) {
            $query->where('patient_id', $request->patient_id);
        }

        // ✅ Filter: Date Range (IMPORTANT: use recorded_at)
        if ($request->from && $request->to) {
            $query->whereBetween('recorded_at', [
                $request->from,
                $request->to
            ]);
        }

        

        $vitals = $query->orderBy('recorded_at', 'desc')->paginate(10);

        return view('admin.nurse.reports.vitals', compact('vitals'));
    }

    public function medications(Request $request)
{
    $query = MedicationAdministration::with(['patient', 'nurse']);

    if ($request->patient_id) {
        $query->where('patient_id', $request->patient_id);
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $data = $query->orderBy('administered_time', 'desc')->paginate(10);

    return view('admin.nurse.reports.medication', compact('data'));
}
public function index()
{
    return view('admin.nurse.reports.index');
}
}
