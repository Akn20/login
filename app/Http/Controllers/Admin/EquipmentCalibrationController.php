<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\EquipmentCalibration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EquipmentCalibrationController extends Controller
{
    public function index(Request $request)
    {
        $query = EquipmentCalibration::with('equipment');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('calibration_type', 'like', '%' . $request->search . '%')
                  ->orWhere('technician', 'like', '%' . $request->search . '%')
                  ->orWhereHas('equipment', function ($eq) use ($request) {
                      $eq->where('name', 'like', '%' . $request->search . '%')
                         ->orWhere('equipment_code', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $calibrations = $query->latest()->paginate(10);

        return view('admin.laboratory.calibration.index', compact('calibrations'));
    }

    public function create()
    {
        $equipment = Equipment::where('status', 1)->get();
        return view('admin.laboratory.calibration.create', compact('equipment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required',
            'calibration_type' => 'required',
            'calibration_date' => 'required|date|date_format:Y-m-d',
            'result' => 'required'
        ]);

        EquipmentCalibration::create([
            'id' => (string) Str::uuid(),
            'equipment_id' => $request->equipment_id,
            'calibration_type' => $request->calibration_type,
            'calibration_date' => $request->calibration_date,
            'technician' => $request->technician,
            'result' => $request->result,
            'next_due_date' => $request->next_due_date,
            'notes' => $request->notes
        ]);

        // 🔥 AUTO STATUS LOGIC
        $equipment = Equipment::find($request->equipment_id);

        if ($request->result === 'Fail') {
            $equipment->condition_status = 'Out of Service';
        } else {
            $equipment->condition_status = 'Active';
        }

        $equipment->save();

        return redirect()->route('admin.laboratory.calibration.index')
            ->with('success', 'Calibration Recorded');
    }

    public function edit($id)
    {
        $calibration = EquipmentCalibration::findOrFail($id);
        $equipment = Equipment::all();

        return view('admin.laboratory.calibration.edit', compact('calibration', 'equipment'));
    }

    public function update(Request $request, $id)
    {
        $calibration = EquipmentCalibration::findOrFail($id);

        $calibration->update($request->all());

        return redirect()->route('admin.laboratory.calibration.index')
            ->with('success', 'Updated');
    }

    public function destroy($id)
    {
        EquipmentCalibration::findOrFail($id)->delete();

        return back()->with('success', 'Moved to trash');
    }

    public function deleted()
    {
        $calibrations = EquipmentCalibration::onlyTrashed()->paginate(10);
        return view('admin.laboratory.calibration.delete', compact('calibrations'));
    }

    public function restore($id)
    {
        EquipmentCalibration::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Restored');
    }

    public function forceDelete($id)
    {
        EquipmentCalibration::withTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'Deleted permanently');
    }

    public function show($id)
    {
        $calibration = EquipmentCalibration::with('equipment')->findOrFail($id);
        return view('admin.laboratory.calibration.show', compact('calibration'));
    }
}