<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HourlyPay;
use Illuminate\Support\Str;

class HourlyPayController extends Controller
{
    /**
     * Display list
     */
    public function index()
    {
        $workTypes = HourlyPay::latest()->get();
        return view('hr.payroll.hourly_pay.index', compact('workTypes'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('hr.payroll.hourly_pay.create');
    }

    /**
     * Store new record
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:hourly_pays,code',
            'name' => 'required|string|max:255|unique:hourly_pays,name',
            'category' => 'required',
            'earning_type' => 'required',
        ]);

        HourlyPay::create([
            'id' => (string) Str::uuid(),

            'code' => $request->code,
            'name' => $request->name,
            'category' => $request->category,

            // ✅ CHECKBOX FIX
            'is_taxable'   => $request->has('is_taxable'),
            'pf_applicable'=> $request->has('pf_applicable'),
            'esi_applicable'=> $request->has('esi_applicable'),
            'pt_applicable'=> $request->has('pt_applicable'),
            'is_prorata'   => $request->has('is_prorata'),
            'lop_impact'   => $request->has('lop_impact'),

            'earning_type' => $request->earning_type,

            // Payslip
            'show_in_payslip' => $request->has('show_in_payslip'),
            'payslip_label'   => $request->payslip_label,
            'display_order'   => $request->display_order ?? 0,

            'status' => $request->status ?? 'active',
        ]);

        return redirect()
            ->route('hr.payroll.hourly-pay.index')
            ->with('success', 'Work Type created successfully');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $hourlyPay = HourlyPay::findOrFail($id);
        return view('hr.payroll.hourly_pay.edit', compact('hourlyPay'));
    }

    /**
     * Show details
     */
    public function show($id)
    {
        $hourlyPay = HourlyPay::findOrFail($id);
        return view('hr.payroll.hourly_pay.show', compact('hourlyPay'));
    }

    /**
     * Update record
     */
    public function update(Request $request, $id)
    {
        $hourlyPay = HourlyPay::findOrFail($id);

        $request->validate([
            'code' => 'required|unique:hourly_pays,code,' . $id,
            'name' => 'required|string|max:255|unique:hourly_pays,name,' . $id,
            'category' => 'required',
            'earning_type' => 'required',
        ]);

        $hourlyPay->update([

            'code' => $request->code,
            'name' => $request->name,
            'category' => $request->category,

            // ✅ CHECKBOX FIX
            'is_taxable'   => $request->has('is_taxable'),
            'pf_applicable'=> $request->has('pf_applicable'),
            'esi_applicable'=> $request->has('esi_applicable'),
            'pt_applicable'=> $request->has('pt_applicable'),
            'is_prorata'   => $request->has('is_prorata'),
            'lop_impact'   => $request->has('lop_impact'),

            'earning_type' => $request->earning_type,

            // Payslip
            'show_in_payslip' => $request->has('show_in_payslip'),
            'payslip_label'   => $request->payslip_label,
            'display_order'   => $request->display_order ?? 0,

            'status' => $request->status ?? 'active',
        ]);

        return redirect()
            ->route('hr.payroll.hourly-pay.index')
            ->with('success', 'Work Type updated successfully');
    }

    /**
     * Deleted list
     */
    public function deleted()
    {
        $deleted = HourlyPay::onlyTrashed()->get();
        return view('hr.payroll.hourly_pay.deleted', compact('deleted'));
    }

    /**
     * Restore
     */
    public function restore($id)
    {
        HourlyPay::withTrashed()->findOrFail($id)->restore();

        return redirect()->back()->with('success', 'Restored successfully');
    }

    /**
     * Permanent delete
     */
    public function forceDelete($id)
    {
        HourlyPay::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->back()->with('success', 'Deleted permanently');
    }

    /**
     * Soft delete
     */
    public function destroy($id)
    {
        $hourlyPay = HourlyPay::findOrFail($id);
        $hourlyPay->delete();

        return redirect()
            ->route('hr.payroll.hourly-pay.index')
            ->with('success', 'Work Type deleted successfully');
    }
}