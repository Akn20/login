<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\NurseNotes;
use App\Models\Patient;
use App\Models\Staff;


class NurseNotesController extends Controller
{
    public function index(Request $request)
    {
        $query = NurseNotes::with(['patient', 'nurse']);

        if ($request->filled('patient_name')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->patient_name . '%')
                  ->orWhere('last_name', 'like', '%' . $request->patient_name . '%');
            });
        }

        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }

        $nursingNotes = $query->latest()->paginate(10);

        return view('admin.nurse.nursing_notes.index', compact('nursingNotes'));
    }


    public function create()
    {
        $patients = Patient::all();
        $nurses = Staff::join('roles', 'staff.role_id', '=', 'roles.id')
            ->where('roles.name', 'Nurse')
            ->whereNull('staff.deleted_at')
            ->select('staff.id', 'staff.name')
            ->get();

        return view('admin.nurse.nursing_notes.create', compact('patients', 'nurses'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'nurse_id' => 'required',
            'shift' => 'required',
        ]);

        NurseNotes::create([
            'institution_id' => null,
            'patient_id' => $request->patient_id,
            'nurse_id' => $request->nurse_id,
            'shift' => $request->shift,
            'patient_condition' => $request->patient_condition,
            'intake_details' => $request->intake_details,
            'output_details' => $request->output_details,
            'wound_care_notes' => $request->wound_care_notes,
        ]);

        return redirect()->route('admin.nursing-notes.index')
            ->with('success','Created successfully');
    }   


    public function show($id)
    {
        $note = NurseNotes::with(['patient', 'nurse'])->findOrFail($id);

        return view('admin.nurse.nursing_notes.show', compact('note'));
    }


    public function edit($id)
    {
        $note = NurseNotes::findOrFail($id);

        $patients = Patient::all();

        $nurses = Staff::join('roles', 'staff.role_id', '=', 'roles.id')
            ->where('roles.name', 'Nurse')
            ->whereNull('staff.deleted_at')
            ->select('staff.id', 'staff.name')
            ->get();

        return view('admin.nurse.nursing_notes.edit', compact('note', 'patients', 'nurses'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'nurse_id' => 'required|exists:staff,id',
            'shift' => 'required|in:Morning,Evening,Night',
            'patient_condition' => 'nullable|string',
            'intake_details' => 'nullable|string',
            'output_details' => 'nullable|string',
            'wound_care_notes' => 'nullable|string',
        ]);

        $nurses = Staff::join('roles', 'staff.role_id', '=', 'roles.id')
            ->where('roles.name', 'Nurse')
            ->whereNull('staff.deleted_at')
            ->select('staff.id', 'staff.name')
            ->get();

        if (!$nurses) {
            return back()->withInput()->with('error', 'Selected staff is not a nurse.');
        }

        $note = NurseNotes::findOrFail($id);

        $note->update([
            'patient_id' => $request->patient_id,
            'nurse_id' => $request->nurse_id,
            'shift' => $request->shift,
            'patient_condition' => $request->patient_condition,
            'intake_details' => $request->intake_details,
            'output_details' => $request->output_details,
            'wound_care_notes' => $request->wound_care_notes,
        ]);

        return redirect()->route('admin.nursing-notes.index')
            ->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $note = NurseNotes::findOrFail($id);
        $note->delete();

        return redirect()->route('admin.nursing-notes.index')
            ->with('success', 'Nursing note deleted successfully.');
    }

    public function trash()
    {
        $deletedNotes = NurseNotes::onlyTrashed()
            ->with(['patient', 'nurse'])
            ->latest()
            ->paginate(10);

        return view('admin.nurse.nursing_notes.trash', compact('deletedNotes'));
    }

    public function restore($id)
    {
        $note = NurseNotes::onlyTrashed()->findOrFail($id);
        $note->restore();

        return redirect()->route('admin.nursing-notes.trash')
            ->with('success', 'Nursing note restored successfully.');
    }
}
