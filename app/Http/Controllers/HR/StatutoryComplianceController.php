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
                'required|in:Yes,No',

            'pf_number' =>
                'nullable|string|max:255',

            'pf_amount' =>
                'nullable|numeric|min:0',

            'pf_start_date' =>
                'nullable|date',

            'esi_applicable' =>
                'required|in:Yes,No',

            'esi_number' =>
                'nullable|string|max:255',

            'esi_amount' =>
                'nullable|numeric|min:0',

            'pt_applicable' =>
                'required|in:Yes,No',

            'pt_amount' =>
                'nullable|numeric|min:0',

            'state_applicable' =>
                'nullable|string|max:255',

            'tds_applicable' =>
                'required|in:Yes,No',

            'pan_number' =>
                'nullable|string|max:255',

            'tds_percentage' =>
                'nullable|numeric|min:0|max:100',
                'contract_start_date' =>

    'nullable|date',

'contract_end_date' =>

    'nullable|date|after_or_equal:contract_start_date',

'contract_status' =>

    'nullable|string|max:255',

'license_number' =>

    'nullable|string|max:255',

'license_issue_date' =>

    'nullable|date',

'license_expiry_date' =>

    'nullable|date|after_or_equal:license_issue_date',

'license_status' =>

    'nullable|string|max:255',
    'license_upload' =>

    'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

'remarks' =>

    'nullable|string|max:1000',

'status' =>

    'required|in:Active,Inactive',

        ]);
        $licenseFile = null;

if ($request->hasFile('license_upload')) {

    $licenseFile = $request
        ->file('license_upload')
        ->store(
            'license_uploads',
            'public'
        );
}

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
                'contract_start_date' =>

    $request->contract_start_date,

'contract_end_date' =>

    $request->contract_end_date,

'contract_status' =>

    $request->contract_status,

'license_number' =>

    $request->license_number,

'license_issue_date' =>

    $request->license_issue_date,

'license_expiry_date' =>

    $request->license_expiry_date,

'license_status' =>

    $request->license_status,
    'license_upload' =>

    $licenseFile,

'remarks' =>

    $request->remarks,

'status' =>

    $request->status,

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
                'contract_start_date' =>

    'nullable|date',

'contract_end_date' =>

    'nullable|date|after_or_equal:contract_start_date',

'contract_status' =>

    'nullable|string|max:255',

'license_number' =>

    'nullable|string|max:255',

'license_issue_date' =>

    'nullable|date',

'license_expiry_date' =>

    'nullable|date|after_or_equal:license_issue_date',

'license_status' =>

    'nullable|string|max:255',
    'license_upload' =>

    'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

'remarks' =>

    'nullable|string|max:1000',

'pf_applicable' =>
    'required|in:Yes,No',

'esi_applicable' =>
    'required|in:Yes,No',

    
'pt_applicable' =>
    'required|in:Yes,No',

'tds_applicable' =>
    'required|in:Yes,No',

'status' =>
    'required|in:Active,Inactive',

        ]);
$licenseFile = $record->license_upload;

if ($request->hasFile('license_upload')) {

    $licenseFile = $request
        ->file('license_upload')
        ->store(
            'license_uploads',
            'public'
        );
}
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
                'contract_start_date' =>

    $request->contract_start_date,

'contract_end_date' =>

    $request->contract_end_date,

'contract_status' =>

    $request->contract_status,

'license_number' =>

    $request->license_number,

'license_issue_date' =>

    $request->license_issue_date,

'license_expiry_date' =>

    $request->license_expiry_date,

'license_status' =>

    $request->license_status,
    'license_upload' =>

    $licenseFile,

'remarks' =>

    $request->remarks,

'status' =>

    $request->status,

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
//-------------Api methods---------------------------------------
public function apiIndex()
{
    return response()->json(
        StatutoryCompliance::latest()->get()
    );
}
public function formData()
{
    $employees = Staff::with('department')
        ->where('status', 'Active')
        ->get();

    return response()->json([
        'employees' => $employees
    ]);
}
public function apiShow($id)
{
    $record =
        StatutoryCompliance::findOrFail($id);

    return response()->json($record);
}
public function apiStore(Request $request)
{
    $employee = Staff::where(
        'employee_id',
        $request->employee_id
    )->first();

    $licenseUpload = null;

    if ($request->hasFile('license_upload')) {

        $licenseUpload =
            $request
                ->file('license_upload')
                ->store(
                    'statutory-compliance',
                    'public'
                );
    }

    $record = StatutoryCompliance::create([

        'id' => Str::uuid(),

        'employee_id' =>
            $request->employee_id,

        'employee_name' =>
            $employee->name ?? null,

        'department' =>
            optional($employee->department)
                ->department_name,

        'pf_applicable' =>
            $request->pf_applicable,

        'pf_number' =>
            $request->pf_number,

        'pf_contribution_amount' =>
            $request->pf_contribution_amount,

        'pf_start_date' =>
            $request->pf_start_date,

        'esi_applicable' =>
            $request->esi_applicable,

        'esi_number' =>
            $request->esi_number,

        'esi_contribution_amount' =>
            $request->esi_contribution_amount,

        'professional_tax_applicable' =>
            $request->professional_tax_applicable,

        'professional_tax_amount' =>
            $request->professional_tax_amount,

        'state_applicable' =>
            $request->state_applicable,

        'tds_applicable' =>
            $request->tds_applicable,

        'pan_number' =>
            $request->pan_number,

        'tds_percentage' =>
            $request->tds_percentage,

        'contract_start_date' =>
            $request->contract_start_date,

        'contract_end_date' =>
            $request->contract_end_date,

        'contract_status' =>
            $request->contract_status,

        'license_number' =>
            $request->license_number,

        'license_issue_date' =>
            $request->license_issue_date,

        'license_expiry_date' =>
            $request->license_expiry_date,

        'license_upload' =>
            $licenseUpload,

        'license_status' =>
            $request->license_status,

        'remarks' =>
            $request->remarks,

        'status' =>
            $request->status ?? 'Active',
    ]);

    return response()->json([
        'message' => 'Created Successfully',
        'data' => $record
    ]);
}
public function apiUpdate(
    Request $request,
    $id
)
{
    $record =
        StatutoryCompliance::findOrFail($id);

    $employee = Staff::where(
        'employee_id',
        $request->employee_id
    )->first();

    if ($request->hasFile('license_upload')) {

        $record->license_upload =
            $request
                ->file('license_upload')
                ->store(
                    'statutory-compliance',
                    'public'
                );
    }

    $record->update([

        'employee_id' =>
            $request->employee_id,

        'employee_name' =>
            $employee->name ?? null,

        'department' =>
            optional($employee->department)
                ->department_name,

        'pf_applicable' =>
            $request->pf_applicable,

        'pf_number' =>
            $request->pf_number,

        'pf_contribution_amount' =>
            $request->pf_contribution_amount,

        'pf_start_date' =>
            $request->pf_start_date,

        'esi_applicable' =>
            $request->esi_applicable,

        'esi_number' =>
            $request->esi_number,

        'esi_contribution_amount' =>
            $request->esi_contribution_amount,

        'professional_tax_applicable' =>
            $request->professional_tax_applicable,

        'professional_tax_amount' =>
            $request->professional_tax_amount,

        'state_applicable' =>
            $request->state_applicable,

        'tds_applicable' =>
            $request->tds_applicable,

        'pan_number' =>
            $request->pan_number,

        'tds_percentage' =>
            $request->tds_percentage,

        'contract_start_date' =>
            $request->contract_start_date,

        'contract_end_date' =>
            $request->contract_end_date,

        'contract_status' =>
            $request->contract_status,

        'license_number' =>
            $request->license_number,

        'license_issue_date' =>
            $request->license_issue_date,

        'license_expiry_date' =>
            $request->license_expiry_date,

        'license_status' =>
            $request->license_status,

        'remarks' =>
            $request->remarks,

        'status' =>
            $request->status,
    ]);

    return response()->json([
        'message' => 'Updated Successfully'
    ]);
}
public function apiDelete($id)
{
    StatutoryCompliance::findOrFail($id)
        ->delete();

    return response()->json([
        'message' => 'Deleted Successfully'
    ]);
}
public function apideleted()
{
    return response()->json(
        StatutoryCompliance::onlyTrashed()
            ->latest()
            ->get()
    );
}
public function apirestore($id)
{
    StatutoryCompliance::onlyTrashed()
        ->findOrFail($id)
        ->restore();

    return response()->json([
        'message' => 'Restored Successfully'
    ]);
}
public function apiforceDelete($id)
{
    StatutoryCompliance::onlyTrashed()
        ->findOrFail($id)
        ->forceDelete();

    return response()->json([
        'message' => 'Permanently Deleted'
    ]);
}
}