<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PreventiveMaintenance;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PreventiveMaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = PreventiveMaintenance::with('equipment');

        if ($request->search) {
            $query->whereHas('equipment', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('equipment_code', 'like', '%' . $request->search . '%');
            });
        }

        $records = $query->latest()->paginate(10);

        return view('admin.laboratory.preventive.index', compact('records'));
    }

    public function create()
    {
        $equipment = Equipment::where('status', 1)->get();
        return view('admin.laboratory.preventive.create', compact('equipment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'frequency' => 'required|in:Monthly,Quarterly,Yearly',
            'next_maintenance_date' => 'required|date|after_or_equal:today',
            'technician' => 'nullable|string|max:255'
        ]);

        PreventiveMaintenance::create([
            'id' => (string) Str::uuid(),
            'equipment_id' => $request->equipment_id,
            'frequency' => $request->frequency,
            'next_maintenance_date' => $request->next_maintenance_date,
            'technician' => $request->technician
        ]);

        return redirect()->route('admin.laboratory.preventive.index')
            ->with('success', 'Scheduled successfully');
    }

    public function edit($id)
    {
        $record = PreventiveMaintenance::findOrFail($id);
        $equipment = Equipment::all();

        return view('admin.laboratory.preventive.edit', compact('record', 'equipment'));
    }

    public function update(Request $request, $id)
    {
        $record = PreventiveMaintenance::findOrFail($id);
        $record->update($request->all());

        return redirect()->route('admin.laboratory.preventive.index')
            ->with('success', 'Updated');
    }

    public function destroy($id)
    {
        PreventiveMaintenance::findOrFail($id)->delete();
        return back()->with('success', 'Moved to trash');
    }

    public function deleted()
    {
        $records = PreventiveMaintenance::onlyTrashed()->paginate(10);
        return view('admin.laboratory.preventive.delete', compact('records'));
    }

    public function restore($id)
    {
        PreventiveMaintenance::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.laboratory.preventive.index')
            ->with('success', 'Restored');
    }

    public function forceDelete($id)
    {
        PreventiveMaintenance::withTrashed()->findOrFail($id)->forceDelete();

        return back()->with('success', 'Deleted permanently');
    }

    public function show($id)
    {
        $record = PreventiveMaintenance::with('equipment')->findOrFail($id);
        return view('admin.laboratory.preventive.show', compact('record'));
    }

    // ================= API LIST =================

public function apiIndex(Request $request)
{
    $query = PreventiveMaintenance::with('equipment');

    if ($request->search) {
        $query->whereHas('equipment', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('equipment_code', 'like', '%' . $request->search . '%');
        });
    }

    $records = $query->latest()->get();

    return response()->json([
        'success' => true,
        'data' => $records
    ]);
}

// ================= API STORE =================

public function apiStore(Request $request)
{
    $request->validate([
        'equipment_id' => 'required',
        'frequency' => 'required',
        'next_maintenance_date' => 'required',
    ]);

    $record = PreventiveMaintenance::create([
        'id' => (string) Str::uuid(),
        'equipment_id' => $request->equipment_id,
        'frequency' => $request->frequency,
        'next_maintenance_date' => $request->next_maintenance_date,
        'technician' => $request->technician,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Schedule Created',
        'data' => $record
    ]);
}

// ================= API SHOW =================

public function apiShow($id)
{
    $record = PreventiveMaintenance::with('equipment')
        ->findOrFail($id);

    return response()->json([
        'success' => true,
        'data' => $record
    ]);
}

// ================= API UPDATE =================

public function apiUpdate(Request $request, $id)
{
    $record = PreventiveMaintenance::findOrFail($id);

    $record->update([
        'equipment_id' => $request->equipment_id,
        'frequency' => $request->frequency,
        'next_maintenance_date' => $request->next_maintenance_date,
        'technician' => $request->technician,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Updated',
        'data' => $record
    ]);
}

// ================= API DELETE =================

public function apiDelete($id)
{
    PreventiveMaintenance::findOrFail($id)->delete();

    return response()->json([
        'success' => true,
        'message' => 'Deleted'
    ]);
}

// ================= API DELETED =================

public function apiDeleted()
{
    $records = PreventiveMaintenance::onlyTrashed()
        ->latest()
        ->get();

    return response()->json([
        'success' => true,
        'data' => $records
    ]);
}

// ================= API RESTORE =================

public function apiRestore($id)
{
    PreventiveMaintenance::withTrashed()
        ->findOrFail($id)
        ->restore();

    return response()->json([
        'success' => true,
        'message' => 'Restored'
    ]);
}

// ================= API FORCE DELETE =================

public function apiForceDelete($id)
{
    PreventiveMaintenance::withTrashed()
        ->findOrFail($id)
        ->forceDelete();

    return response()->json([
        'success' => true,
        'message' => 'Deleted Permanently'
    ]);
}

}