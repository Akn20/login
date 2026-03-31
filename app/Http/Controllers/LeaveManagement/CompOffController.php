<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompOff;
use App\Models\Staff;
use Illuminate\Support\Str;

class CompOffController extends Controller
{

    public function index()
    {
        $compoffs = CompOff::with('employee')->latest()->get();

        return view('admin.Leave_Management.compoffs.index', compact('compoffs'));
    }

    public function create()
    {
        $employees = Staff::where('status', 'Active')->orderBy('name')->get();

        return view('admin.Leave_Management.compoffs.form', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'       => 'required|exists:staff,id',
            'worked_on'         => 'required|date',
            'comp_off_credited' => 'required|numeric|min:0.1',
            'expiry_date'       => 'nullable|date|after_or_equal:worked_on',
        ]);

        CompOff::create([
            'id'                => Str::uuid(),
            'employee_id'       => $request->employee_id,
            'worked_on'         => $request->worked_on,
            'comp_off_credited' => $request->comp_off_credited,
            'expiry_date'       => $request->expiry_date,
        ]);

        return redirect()
            ->route('hr.compoffs.index')
            ->with('success', 'Comp-Off created successfully');
    }

    public function edit($id)
    {
        $compoff   = CompOff::findOrFail($id);
        $employees = Staff::where('status', 'Active')->orderBy('name')->get();

        return view('admin.Leave_Management.compoffs.form', compact('compoff', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id'       => 'required|exists:staff,id',
            'worked_on'         => 'required|date',
            'comp_off_credited' => 'required|numeric|min:0.1',
            'expiry_date'       => 'nullable|date|after_or_equal:worked_on',
        ]);

        $compoff = CompOff::findOrFail($id);

        $compoff->update([
            'employee_id'       => $request->employee_id,   //  was missing
            'worked_on'         => $request->worked_on,
            'comp_off_credited' => $request->comp_off_credited,
            'expiry_date'       => $request->expiry_date,
        ]);

        return redirect()
            ->route('hr.compoffs.index')
            ->with('success', 'Comp-Off updated successfully');
    }

    public function destroy($id)
    {
        CompOff::findOrFail($id)->delete();

        return redirect()
            ->route('hr.compoffs.index')
            ->with('success', 'Comp-Off deleted successfully');
    }

    public function deleted()
    {
        $compoffs = CompOff::onlyTrashed()->get();

        return view('admin.Leave_Management.compoffs.deleted', compact('compoffs'));
    }

    public function restore($id)
    {
        CompOff::onlyTrashed()->where('id', $id)->restore();

        return redirect()
            ->route('hr.compoffs.deleted')
            ->with('success', 'Comp-Off restored successfully');
    }

    public function forceDelete($id)
    {
        CompOff::onlyTrashed()->where('id', $id)->forceDelete();

        return redirect()
            ->route('hr.compoffs.deleted')
            ->with('success', 'Comp-Off permanently deleted');
    }



    /*
|--------------------------------------------------------------------------
| API FUNCTIONS FOR MOBILE APP
|--------------------------------------------------------------------------
*/

public function apiIndex()
{
    $compoffs = CompOff::with('employee')->latest()->get();

    return response()->json([
        'status' => true,
        'data' => $compoffs
    ]);
}

public function apiShow($id)
{
    $compoff = CompOff::with('employee')->find($id);

    if (!$compoff) {
        return response()->json([
            'status' => false,
            'message' => 'CompOff not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'data' => $compoff
    ]);
}

public function apiStore(Request $request)
{
    $request->validate([
        'employee_id' => 'required|exists:staff,id',
        'worked_on' => 'required|date',
        'comp_off_credited' => 'required|numeric|min:0.1',
        'expiry_date' => 'nullable|date|after_or_equal:worked_on'
    ]);

    $compoff = CompOff::create([
        'id' => Str::uuid(),
        'employee_id' => $request->employee_id,
        'worked_on' => $request->worked_on,
        'comp_off_credited' => $request->comp_off_credited,
        'expiry_date' => $request->expiry_date,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Comp Off created successfully',
        'data' => $compoff
    ]);
}

public function apiUpdate(Request $request, $id)
{
    $request->validate([
        'employee_id' => 'required|exists:staff,id',
        'worked_on' => 'required|date',
        'comp_off_credited' => 'required|numeric|min:0.1',
        'expiry_date' => 'nullable|date|after_or_equal:worked_on'
    ]);

    $compoff = CompOff::find($id);

    if (!$compoff) {
        return response()->json([
            'status' => false,
            'message' => 'CompOff not found'
        ], 404);
    }

    $compoff->update([
        'employee_id' => $request->employee_id,
        'worked_on' => $request->worked_on,
        'comp_off_credited' => $request->comp_off_credited,
        'expiry_date' => $request->expiry_date,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Comp Off updated successfully',
        'data' => $compoff
    ]);
}

public function apiDestroy($id)
{
    $compoff = CompOff::find($id);

    if (!$compoff) {
        return response()->json([
            'status' => false,
            'message' => 'CompOff not found'
        ], 404);
    }

    $compoff->delete();

    return response()->json([
        'status' => true,
        'message' => 'Comp Off deleted successfully'
    ]);
}

public function apiDeleted()
{
    $compoffs = CompOff::with('employee')->onlyTrashed()->get();

    return response()->json([
        'status' => true,
        'data' => $compoffs
    ]);
}
public function apiRestore($id)
{
    $compoff = CompOff::withTrashed()->find($id);

    if (!$compoff) {
        return response()->json([
            'status' => false,
            'message' => 'CompOff not found'
        ], 404);
    }

    $compoff->restore();

    return response()->json([
        'status' => true,
        'message' => 'CompOff restored successfully'
    ]);
}

public function apiForceDelete($id)
{
    $compoff = CompOff::onlyTrashed()->where('id', $id)->first();

    if (!$compoff) {
        return response()->json([
            'status' => false,
            'message' => 'CompOff not found'
        ], 404);
    }

    $compoff->forceDelete();

    return response()->json([
        'status' => true,
        'message' => 'Comp Off permanently deleted'
    ]);
}
}