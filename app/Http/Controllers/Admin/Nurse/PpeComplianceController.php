<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PpeComplianceLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PpeComplianceController extends Controller
{
    public function index()
    {
        $logs = PpeComplianceLog::with('patient')->latest()->get();
        return view('admin.nurse.ppe.index', compact('logs'));
    }

    public function create()
    {
        $patients = DB::table('patients')->get();
        return view('admin.nurse.ppe.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'ppe_used' => 'required|in:0,1',
        ]);

        // 🔥 LOGIC FIX
        if ($request->ppe_used == 0) {
            $ppe_type = null;
            $compliance_status = 'Non-compliant';
        } else {
            if (!$request->ppe_type) {
                return back()->withErrors(['ppe_type' => 'PPE type required'])->withInput();
            }

            $ppe_type = $request->ppe_type;
            $compliance_status = $request->compliance_status ?? 'Compliant';
        }

        PpeComplianceLog::create([
            'id' => \Str::uuid(),
            'patient_id' => $request->patient_id,
            'nurse_id' => 1,
            'ppe_used' => $request->ppe_used,
            'ppe_type' => $ppe_type,
            'compliance_status' => $compliance_status,
            'notes' => $request->notes,
            'recorded_at' => now()
        ]);

        return redirect()->route('admin.ppe.index')->with('success', 'Added');
    }

    public function edit($id)
    {
        $log = PpeComplianceLog::findOrFail($id);
        $patients = DB::table('patients')->get();

        return view('admin.nurse.ppe.edit', compact('log', 'patients'));
    }

    public function update(Request $request, $id)
    {
        $log = PpeComplianceLog::findOrFail($id);

        if ($request->ppe_used == 0) {
            $ppe_type = null;
            $compliance_status = 'Non-compliant';
        } else {
            $ppe_type = $request->ppe_type;
            $compliance_status = $request->compliance_status;
        }

        $log->update([
            'patient_id' => $request->patient_id,
            'ppe_used' => $request->ppe_used,
            'ppe_type' => $ppe_type,
            'compliance_status' => $compliance_status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.ppe.index')->with('success', 'Updated');
    }

    public function destroy($id)
    {
        PpeComplianceLog::findOrFail($id)->delete();
        return back()->with('success', 'Deleted');
    }

    public function trash()
    {
        $logs = PpeComplianceLog::onlyTrashed()->get();
        return view('admin.nurse.ppe.trash', compact('logs'));
    }

    public function restore($id)
    {
        PpeComplianceLog::withTrashed()->where('id', $id)->restore();
        return back()->with('success', 'Restored');
    }

    public function forceDelete($id)
    {
        PpeComplianceLog::withTrashed()->where('id', $id)->forceDelete();
        return back()->with('success', 'Deleted permanently');
    }
}