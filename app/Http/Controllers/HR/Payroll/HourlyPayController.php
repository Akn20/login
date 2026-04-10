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

            'status' => $request->input('status', 'active'),
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

            //  CHECKBOX FIX
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

            'status' => $request->input('status', 'active'),
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



    //Api Methods 
    public function apiIndex()
{
    return response()->json([
        'data' => HourlyPay::latest()->get()
    ]);
}
public function apiStore(Request $request)
{
    $request->validate([
        'code' => 'required|unique:hourly_pays,code',
        'name' => 'required|string|max:255|unique:hourly_pays,name',
        'category' => 'required',
        'earning_type' => 'required|in:fixed,variable',
        'display_order' => 'nullable|numeric',
    ]);

    $data = HourlyPay::create([
        'id' => (string) \Illuminate\Support\Str::uuid(),

        'code' => $request->code,
        'name' => $request->name,
        'category' => $request->category,

        'is_taxable' => (bool) $request->is_taxable,
        'pf_applicable' => (bool) $request->pf_applicable,
        'esi_applicable' => (bool) $request->esi_applicable,
        'pt_applicable' => (bool) $request->pt_applicable,
        'is_prorata' => (bool) $request->is_prorata,
        'lop_impact' => (bool) $request->lop_impact,

        'earning_type' => $request->earning_type,

        'show_in_payslip' => (bool) $request->show_in_payslip,
        'payslip_label' => $request->payslip_label,
        'display_order' => $request->display_order ?? 0,

        'status' => $request->status ?? 'active',
    ]);

    return response()->json([
        'message' => 'Created successfully',
        'data' => $data
    ]);
}
public function apiShow($id)
{
    return response()->json([
        'data' => HourlyPay::findOrFail($id)
    ]);
}
public function apiUpdate(Request $request, $id)
{
    $data = HourlyPay::findOrFail($id);

    $request->validate([
        'code' => 'required|unique:hourly_pays,code,' . $id,
        'name' => 'required|string|max:255|unique:hourly_pays,name,' . $id,
        'category' => 'required',
        'earning_type' => 'required|in:fixed,variable',
        'display_order' => 'nullable|numeric',
    ]);

    $data->update([
        'code' => $request->code,
        'name' => $request->name,
        'category' => $request->category,

        'is_taxable' => (bool) $request->is_taxable,
        'pf_applicable' => (bool) $request->pf_applicable,
        'esi_applicable' => (bool) $request->esi_applicable,
        'pt_applicable' => (bool) $request->pt_applicable,
        'is_prorata' => (bool) $request->is_prorata,
        'lop_impact' => (bool) $request->lop_impact,

        'earning_type' => $request->earning_type,

        'show_in_payslip' => (bool) $request->show_in_payslip,
        'payslip_label' => $request->payslip_label,
        'display_order' => $request->display_order ?? 0,

        'status' => $request->status ?? 'active',
    ]);

    return response()->json([
        'message' => 'Updated successfully',
        'data' => $data
    ]);
}
public function apiDestroy($id)
{
    \Log::info("Deleting ID: " . $id);

    $data = HourlyPay::findOrFail($id);
    $data->delete();

    return response()->json([
        'message' => 'Deleted successfully'
    ]);
}
public function apiDeleted()
{
    return response()->json([
        'data' => HourlyPay::onlyTrashed()->get()
    ]);
}
public function apiRestore($id)
{
    HourlyPay::withTrashed()->findOrFail($id)->restore();

    return response()->json([
        'message' => 'Restored successfully'
    ]);
}
public function apiForceDelete($id)
{
    HourlyPay::withTrashed()->findOrFail($id)->forceDelete();

    return response()->json([
        'message' => 'Deleted permanently'
    ]);
}
}