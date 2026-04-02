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
            'name' => 'required|string|max:255|unique:hourly_pays,name',
            'category' => 'required',
            'earning_type' => 'required',
        ]);

        HourlyPay::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'code' => $request->code,
            'category' => $request->category,
            'taxable' => $request->has('taxable'),
            'pf' => $request->has('pf'),
            'esi' => $request->has('esi'),
            'earning_type' => $request->earning_type,
            'show_in_payslip' => $request->has('show_in_payslip'),
            'display_order' => $request->display_order,
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
        $workType = HourlyPay::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:hourly_pays,name,' . $id,
            'category' => 'required',
            'earning_type' => 'required',
        ]);

        $workType->update([
            'name' => $request->name,
            'code' => $request->code,
            'category' => $request->category,
            'taxable' => $request->has('taxable'),
            'pf' => $request->has('pf'),
            'esi' => $request->has('esi'),
            'earning_type' => $request->earning_type,
            'show_in_payslip' => $request->has('show_in_payslip'),
            'display_order' => $request->display_order,
        ]);

        return redirect()
            ->route('hr.payroll.hourly-pay.index')
            ->with('success', 'Work Type updated successfully');
    }
   public function deleted()
{
    $deleted = HourlyPay::onlyTrashed()->get();

    return view('hr.payroll.hourly_pay.deleted', compact('deleted'));
}
public function restore($id)
{
    HourlyPay::withTrashed()->findOrFail($id)->restore();

    return redirect()->back()->with('success', 'Restored successfully');
}

public function forceDelete($id)
{
    HourlyPay::withTrashed()->findOrFail($id)->forceDelete();

    return redirect()->back()->with('success', 'Deleted permanently');
}

    /**
     * Delete (Soft delete recommended)
     */
    public function destroy($id)
    {
        $workType = HourlyPay::findOrFail($id);

        $workType->delete();

        return redirect()
            ->route('hr.payroll.hourly-pay.index')
            ->with('success', 'Work Type deleted successfully');
    }
}