<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatutoryCompliance;
use App\Models\Staff;
use Illuminate\Support\Str;

class StatutoryComplianceController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $records = StatutoryCompliance::latest()
            ->paginate(10);

        return view(
            'hr.statutory_compliance.index',
            compact('records')
        );
    }

    // ================= CREATE =================
    public function create()
    {
        $employees = Staff::with('department')
            ->where('status', 'Active')
            ->orderBy('employee_id')
            ->get();

        return view(
            'hr.statutory_compliance.create',
            compact('employees')
        );
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([

            'employee_id' =>
                'required|string|max:255',

            'employee_name' =>
                'required|string|max:255',

            'department' =>
                'required|string|max:255',

            'pf_applicable' =>
                'nullable|in:Yes,No',

            'pf_number' =>
                'nullable|string|max:255',

            'pf_amount' =>
                'nullable|numeric|min:0',

            'pf_start_date' =>
                'nullable|date',

            'esi_applicable' =>
                'nullable|in:Yes,No',

            'esi_number' =>
                'nullable|string|max:255',

            'esi_amount' =>
                'nullable|numeric|min:0',

            'pt_applicable' =>
                'nullable|in:Yes,No',

            'pt_amount' =>
                'nullable|numeric|min:0',

            'state_applicable' =>
                'nullable|string|max:255',

            'tds_applicable' =>
                'nullable|in:Yes,No',

            'pan_number' =>
                'nullable|string|max:255',

            'tds_percentage' =>
                'nullable|numeric|min:0|max:100',

        ]);

        StatutoryCompliance::create([

            'id' => Str::uuid(),

            'employee_id' =>
                $request->employee_id,

            'employee_name' =>
                $request->employee_name,

            'department' =>
                $request->department,

            'pf_applicable' =>
                $request->pf_applicable,

            'pf_number' =>
                $request->pf_number,

            'pf_amount' =>
                $request->pf_amount,

            'pf_start_date' =>
                $request->pf_start_date,

            'esi_applicable' =>
                $request->esi_applicable,

            'esi_number' =>
                $request->esi_number,

            'esi_amount' =>
                $request->esi_amount,

            'pt_applicable' =>
                $request->pt_applicable,

            'pt_amount' =>
                $request->pt_amount,

            'state_applicable' =>
                $request->state_applicable,

            'tds_applicable' =>
                $request->tds_applicable,

            'pan_number' =>
                $request->pan_number,

            'tds_percentage' =>
                $request->tds_percentage,

        ]);

        return redirect()
            ->route('hr.statutory-compliance.index')
            ->with(
                'success',
                'Created Successfully'
            );
    }

    // ================= SHOW =================
    public function show($id)
    {
        $record = StatutoryCompliance::findOrFail($id);

        return view(
            'hr.statutory_compliance.show',
            compact('record')
        );
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $record = StatutoryCompliance::findOrFail($id);

        $employees = Staff::with('department')
            ->where('status', 'Active')
            ->orderBy('employee_id')
            ->get();

        return view(
            'hr.statutory_compliance.edit',
            compact(
                'record',
                'employees'
            )
        );
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $record = StatutoryCompliance::findOrFail($id);

        $request->validate([

            'employee_id' =>
                'required|string|max:255',

            'employee_name' =>
                'required|string|max:255',

            'department' =>
                'required|string|max:255',

        ]);

        $record->update([

            'employee_id' =>
                $request->employee_id,

            'employee_name' =>
                $request->employee_name,

            'department' =>
                $request->department,

            'pf_applicable' =>
                $request->pf_applicable,

            'pf_number' =>
                $request->pf_number,

            'pf_amount' =>
                $request->pf_amount,

            'pf_start_date' =>
                $request->pf_start_date,

            'esi_applicable' =>
                $request->esi_applicable,

            'esi_number' =>
                $request->esi_number,

            'esi_amount' =>
                $request->esi_amount,

            'pt_applicable' =>
                $request->pt_applicable,

            'pt_amount' =>
                $request->pt_amount,

            'state_applicable' =>
                $request->state_applicable,

            'tds_applicable' =>
                $request->tds_applicable,

            'pan_number' =>
                $request->pan_number,

            'tds_percentage' =>
                $request->tds_percentage,

        ]);

        return redirect()
            ->route('hr.statutory-compliance.index')
            ->with(
                'success',
                'Updated Successfully'
            );
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $record = StatutoryCompliance::findOrFail($id);

        $record->delete();

        return redirect()
            ->route('hr.statutory-compliance.index')
            ->with(
                'success',
                'Deleted Successfully'
            );
    }

    // ================= DELETED =================
    public function deleted()
    {
        $records = StatutoryCompliance::onlyTrashed()
            ->latest()
            ->paginate(10);

        return view(
            'hr.statutory_compliance.deleted',
            compact('records')
        );
    }

    // ================= RESTORE =================
    public function restore($id)
    {
        $record = StatutoryCompliance::onlyTrashed()
            ->findOrFail($id);

        $record->restore();

        return redirect()
            ->route('hr.statutory-compliance.deleted')
            ->with(
                'success',
                'Record Restored Successfully'
            );
    }

    // ================= FORCE DELETE =================
    public function forceDelete($id)
    {
        $record = StatutoryCompliance::onlyTrashed()
            ->findOrFail($id);

        $record->forceDelete();

        return redirect()
            ->route('hr.statutory-compliance.deleted')
            ->with(
                'success',
                'Record Permanently Deleted'
            );
    }
}