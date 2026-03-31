<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Allowance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayrollAllowanceController extends Controller
{

    // ================= INDEX =================
    public function index()
    {
        $allowances = Allowance::where('type', 'fixed')->paginate(10);
        return view('hr.Payroll.fixed_allowance.index', compact('allowances'));
    }

    // ================= CREATE =================
    public function create()
    {
        $type = request('type', 'fixed');
        return view('hr.Payroll.fixed_allowance.form', compact('type'));
    }

    // ================= STORE =================
    public function store(Request $request)
{
   $validated = $request->validate([
    'name' => 'required|unique:allowances,name',
    'display_name' => 'required|string',

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

    'taxable' => 'nullable|boolean',
    'tax_exemption_section' => 'nullable|string',

    'pf_applicable' => 'nullable|boolean',
    'esi_applicable' => 'nullable|boolean',
    'pt_applicable' => 'nullable|boolean',
    'tds_applicable' => 'nullable|boolean',

    'show_in_payslip' => 'nullable|boolean',
    'display_order' => 'nullable|integer',

    'status' => 'nullable|boolean',
]);

    // ✅ Default boolean values
    $validated = array_merge([
        'lop_impact' => 0,
        'prorata' => 0,
        'taxable' => 0,
        'pf_applicable' => 0,
        'esi_applicable' => 0,
        'show_in_payslip' => 0,
        'type' => 'fixed', 
    ], $validated);

    Allowance::create($validated);

    return redirect()
        ->route('hr.payroll.allowance.index')
        ->with('success', 'Allowance created successfully');
}
    // ================= SHOW =================
    public function show($id)
    {
        $allowance = Allowance::findOrFail($id);
        return view('hr.Payroll.fixed_allowance.show', compact('allowance'));
    }

    // ================= EDIT =================
    public function edit($id)
    {
        Log::info($id);
        $allowance = Allowance::findOrFail($id);
        return view('hr.Payroll.fixed_allowance.form', compact('allowance'));
    }

    // ================= UPDATE =================
   public function update(Request $request, $id)
{
    $allowance = Allowance::findOrFail($id);

$validated = $request->validate([
    'name' => 'required|unique:allowances,name,' . $id,
    'display_name' => 'required|string',

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

    'taxable' => 'nullable|boolean',
    'tax_exemption_section' => 'nullable|string',

    'pf_applicable' => 'nullable|boolean',
    'esi_applicable' => 'nullable|boolean',
    'pt_applicable' => 'nullable|boolean',
    'tds_applicable' => 'nullable|boolean',

    'show_in_payslip' => 'nullable|boolean',
    'display_order' => 'nullable|integer',

    'status' => 'nullable|boolean',
]);
    $validated = array_merge([
        'lop_impact' => 0,
        'prorata' => 0,
        'taxable' => 0,
        'pf_applicable' => 0,
        'esi_applicable' => 0,
        'show_in_payslip' => 0,
    ], $validated);

    $allowance->update($validated);

    return redirect()
        ->route('hr.payroll.allowance.index')
        ->with('success', 'Allowance updated successfully');
}
    // ================= DELETE =================
    public function destroy($id)
    {
        Allowance::findOrFail($id)->delete();

        return back()->with('success', 'Allowance deleted');
    }

    // ================= TRASH =================
    public function deleted()
    {
        $allowances = Allowance::onlyTrashed()->get();
        return view('hr.Payroll.fixed_allowance.deleted', compact('allowances'));
    }

    // ================= RESTORE =================
    public function restore($id)
    {
        Allowance::withTrashed()->findOrFail($id)->restore();

        return back()->with('success', 'Allowance restored');
    }

    // ================= FORCE DELETE =================
    public function forceDelete($id)
    {
        Allowance::withTrashed()->findOrFail($id)->forceDelete();

        return back()->with('success', 'Allowance permanently deleted');
    }
}
