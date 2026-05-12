<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\EquipmentMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class EquipmentMaintenanceController extends Controller
{
    // 📌 LIST
    public function index(Request $request)
    {
        $query = EquipmentMaintenance::with('equipment');

        if ($request->search) {
            $query->where(function ($q) use ($request) {

                $q->where('maintenance_type', 'like', '%' . $request->search . '%')
                ->orWhere('technician', 'like', '%' . $request->search . '%')
                ->orWhereHas('equipment', function ($eq) use ($request) {
                    $eq->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('equipment_code', 'like', '%' . $request->search . '%');
                });

            });
        }

        $maintenance = $query->latest()->paginate(10);

        return view('admin.laboratory.maintenance.index', compact('maintenance'));
    }

    // 📌 CREATE
    public function create()
    {
        $equipment = Equipment::where('status', 1)->get();

        return view('admin.laboratory.maintenance.create', compact('equipment'));
    }

    // 📌 STORE (🔥 IMPORTANT LOGIC HERE)
    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required',
            'maintenance_type' => 'required',
            'maintenance_date' => 'required|date|date_format:Y-m-d',
            'status' => 'required'
        ]);

        $maintenance = EquipmentMaintenance::create([
            'id' => (string) Str::uuid(),
            'equipment_id' => $request->equipment_id,
            'maintenance_type' => $request->maintenance_type,
            'maintenance_date' => $request->maintenance_date,
            'technician' => $request->technician,
            'description' => $request->description,
            'status' => $request->status
        ]);

        // 🔥 AUTO UPDATE EQUIPMENT STATUS
        $equipment = Equipment::find($request->equipment_id);

        if ($request->status !== 'Completed') {
            $equipment->condition_status = 'Under Maintenance';
        } else {
            $equipment->condition_status = 'Active';
        }

        $equipment->save();

        return redirect()->route('admin.laboratory.maintenance.index')
            ->with('success', 'Maintenance Logged Successfully');
    }

    // 📌 EDIT
    public function edit($id)
    {
        $maintenance = EquipmentMaintenance::findOrFail($id);
        $equipment = Equipment::all();

        return view('admin.laboratory.maintenance.edit', compact('maintenance', 'equipment'));
    }

    // 📌 UPDATE (🔥 ALSO IMPORTANT)
    public function update(Request $request, $id)
    {
        $maintenance = EquipmentMaintenance::findOrFail($id);

        $maintenance->update([
            'equipment_id' => $request->equipment_id,
            'maintenance_type' => $request->maintenance_type,
            'maintenance_date' => $request->maintenance_date,
            'technician' => $request->technician,
            'description' => $request->description,
            'status' => $request->status
        ]);

        // 🔥 SYNC EQUIPMENT STATUS AGAIN
        $equipment = Equipment::find($request->equipment_id);

        if ($request->status !== 'Completed') {
            $equipment->condition_status = 'Under Maintenance';
        } else {
            $equipment->condition_status = 'Active';
        }

        $equipment->save();

        return redirect()->route('admin.laboratory.maintenance.index')
            ->with('success', 'Maintenance Updated');
    }

    
    public function destroy($id)
    {
        EquipmentMaintenance::findOrFail($id)->delete();

        return back()->with('success', 'Deleted Successfully');
    }
    public function show($id)
    {
        $maintenance = EquipmentMaintenance::with('equipment')->findOrFail($id);
        return view('admin.laboratory.maintenance.show', compact('maintenance'));
    }

    public function deleted()
    {
        $maintenance = EquipmentMaintenance::onlyTrashed()->paginate(10);
        return view('admin.laboratory.maintenance.delete', compact('maintenance'));
    }

    public function restore($id)
    {
        EquipmentMaintenance::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Restored');
    }

    public function forceDelete($id)
    {
        EquipmentMaintenance::withTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'Deleted permanently');
    }
    
}   