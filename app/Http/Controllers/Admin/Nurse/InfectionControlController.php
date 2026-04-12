<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InfectionControlLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class InfectionControlController extends Controller
{

    // 🔷 INDEX
    public function index()
    {
        $logs = InfectionControlLog::with(['patient', 'nurse'])
            ->whereNull('deleted_at')
            ->latest()
            ->get();

        return view('admin.nurse.infection.index', compact('logs'));
    }

    // 🔷 CREATE
    public function create()
    {
        $patients = DB::table('patients')->whereNull('deleted_at')->get();

        return view('admin.nurse.infection.create', compact('patients'));
    }

    // 🔷 STORE
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'infection_type' => 'required',
            'severity' => 'required',
            'status' => 'required'
        ]);

        InfectionControlLog::create([
            'id' => Str::uuid(),
            'patient_id' => $request->patient_id,
            'nurse_id' => 1, // same approach as medication
            'infection_type' => $request->infection_type,
            'severity' => $request->severity,
            'status' => $request->status,
            'notes' => $request->notes,
            'recorded_at' => now()
        ]);

        return redirect()->route('admin.infection.index')->with('success', 'Infection log added');
    }

    // 🔷 EDIT
    public function edit($id)
    {
        $log = InfectionControlLog::findOrFail($id);
        $patients = DB::table('patients')->whereNull('deleted_at')->get();

        return view('admin.nurse.infection.edit', compact('log', 'patients'));
    }

    // 🔷 UPDATE
    public function update(Request $request, $id)
    {
        $log = InfectionControlLog::findOrFail($id);

        $log->update([
            'patient_id' => $request->patient_id,
            'infection_type' => $request->infection_type,
            'severity' => $request->severity,
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return redirect()->route('admin.infection.index')->with('success', 'Updated successfully');
    }

    // 🔷 SOFT DELETE
    public function destroy($id)
    {
        $log = InfectionControlLog::findOrFail($id);
        $log->delete();

        return back()->with('success', 'Moved to trash');
    }

    // 🔷 TRASH
    public function trash()
    {
        $logs = InfectionControlLog::onlyTrashed()->get();

        return view('admin.nurse.infection.trash', compact('logs'));
    }

    // 🔷 RESTORE
    public function restore($id)
    {
        InfectionControlLog::withTrashed()->where('id', $id)->restore();

        return back()->with('success', 'Restored');
    }

    // 🔷 FORCE DELETE
    public function forceDelete($id)
    {
        InfectionControlLog::withTrashed()->where('id', $id)->forceDelete();

        return back()->with('success', 'Deleted permanently');
    }

    /*
    |--------------------------------------------------------------------------
    | 📱 API METHODS (Mobile & Web Services)
    |--------------------------------------------------------------------------
    */

    // 🔷 API INDEX - Get all infection control logs
    public function apiIndex()
    {
        $logs = InfectionControlLog::with(['patient', 'nurse'])
            ->whereNull('deleted_at')
            ->latest()
            ->get();

        return response()->json(['data' => $logs], 200);
    }

    // 🔷 API STORE - Create new infection control log
    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|uuid|exists:patients,id',
            'infection_type' => 'required|string',
            'severity' => 'required|in:Low,Medium,High',
            'status' => 'required|in:Active,Recovered,Under-Observation',
            'nurse_id' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'recorded_at' => 'nullable|date_format:Y-m-d H:i:s'
        ]);

        // Handle nurse_id fallback - use numeric ID (staff/nurse ID)
        if (!isset($validated['nurse_id']) || !$validated['nurse_id']) {
            // Try to get a staff member with numeric ID, fallback to 1
            $nurse = DB::table('staff')->first();
            $validated['nurse_id'] = $nurse ? $nurse->id : 1;
        }

        // Ensure nurse_id is numeric (cast to int)
        $validated['nurse_id'] = (int) $validated['nurse_id'];

        $log = InfectionControlLog::create([
            'id' => Str::uuid(),
            'patient_id' => $validated['patient_id'],
            'nurse_id' => $validated['nurse_id'],
            'infection_type' => $validated['infection_type'],
            'severity' => $validated['severity'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
            'recorded_at' => $validated['recorded_at'] ?? now()
        ]);

        return response()->json([
            'data' => $log->load(['patient', 'nurse']),
            'message' => 'Infection log created successfully'
        ], 201);
    }

    // 🔷 API SHOW - Get specific infection log
    public function apiShow($id)
    {
        $log = InfectionControlLog::with(['patient', 'nurse'])->findOrFail($id);

        return response()->json(['data' => $log], 200);
    }

    // 🔷 API UPDATE - Update infection log
    public function apiUpdate(Request $request, $id)
    {
        $log = InfectionControlLog::findOrFail($id);

        $validated = $request->validate([
            'patient_id' => 'sometimes|uuid|exists:patients,id',
            'infection_type' => 'sometimes|string',
            'severity' => 'sometimes|in:Low,Medium,High',
            'status' => 'sometimes|in:Active,Recovered,Under-Observation',
            'notes' => 'nullable|string',
            'recorded_at' => 'nullable|date_format:Y-m-d H:i:s'
        ]);

        $log->update($validated);

        return response()->json([
            'data' => $log->load(['patient', 'nurse']),
            'message' => 'Infection log updated successfully'
        ], 200);
    }

    // 🔷 API DESTROY - Soft delete infection log
    public function apiDestroy($id)
    {
        $log = InfectionControlLog::findOrFail($id);
        $log->delete();

        return response()->json([
            'message' => 'Infection log moved to trash'
        ], 200);
    }

    // 🔷 API TRASH - Get soft-deleted logs
    public function apiTrash()
    {
        Log::info('Fetching deleted records');
        $logs = InfectionControlLog::with(['patient', 'nurse'])
            ->onlyTrashed()
            ->get();
        Log::info('Found deleted records: ' . count($logs));
        return response()->json(['data' => $logs], 200);
    }

    // 🔷 API RESTORE - Restore soft-deleted log
    public function apiRestore($id)
    {
        $log = InfectionControlLog::withTrashed()->findOrFail($id);

        if (!$log->trashed()) {
            return response()->json([
                'message' => 'This log has not been deleted'
            ], 400);
        }

        $log->restore();

        return response()->json([
            'data' => $log->load(['patient', 'nurse']),
            'message' => 'Infection log restored successfully'
        ], 200);
    }

    // 🔷 API FORCE DELETE - Permanently delete log
    public function apiForceDelete($id)
    {
        $log = InfectionControlLog::withTrashed()->findOrFail($id);
        $log->forceDelete();

        return response()->json([
            'message' => 'Infection log permanently deleted'
        ], 200);
    }
}