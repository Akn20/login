<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\PayrollDeduction;
use Illuminate\Http\Request;

class PayrollDeductionController extends Controller
{
    public function index()
    {
        $deductions = PayrollDeduction::orderBy('display_name')->paginate(15);

        return view('hr.payroll.deduction.index', compact('deductions'));
    }

    public function create()
    {
        return view('hr.payroll.deduction.form');
    }

    public function show(string $id)
    {
        $deduction = PayrollDeduction::findOrFail($id);

        return view('hr.payroll.deduction.show', compact('deduction'));
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest($request);

        PayrollDeduction::create($data);

        return redirect()
            ->route('hr.payroll.deduction.index')
            ->with('success', 'Deduction created successfully.');
    }

    public function edit(string $id)
    {
        $deduction = PayrollDeduction::findOrFail($id);

        return view('hr.payroll.deduction.form', compact('deduction'));
    }

    public function update(Request $request, string $id)
    {
        $deduction = PayrollDeduction::findOrFail($id);

        $data = $this->validateRequest($request, $deduction->id);

        $deduction->update($data);

        return redirect()
            ->route('hr.payroll.deduction.index')
            ->with('success', 'Deduction updated successfully.');
    }

    public function destroy(string $id)
    {
        $deduction = PayrollDeduction::findOrFail($id);

        $deduction->delete();

        return redirect()
            ->route('hr.payroll.deduction.index')
            ->with('success', 'Deduction deleted successfully.');
    }

    public function deleted()
    {
        $deductions = PayrollDeduction::onlyTrashed()->paginate(15);

        return view('hr.payroll.deduction.deleted', compact('deductions'));
    }

    public function restore(string $id)
    {
        $deduction = PayrollDeduction::onlyTrashed()->findOrFail($id);

        $deduction->restore();

        return redirect()
            ->route('hr.payroll.deduction.index')
            ->with('success', 'Deduction restored successfully.');
    }

    public function forceDelete(string $id)
    {
        $deduction = PayrollDeduction::onlyTrashed()->findOrFail($id);

        $deduction->forceDelete();

        return redirect()
            ->route('hr.payroll.deduction.index')
            ->with('success', 'Deduction deleted successfully.');
    }

    protected function validateRequest(Request $request, ?string $id = null): array
    {
        $nameRule = 'required|string|max:255|unique:deductions,name';
        if ($id) {
            $nameRule .= ','.$id.',id';
        }

        return $request->validate([
            'name' => $nameRule,
            'display_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'nature' => ['required', 'in:FIXED,VARIABLE'],
            'category' => ['required', 'in:RECURRING,ADHOC'],
            'lop_impact' => ['required', 'in:YES,NO'],
            'prorata_applicable' => ['required', 'in:YES,NO'],
            'tax_deductible' => ['required', 'in:YES,NO'],
            'pf_impact' => ['required', 'in:YES,NO'],
            'esi_impact' => ['required', 'in:YES,NO'],
            'pt_impact' => ['required', 'in:YES,NO'],
            'rule_set_code' => ['nullable', 'string', 'max:255'],
            'show_in_payslip' => ['required', 'in:YES,NO'],
            'payslip_order' => ['nullable', 'integer'],
            'status' => ['required', 'in:ACTIVE,INACTIVE'],
        ]);
    }
}
