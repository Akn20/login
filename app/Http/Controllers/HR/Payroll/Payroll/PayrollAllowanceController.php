<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Allowance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayrollAllowanceController extends Controller
{
    // ================= INDEX =================
    public function index(Request $request)
    {
        $type = $request->type;

        $allowances = Allowance::where('type', $type)
            ->latest()
            ->paginate(10);

        if($request->wantsJson()) {
            $apires= Allowance::where('type', $type)->latest()->get();
            return response()->json($apires);
        }

        if ($type === 'fixed') {
            return view('hr.payroll.fixed_allowance.index', compact('allowances', 'type'));
        } else {
            return view('hr.payroll.variable_allowance.index', compact('allowances', 'type'));
        }
    }

    // ================= CREATE =================
    public function create(Request $request)
    {
        $type = $request->type ?? 'fixed';

        if ($type === 'fixed') {
            return view('hr.payroll.fixed_allowance.form', compact('type'));
        } else {
            return view('hr.payroll.variable_allowance.form', compact('type'));
        }
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $type = $request->type;

        // 🔥 BASE RULES
        $rules = [
            'name' => 'required|unique:allowances,name',
            'display_name' => 'required|string',
            'description' => 'nullable|string', 

            'taxable' => 'nullable|boolean',
            'tax_exemption_section' => 'nullable|string',

            'pf_applicable' => 'nullable|boolean',
            'esi_applicable' => 'nullable|boolean',
            'pt_applicable' => 'nullable|boolean',
            'tds_applicable' => 'nullable|boolean',

            'show_in_payslip' => 'nullable|boolean',
            'display_order' => 'nullable|integer',

            'status' => 'nullable|boolean',
        ];

        // 🔥 FIXED ONLY
        if ($type === 'fixed') {
            $rules = array_merge($rules, [
                'pay_frequency' => 'required',
                'start_date' => 'nullable|date',

                'calculation_type' => 'required',
                'calculation_base' => 'nullable',
                'calculation_value' => 'nullable|numeric',
                'rounding_rule' => 'nullable|in:nearest,up,down,none',
                'max_limit' => 'nullable|numeric',

                'effective_from' => 'nullable|date',
                'effective_to' => 'nullable|date',

                'lop_impact' => 'nullable|boolean',
                'prorata' => 'nullable|boolean',

            ]);
        }

        $validated = $request->validate($rules);

        // 🔥 DEFAULTS
        $validated = array_merge([
            'lop_impact' => 0,
            'prorata' => 0,
            'taxable' => 0,
            'pf_applicable' => 0,
            'esi_applicable' => 0,
            'pt_applicable' => 0,
            'tds_applicable' => 0,
            'show_in_payslip' => 0,
            'status' => 1,
            'type' => $type,
        ], $validated);

        // 🔥 CLEAN VARIABLE
        if ($type === 'variable') {
            $validated['calculation_type'] = null;
            $validated['calculation_base'] = null;
            $validated['calculation_value'] = null;
            $validated['rounding_rule'] = null;
            $validated['max_limit'] = null;
            $validated['lop_impact'] = 0;
            $validated['prorata'] = 0;
            $validated['pay_frequency'] = null;
            $validated['effective_from'] = null;
            $validated['effective_to'] = null;
        }
        Log::info($validated);
        Allowance::create($validated);
        if(request()->wantsJson()) {
            return response()->json(['status' => true, 'message' => ucfirst($type) . ' allowance created successfully']);
        }

        return redirect()
            ->route('hr.payroll.allowance.index', ['type' => $type])
            ->with('success', ucfirst($type) . ' allowance created successfully');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $allowance = Allowance::findOrFail($id);

        if ($allowance->type === 'fixed') {
            return view('hr.payroll.fixed_allowance.form', compact('allowance'));
        } else {
            return view('hr.payroll.variable_allowance.form', compact('allowance'));
        }
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $allowance = Allowance::findOrFail($id);
        $type = $allowance->type;

        $rules = [
            'name' => 'required|unique:allowances,name,' . $id,
            'display_name' => 'required|string',
            'description' => 'nullable|string',

            'taxable' => 'nullable|boolean',
            'tax_exemption_section' => 'nullable|string',

            'pf_applicable' => 'nullable|boolean',
            'esi_applicable' => 'nullable|boolean',
            'pt_applicable' => 'nullable|boolean',
            'tds_applicable' => 'nullable|boolean',

            'show_in_payslip' => 'nullable|boolean',
            'display_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ];

        if ($type === 'fixed') {
            $rules = array_merge($rules, [
                'pay_frequency' => 'required',
                'start_date' => 'nullable|date',

                'calculation_type' => 'required',
                'calculation_base' => 'nullable',
                'calculation_value' => 'nullable|numeric',
                'rounding_rule' => 'nullable|in:nearest,up,down,none',
                'max_limit' => 'nullable|numeric',

                'effective_from' => 'nullable|date',
                'effective_to' => 'nullable|date',

                'lop_impact' => 'nullable|boolean',
                'prorata' => 'nullable|boolean',
            ]);
        }

        $validated = $request->validate($rules);

        $validated = array_merge([
            'lop_impact' => 0,
            'prorata' => 0,
            'taxable' => 0,
            'pf_applicable' => 0,
            'esi_applicable' => 0,
            'pt_applicable' => 0,
            'tds_applicable' => 0,
            'show_in_payslip' => 0,
            'status' => 1,
        ], $validated);

        if ($type === 'variable') {
              $validated['calculation_type'] = null;
            $validated['calculation_base'] = null;
            $validated['calculation_value'] = null;
            $validated['rounding_rule'] = null;
            $validated['max_limit'] = null;
            $validated['lop_impact'] = 0;
            $validated['prorata'] = 0;
            $validated['pay_frequency'] = null;
            $validated['effective_from'] = null;
            $validated['effective_to'] = null;

        }

        $allowance->update($validated);
        if(request()->wantsJson()) {
            return response()->json(['status' => true, 'message' => ucfirst($type) . ' allowance updated successfully']);
        }
        return redirect()
            ->route('hr.payroll.allowance.index', ['type' => $type])
            ->with('success', ucfirst($type) . ' allowance updated successfully');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $allowance = Allowance::findOrFail($id);
        $type = $allowance->type;

        $allowance->delete();
        if(request()->wantsJson()) {
            return response()->json(['status' => true, 'message' => 'Allowance deleted']);
        }
        return redirect()
            ->route('hr.payroll.allowance.index', ['type' => $type])
            ->with('success', 'Allowance deleted');
    }

    // ================= TRASH =================
    public function deleted(Request $request)
    {
        $type = $request->type;

        $allowances = Allowance::onlyTrashed()
            ->where('type', $type)
            ->get();
        if($request->wantsJson()) {
            return response()->json($allowances);
        }
        if($type === 'fixed') {
            return view('hr.payroll.fixed_allowance.deleted', compact('allowances', 'type'));
        }
        return view('hr.payroll.variable_allowance.deleted', compact('allowances', 'type'));
    }

    // ================= RESTORE =================
    public function restore($id)
    {
        $allowance = Allowance::withTrashed()->findOrFail($id);
        $type = $allowance->type;

        $allowance->restore();
        if(request()->wantsJson()) {
            return response()->json(['status' => true, 'message' => 'Allowance restored']);
        }   
        return redirect()
            ->route('hr.payroll.allowance.deleted', ['type' => $type])
            ->with('success', 'Allowance restored');
    }

    // ================= FORCE DELETE =================
    public function forceDelete($id)
    {
        $allowance = Allowance::withTrashed()->findOrFail($id);
        $type = $allowance->type;

        $allowance->forceDelete();
        if(request()->wantsJson()) {
            return response()->json(['status' => true, 'message' => 'Allowance permanently deleted']);
        }
        return redirect()
            ->route('hr.payroll.allowance.deleted', ['type' => $type])
            ->with('success', 'Allowance permanently deleted');
    }
}