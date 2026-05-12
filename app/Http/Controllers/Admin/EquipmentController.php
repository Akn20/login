<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipment::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('equipment_code', 'like', '%' . $request->search . '%')
                ->orWhere('serial_number', 'like', '%' . $request->search . '%');
        }

        $equipment = $query->latest()->paginate(10);

        return view('admin.laboratory.equipment.index', compact('equipment'));
    }

    public function create()
    {
        return view('admin.laboratory.equipment.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'installation_date' => 'required|date|date_format:Y-m-d',
            'condition_status' => 'required'
        ]);

        Equipment::create([
            'id' => (string) Str::uuid(),
            'equipment_code' => 'EQP-' . rand(10000,99999),
            'name' => $request->name,
            'type' => $request->type,
            'manufacturer' => $request->manufacturer,
            'model_number' => $request->model_number,
            'serial_number' => $request->serial_number,
            'installation_date' => $request->installation_date,
            'location' => $request->location,
            'condition_status' => $request->condition_status,
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('admin.laboratory.equipment.index')
            ->with('success', 'Equipment Created Successfully');
    }

    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('admin.laboratory.equipment.edit', compact('equipment'));
    }

    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->update([
            'name' => $request->name,
            'type' => $request->type,
            'manufacturer' => $request->manufacturer,
            'model_number' => $request->model_number,
            'serial_number' => $request->serial_number,
            'installation_date' => $request->installation_date,
            'location' => $request->location,
            'condition_status' => $request->condition_status,
            'status' => $request->status ?? $equipment->status
        ]);

        return redirect()->route('admin.laboratory.equipment.index')
            ->with('success', 'Equipment Updated Successfully');
    }

    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->route('admin.laboratory.equipment.index')
            ->with('success', 'Equipment moved to trash');
    }

    public function deleted()
    {
        $equipment = Equipment::onlyTrashed()->paginate(10);
        return view('admin.laboratory.equipment.delete', compact('equipment'));
    }

    public function restore($id)
    {
        Equipment::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.laboratory.equipment.deleted')
            ->with('success', 'Equipment Restored');
    }

    public function forceDelete($id)
    {
        Equipment::withTrashed()->findOrFail($id)->forceDelete();

        return back()->with('success', 'Equipment Permanently Deleted');
    }

    public function show($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('admin.laboratory.equipment.show', compact('equipment'));
    }

    public function toggleStatus($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->status = !$equipment->status;
        $equipment->save();

        return response()->json([
            'success' => true,
            'is_active' => (bool) $equipment->status
        ]);
    }
}