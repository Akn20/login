<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\EquipmentBreakdown;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EquipmentBreakdownController extends Controller
{
    public function index(Request $request)
    {
        $query = EquipmentBreakdown::with('equipment');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', '%' . $request->search . '%')
                  ->orWhere('reported_by', 'like', '%' . $request->search . '%')
                  ->orWhereHas('equipment', function ($eq) use ($request) {
                      $eq->where('name', 'like', '%' . $request->search . '%')
                         ->orWhere('equipment_code', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $breakdowns = $query->latest()->paginate(10);

        return view('admin.laboratory.breakdown.index', compact('breakdowns'));
    }

    public function create()
    {
        $equipment = Equipment::where('status', 1)->get();
        return view('admin.laboratory.breakdown.create', compact('equipment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required',
            'description' => 'required',
            'reported_by' => 'required',
            'breakdown_date' => 'required|date|date_format:Y-m-d',
            'severity' => 'required',
            'status' => 'required'
        ]);

        EquipmentBreakdown::create([
            'id' => (string) Str::uuid(),
            'equipment_id' => $request->equipment_id,
            'description' => $request->description,
            'reported_by' => $request->reported_by,
            'breakdown_date' => $request->breakdown_date,
            'severity' => $request->severity,
            'status' => $request->status
        ]);

        // 🔥 AUTO EQUIPMENT STATUS
        $equipment = Equipment::find($request->equipment_id);

        if ($request->status !== 'Resolved') {
            $equipment->condition_status = 'Out of Service';
        } else {
            $equipment->condition_status = 'Active';
        }

        $equipment->save();

        return redirect()->route('admin.laboratory.breakdown.index')
            ->with('success', 'Breakdown recorded');
    }

    public function edit($id)
    {
        $breakdown = EquipmentBreakdown::findOrFail($id);
        $equipment = Equipment::all();

        return view('admin.laboratory.breakdown.edit', compact('breakdown', 'equipment'));
    }

    public function update(Request $request, $id)
    {
        $breakdown = EquipmentBreakdown::findOrFail($id);

        $breakdown->update($request->all());

        return redirect()->route('admin.laboratory.breakdown.index')
            ->with('success', 'Updated');
    }

    public function destroy($id)
    {
        EquipmentBreakdown::findOrFail($id)->delete();
        return back()->with('success', 'Moved to trash');
    }

    public function deleted()
    {
        $breakdowns = EquipmentBreakdown::onlyTrashed()->paginate(10);
        return view('admin.laboratory.breakdown.delete', compact('breakdowns'));
    }

    public function restore($id)
    {
        EquipmentBreakdown::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Restored');
    }

    public function forceDelete($id)
    {
        EquipmentBreakdown::withTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'Deleted permanently');
    }

    public function show($id)
    {
        $breakdown = EquipmentBreakdown::with('equipment')->findOrFail($id);
        return view('admin.laboratory.breakdown.show', compact('breakdown'));
    }

    // ================= API LIST =================

public function apiIndex(Request $request)
{
    $query = EquipmentBreakdown::with('equipment');

    if ($request->search) {
        $query->where('description', 'like', '%' . $request->search . '%')
              ->orWhere('reported_by', 'like', '%' . $request->search . '%');
    }

    $breakdowns = $query->latest()->get();

    return response()->json([
        'success' => true,
        'data' => $breakdowns
    ]);
}

// ================= API STORE =================

public function apiStore(Request $request)
{
    $request->validate([
        'equipment_id' => 'required',
        'description' => 'required',
        'reported_by' => 'required',
        'breakdown_date' => 'required',
        'severity' => 'required',
        'status' => 'required',
    ]);

    $breakdown = EquipmentBreakdown::create([
        'id' => (string) Str::uuid(),
        'equipment_id' => $request->equipment_id,
        'description' => $request->description,
        'reported_by' => $request->reported_by,
        'breakdown_date' => $request->breakdown_date,
        'severity' => $request->severity,
        'status' => $request->status,
    ]);

    // AUTO UPDATE EQUIPMENT STATUS

    $equipment = Equipment::find($request->equipment_id);

    if ($equipment) {
        $equipment->condition_status =
            $request->status !== 'Resolved'
                ? 'Out of Service'
                : 'Active';

        $equipment->save();
    }

    return response()->json([
        'success' => true,
        'message' => 'Breakdown Created',
        'data' => $breakdown
    ]);
}

// ================= API SHOW =================

public function apiShow($id)
{
    $breakdown = EquipmentBreakdown::with('equipment')
        ->findOrFail($id);

    return response()->json([
        'success' => true,
        'data' => $breakdown
    ]);
}

// ================= API UPDATE =================

public function apiUpdate(Request $request, $id)
{
    $breakdown = EquipmentBreakdown::findOrFail($id);

    $breakdown->update([
        'equipment_id' => $request->equipment_id,
        'description' => $request->description,
        'reported_by' => $request->reported_by,
        'breakdown_date' => $request->breakdown_date,
        'severity' => $request->severity,
        'status' => $request->status,
    ]);

    // AUTO UPDATE EQUIPMENT STATUS

    $equipment = Equipment::find($request->equipment_id);

    if ($equipment) {
        $equipment->condition_status =
            $request->status !== 'Resolved'
                ? 'Out of Service'
                : 'Active';

        $equipment->save();
    }

    return response()->json([
        'success' => true,
        'message' => 'Breakdown Updated',
        'data' => $breakdown
    ]);
}

// ================= API DELETE =================

public function apiDelete($id)
{
    EquipmentBreakdown::findOrFail($id)->delete();

    return response()->json([
        'success' => true,
        'message' => 'Breakdown Deleted'
    ]);
}

// ================= API DELETED =================

public function apiDeleted()
{
    $breakdowns = EquipmentBreakdown::onlyTrashed()
        ->latest()
        ->get();

    return response()->json([
        'success' => true,
        'data' => $breakdowns
    ]);
}

// ================= API RESTORE =================

public function apiRestore($id)
{
    EquipmentBreakdown::withTrashed()
        ->findOrFail($id)
        ->restore();

    return response()->json([
        'success' => true,
        'message' => 'Breakdown Restored'
    ]);
}

// ================= API FORCE DELETE =================

public function apiForceDelete($id)
{
    EquipmentBreakdown::withTrashed()
        ->findOrFail($id)
        ->forceDelete();

    return response()->json([
        'success' => true,
        'message' => 'Breakdown Permanently Deleted'
    ]);
}

}