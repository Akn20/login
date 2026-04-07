<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PpeComplianceLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    // ==================== API METHODS ====================

    public function apiIndex()
    {
        return response()->json([
            'data' => PpeComplianceLog::with(['patient', 'nurse'])
                ->whereNull('deleted_at')
                ->get()
        ]);
    }

    public function apiShow($id)
    {
        $log = PpeComplianceLog::with(['patient', 'nurse'])
            ->whereNull('deleted_at')
            ->find($id);

        if (!$log) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => $log]);
    }

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'ppe_used' => 'required|boolean',
            'ppe_type' => 'nullable|string',
            'compliance_status' => 'required|in:compliant,partial,non-compliant',
            'notes' => 'nullable|string'
        ]);

        $validated['id'] = Str::uuid();
        $validated['nurse_id'] = auth()->user()->id ?? 1;
        $validated['recorded_at'] = now();

        $log = PpeComplianceLog::create($validated);

        return response()->json(['data' => $log->load(['patient', 'nurse'])], 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $log = PpeComplianceLog::whereNull('deleted_at')->find($id);

        if (!$log) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validated = $request->validate([
            'ppe_type' => 'nullable|string',
            'ppe_used' => 'nullable|boolean',
            'compliance_status' => 'sometimes|in:compliant,partial,non-compliant',
            'notes' => 'nullable|string'
        ]);

        $log->update($validated);

        return response()->json(['data' => $log->load(['patient', 'nurse'])]);
    }

    public function apiDestroy($id)
    {
        $log = PpeComplianceLog::whereNull('deleted_at')->find($id);

        if (!$log) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $log->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    public function apiTrash()
    {
        Log::info('Fetching deleted PPE compliance records');
        $logs = PpeComplianceLog::with(['patient', 'nurse'])
            ->onlyTrashed()
            ->get();
        Log::info('Found deleted PPE records: ' . count($logs));
        return response()->json([
            'data' => $logs
        ]);
    }

    public function apiRestore($id)
    {
        $log = PpeComplianceLog::withTrashed()->find($id);

        if (!$log || !$log->trashed()) {
            return response()->json(['message' => 'Record not found or not deleted'], 404);
        }

        $log->restore();

        return response()->json(['message' => 'Restored successfully', 'data' => $log->load(['patient', 'nurse'])]);
    }

    public function apiForceDelete($id)
    {
        $log = PpeComplianceLog::withTrashed()->find($id);

        if (!$log) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $log->forceDelete();

        return response()->json(['message' => 'Permanently deleted']);
    }

    public function apiGetByPatient($patientId)
    {
        return response()->json([
            'data' => PpeComplianceLog::where('patient_id', $patientId)
                ->with(['patient', 'nurse'])
                ->whereNull('deleted_at')
                ->get()
        ]);
    }

    public function apiGetByStatus($status)
    {
        return response()->json([
            'data' => PpeComplianceLog::where('compliance_status', $status)
                ->with(['patient', 'nurse'])
                ->whereNull('deleted_at')
                ->get()
        ]);
    }

    public function apiGetReport()
    {
        $report = [
            'total_logs' => PpeComplianceLog::whereNull('deleted_at')->count(),
            'compliant' => PpeComplianceLog::where('compliance_status', 'compliant')->whereNull('deleted_at')->count(),
            'partial' => PpeComplianceLog::where('compliance_status', 'partial')->whereNull('deleted_at')->count(),
            'non_compliant' => PpeComplianceLog::where('compliance_status', 'non-compliant')->whereNull('deleted_at')->count(),
            'compliance_rate' => PpeComplianceLog::where('compliance_status', 'compliant')->whereNull('deleted_at')->count() / max(PpeComplianceLog::whereNull('deleted_at')->count(), 1) * 100
        ];

        return response()->json(['data' => $report]);
    }
}