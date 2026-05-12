<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IsolationRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class IsolationController extends Controller
{
    public function index()
    {
        $records = IsolationRecord::with('patient')->latest()->get();
        return view('admin.nurse.isolation.index', compact('records'));
    }

    public function create()
    {
        $patients = DB::table('patients')->get();
        return view('admin.nurse.isolation.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'isolation_type' => 'required',
            'start_date' => 'required',
            'status' => 'required'
        ]);

        IsolationRecord::create([
            'id' => Str::uuid(),
            'patient_id' => $request->patient_id,
            'nurse_id' => 1,
            'isolation_type' => $request->isolation_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return redirect()->route('admin.isolation.index')->with('success', 'Added');
    }

    public function edit($id)
    {
        $record = IsolationRecord::findOrFail($id);
        $patients = DB::table('patients')->get();

        return view('admin.nurse.isolation.edit', compact('record', 'patients'));
    }

    public function update(Request $request, $id)
    {
        $record = IsolationRecord::findOrFail($id);

        $record->update($request->all());

        return redirect()->route('admin.isolation.index')->with('success', 'Updated');
    }

    public function destroy($id)
    {
        IsolationRecord::findOrFail($id)->delete();
        return back()->with('success', 'Moved to trash');
    }

    public function trash()
    {
        $records = IsolationRecord::onlyTrashed()->get();
        return view('admin.nurse.isolation.trash', compact('records'));
    }

    public function restore($id)
    {
        IsolationRecord::withTrashed()->where('id', $id)->restore();
        return back()->with('success', 'Restored');
    }

    public function forceDelete($id)
    {
        IsolationRecord::withTrashed()->where('id', $id)->forceDelete();
        return back()->with('success', 'Deleted permanently');
    }

    // ==================== API METHODS ====================

    public function apiIndex()
    {
        return response()->json([
            'data' => IsolationRecord::with(['patient', 'nurse'])
                ->whereNull('deleted_at')
                ->get()
        ]);
    }

    public function apiShow($id)
    {
        $record = IsolationRecord::with(['patient', 'nurse'])
            ->whereNull('deleted_at')
            ->find($id);

        if (!$record) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => $record]);
    }

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'isolation_type' => 'required|string',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
            'status' => 'required|in:active,completed,discontinued',
            'notes' => 'nullable|string',
            'nurse_id' => 'nullable|numeric|exists:staff,id'
        ]);

        $validated['id'] = Str::uuid();
        
        // Set nurse_id with fallback: use provided value, then auth user, then staff table default (id=1)
        if (!isset($validated['nurse_id']) || !$validated['nurse_id']) {
            $validated['nurse_id'] = auth()->user()->id ?? DB::table('staff')->first()->id ?? 1;
        }

        $record = IsolationRecord::create($validated);

        return response()->json(['data' => $record->load(['patient', 'nurse'])], 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $record = IsolationRecord::whereNull('deleted_at')->find($id);

        if (!$record) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validated = $request->validate([
            'status' => 'sometimes|in:active,completed,discontinued',
            'end_date' => 'nullable|date_format:Y-m-d',
            'notes' => 'nullable|string'
        ]);

        $record->update($validated);

        return response()->json(['data' => $record->load(['patient', 'nurse'])]);
    }

    public function apiDestroy($id)
    {
        $record = IsolationRecord::whereNull('deleted_at')->find($id);

        if (!$record) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $record->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    public function apiTrash()
    {
        Log::info('Fetching deleted records');
        $logs = IsolationRecord::with(['patient', 'nurse'])
            ->onlyTrashed()
            ->get();
        Log::info('Found deleted records: ' . count($logs));
        return response()->json([
            'data' => $logs
        ]);
    }

    public function apiRestore($id)
    {
        $record = IsolationRecord::withTrashed()->find($id);

        if (!$record || !$record->trashed()) {
            return response()->json(['message' => 'Record not found or not deleted'], 404);
        }

        $record->restore();

        return response()->json(['message' => 'Restored successfully', 'data' => $record->load(['patient', 'nurse'])]);
    }

    public function apiForceDelete($id)
    {
        $record = IsolationRecord::withTrashed()->find($id);

        if (!$record) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $record->forceDelete();

        return response()->json(['message' => 'Permanently deleted']);
    }

    public function apiGetActive()
    {
        return response()->json([
            'data' => IsolationRecord::where('status', 'active')
                ->with(['patient', 'nurse'])
                ->whereNull('deleted_at')
                ->get()
        ]);
    }

    public function apiGetByPatient($patientId)
    {
        return response()->json([
            'data' => IsolationRecord::where('patient_id', $patientId)
                ->with(['patient', 'nurse'])
                ->whereNull('deleted_at')
                ->get()
        ]);
    }

    public function apiGetByStatus($status)
    {
        return response()->json([
            'data' => IsolationRecord::where('status', $status)
                ->with(['patient', 'nurse'])
                ->whereNull('deleted_at')
                ->get()
        ]);
    }
}