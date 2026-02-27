<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->search) {
            $query->where('first_name', 'like', '%' . $request->search . '%')
                ->orWhere('last_name', 'like', '%' . $request->search . '%')
                ->orWhere('mobile', 'like', '%' . $request->search . '%')
                ->orWhere('patient_code', 'like', '%' . $request->search . '%');
        }

        $patients = $query->latest()->paginate(10);

        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'mobile' => 'required|regex:/^[0-9]{10}$/'
        ]);

        Patient::create([
            'id' => (string) Str::uuid(),
            'patient_code' => 'PAT-' . rand(10000,99999),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'blood_group' => $request->blood_group,
            'address' => $request->address,
            'emergency_contact' => $request->emergency_contact,
            'is_vip' => $request->is_vip ?? 0,
            'status' => 1
        ]);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient Created Successfully');
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($request->all());

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient Updated Successfully');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient moved to trash successfully.');
    }
    public function deleted()
    {
        $patients = Patient::onlyTrashed()->paginate(10);
        return view('admin.patients.delete', compact('patients'));
    }

    public function restore($id)
    {   
        Patient::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.patients.deleted')
            ->with('success', 'Patient Restored Successfully');
    }

    public function forceDelete($id)
    {
        Patient::withTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'Patient Permanently Deleted');
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return view('admin.patients.show', compact('patient'));
    }
    public function toggleStatus($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->status = !$patient->status;
        $patient->save();

        return response()->json([
            'success' => true,
            'is_active' => (bool) $patient->status
        ]); 
    }

    public function toggleVip($id)
    {   
        $patient = Patient::findOrFail($id);
        $patient->is_vip = !$patient->is_vip;
        $patient->save();

       return response()->json([
            'success' => true,
            'is_active' => (bool) $patient->is_vip
        ]);
    }

    // Show Duplicate Patients
    public function duplicates()
    {
        $duplicateGroups = Patient::select('mobile', 'first_name', 'last_name')
            ->groupBy('mobile', 'first_name', 'last_name')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $groups = [];

        foreach ($duplicateGroups as $group) {
            $patients = Patient::where('mobile', $group->mobile)
                ->where('first_name', $group->first_name)
                ->where('last_name', $group->last_name)
                ->get();

            $groups[] = $patients;
        }

        return view('admin.patients.duplicates', compact('groups'));
    }


    // Merge Selected Patients
    public function merge(Request $request)
    {
        $masterId = $request->master_id;
        $duplicateIds = $request->duplicate_ids;

        foreach ($duplicateIds as $id) {
            if ($id != $masterId) {
                Patient::where('id', $id)->delete();
            }
        }

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patients merged successfully.');
    }
}