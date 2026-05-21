<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RateEmployeeMapping;
use App\Models\DeductionRuleSet;
use App\Models\HourlyPay;
use App\Models\Staff;

class RateEmployeeMappingController extends Controller
{

    /* ================= INDEX ================= */
    public function index(Request $request)
{
    $rateMappings = RateEmployeeMapping::with('employee') // ✅ ADD THIS
        ->latest()
        ->paginate(10);

    if ($request->wantsJson()) {
        return response()->json([
            'success' => true,
            'data' => $rateMappings
        ]);
    }

    return view(
        'hr.payroll.rate_employee_mapping.index',
        compact('rateMappings')
    );
}

    /* ================= CREATE ================= */
    public function create(Request $request)
    {
        $ruleSets = DeductionRuleSet::select('rule_set_code', 'rule_set_name')
            ->whereNull('deleted_at')->get();

        $workTypes = HourlyPay::select('code', 'name')
            ->whereNull('deleted_at')->get();

        $employees = Staff::select('id', 'name')
            ->whereNull('deleted_at')->get();

        $employeeTypes = ['Permanent', 'Contract', 'Temporary'];
        $employeeCategories = ['Full Time', 'Part Time', 'Consultant'];

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => compact(
                    'ruleSets',
                    'workTypes',
                    'employees',
                    'employeeTypes',
                    'employeeCategories'
                )
            ]);
        }

        return view(
            'hr.payroll.rate_employee_mapping.create',
            compact(
                'ruleSets',
                'workTypes',
                'employees',
                'employeeTypes',
                'employeeCategories'
            )
        );
    }

    /* ================= STORE ================= */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rule_set_code' => 'required|string|max:50',
            'rule_set_name' => 'required|string|max:100',
            'work_type_code' => 'required|string|max:50',
            'rate_type' => 'required|in:Flat,Multiplier',
            'base_rate_source' => 'required|in:Employee Rate,Rule Rate',
            'employee_type' => 'required|string|max:50',
            'base_rate_value' => 'nullable|numeric|min:0',
            'multiplier_value' => 'nullable|numeric|min:0',
            'maximum_hours' => 'nullable|numeric|min:1',
            'round_off_rule' => 'nullable|in:Nearest,Up,Down',
            'employee_id' => 'nullable|integer',
            'employee_category' => 'nullable|string|max:50'
        ]);

        // Conditional validations
        if ($request->rate_type === 'Flat' && empty($request->base_rate_value)) {
            return $request->wantsJson()
                ? response()->json(['error' => 'Base Rate Value required'], 422)
                : back()->withErrors(['base_rate_value' => 'Required'])->withInput();
        }

        if ($request->rate_type === 'Multiplier' && empty($request->multiplier_value)) {
            return $request->wantsJson()
                ? response()->json(['error' => 'Multiplier Value required'], 422)
                : back()->withErrors(['multiplier_value' => 'Required'])->withInput();
        }

        try {
            $record = RateEmployeeMapping::create($validated);
        } catch (\Exception $e) {
            return $request->wantsJson()
                ? response()->json(['error' => 'Duplicate Rule Set Code'], 422)
                : back()->withErrors(['rule_set_code' => 'Already exists'])->withInput();
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $record,
                'message' => 'Created successfully'
            ]);
        }

        return redirect()
            ->route('hr.payroll.rate-employee-mapping.index')
            ->with('success', 'Created successfully');
    }

    /* ================= SHOW ================= */
    public function show(Request $request, $id)
    {
        $rateMapping = RateEmployeeMapping::with('employee')->findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $rateMapping
            ]);
        }

        return view(
            'hr.payroll.rate_employee_mapping.show',
            compact('rateMapping')
        );
    }

    /* ================= EDIT ================= */
    public function edit(Request $request, $id)
    {
        $rateMapping = RateEmployeeMapping::findOrFail($id);

        $ruleSets = DeductionRuleSet::select('rule_set_code', 'rule_set_name')->get();
        $workTypes = HourlyPay::select('code', 'name')->get();
        $employees = Staff::select('id', 'name')->get();

        $employeeTypes = ['Permanent', 'Contract', 'Temporary'];
        $employeeCategories = ['Full Time', 'Part Time', 'Consultant'];

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => compact(
                    'rateMapping',
                    'ruleSets',
                    'workTypes',
                    'employees',
                    'employeeTypes',
                    'employeeCategories'
                )
            ]);
        }

        return view(
            'hr.payroll.rate_employee_mapping.edit',
            compact(
                'rateMapping',
                'ruleSets',
                'workTypes',
                'employees',
                'employeeTypes',
                'employeeCategories'
            )
        );
    }

    /* ================= UPDATE ================= */
    public function update(Request $request, $id)
    {
        $rateMapping = RateEmployeeMapping::findOrFail($id);

        $validated = $request->validate([
            'rule_set_code' => 'required|string|max:50|unique:rate_employee_mappings,rule_set_code,' . $id,
            'rule_set_name' => 'required|string|max:100',
            'work_type_code' => 'required|string|max:50',
            'rate_type' => 'required|in:Flat,Multiplier',
            'base_rate_source' => 'required|in:Employee Rate,Rule Rate',
            'employee_type' => 'required|string|max:50',
            'base_rate_value' => 'nullable|numeric|min:0',
            'multiplier_value' => 'nullable|numeric|min:0',
            'maximum_hours' => 'nullable|numeric|min:1',
            'round_off_rule' => 'nullable|in:Nearest,Up,Down',
            'employee_id' => 'nullable|integer',
            'employee_category' => 'nullable|string|max:50'
        ]);

        $rateMapping->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Updated successfully'
            ]);
        }

        return redirect()
            ->route('hr.payroll.rate-employee-mapping.index')
            ->with('success', 'Updated successfully');
    }

    /* ================= DELETE ================= */
    public function destroy(Request $request, $id)
    {
        $rateMapping = RateEmployeeMapping::findOrFail($id);
        $rateMapping->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully'
            ]);
        }

        return redirect()
            ->route('hr.payroll.rate-employee-mapping.index')
            ->with('success', 'Deleted');
    }

    /* ================= DELETED ================= */
    public function deleted(Request $request)
    {
        $rateMappings = RateEmployeeMapping::with('employee')
            ->onlyTrashed()
            ->paginate(10);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $rateMappings
            ]);
        }

        return view(
            'hr.payroll.rate_employee_mapping.deleted',
            compact('rateMappings')
        );
    }

    /* ================= RESTORE ================= */
    public function restore(Request $request, $id)
    {
        $rateMapping = RateEmployeeMapping::onlyTrashed()->findOrFail($id);
        $rateMapping->restore();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Restored successfully'
            ]);
        }

        return redirect()
            ->route('hr.payroll.rate-employee-mapping.index')
            ->with('success', 'Restored');
    }

    /* ================= FORCE DELETE ================= */
    public function forceDelete(Request $request, $id)
    {
        $rateMapping = RateEmployeeMapping::onlyTrashed()->findOrFail($id);
        $rateMapping->forceDelete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Permanently deleted'
            ]);
        }

        return redirect()
            ->route('hr.payroll.rate-employee-mapping.deleted')
            ->with('success', 'Deleted permanently');
    }
}