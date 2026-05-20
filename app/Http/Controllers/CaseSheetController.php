<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseSheet;
use App\Models\Patient;
use App\Models\Staff;

class CaseSheetController extends Controller
{
    public function index()
    {
        $caseSheets = CaseSheet::latest()->get();

       return view('casesheets.index', compact('caseSheets'));
    }

   public function create()
{
    $patients = Patient::where('status', 1)->get();

    // Get only doctors from staff table
    $doctors = Staff::whereHas('designation', function ($query) {

        $query->where('designation_name', 'Doctor');

    })->where('status', 'Active')->get();

    return view('casesheets.create',
        compact('patients', 'doctors'));
}

    public function store(Request $request)
    {
        $request->validate([

            'patient_id' => 'required',
            'doctor_id' => 'required',
            'visit_type' => 'required',

        ]);

        CaseSheet::create([

            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'opd_id' => $request->opd_id,
            'ipd_id' => $request->ipd_id,
            'visit_type' => $request->visit_type,
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'clinical_notes' => $request->clinical_notes,
            'status' => 'Active',

        ]);

        return redirect()->route('admin.casesheets.index')
            ->with('success', 'Case Sheet Created Successfully');
    }

    public function show($id)
    {
        $caseSheet = CaseSheet::findOrFail($id);

        return view('casesheets.show', compact('caseSheet'));
    }

    public function edit($id)
    {
        $caseSheet = CaseSheet::findOrFail($id);

    return view('casesheets.edit', compact('caseSheet'));
    }

    public function update(Request $request, $id)
    {
        $caseSheet = CaseSheet::findOrFail($id);

        $caseSheet->update([

            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'clinical_notes' => $request->clinical_notes,
            'status' => $request->status,

        ]);

        return redirect()->route('admin.casesheets.index')
            ->with('success', 'Case Sheet Updated Successfully');
    }

    public function destroy($id)
    {
        $caseSheet = CaseSheet::findOrFail($id);

        $caseSheet->delete();

        return redirect()->route('admin.casesheets.index')
            ->with('success', 'Case Sheet Deleted Successfully');
    }
}