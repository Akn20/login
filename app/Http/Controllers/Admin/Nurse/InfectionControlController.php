<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InfectionControlLog;
use Illuminate\Support\Facades\DB;
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
        InfectionControlLog::where('id', $id)->update([
            'deleted_at' => now()
        ]);

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
}