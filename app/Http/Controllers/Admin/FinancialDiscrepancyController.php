<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FinancialDiscrepancy;
use App\Models\FinancialReconciliation;

class FinancialDiscrepancyController extends Controller
{
    /**
     * List Page
     */
    public function index()
    {
        $discrepancies = FinancialDiscrepancy::with('financialReconciliation')
            ->latest()
            ->get();

        return view(
            'admin.accountant.financial_discrepancy.index',
            compact('discrepancies')
        );
    }

    /**
     * Create Page
     */
    public function search(Request $request)
{
    $query = FinancialDiscrepancy::with(
        'financialReconciliation'
    );

    // SEARCH BY ISSUE TYPE
    if ($request->filled('search')) {

        $query->where(
            'issue_type',
            'LIKE',
            '%' . $request->search . '%'
        );
    }

    // SEARCH BY STATUS
    if ($request->filled('status')) {

        $query->where(
            'status',
            $request->status
        );
    }

    $discrepancies =$query->latest()->get();

    return view(
        'admin.accountant.financial_discrepancy.index',
        compact('discrepancies')
    );
}
    
    
    public function create()
    {
        $reconciliations = FinancialReconciliation::latest()->get();

        return view(
            'admin.accountant.financial_discrepancy.create',
            compact('reconciliations')
        );
    }

    /**
     * Store
     */
    public function store(Request $request)
    {
        $request->validate([

            'financial_reconciliation_id' =>
                'required|exists:financial_reconciliations,id',

            'issue_type' =>
                'required|string|max:255',

            'expected_amount' =>
                'required|numeric|min:0',

            'actual_amount' =>
                'required|numeric|min:0',

            'remarks' =>
                'nullable|string',
        ]);

        $difference =
    $request->expected_amount -
    $request->actual_amount;

$discrepancy = FinancialDiscrepancy::create([

    'financial_reconciliation_id' =>
        $request->financial_reconciliation_id,

    'issue_type' =>
        $request->issue_type,

    'expected_amount' =>
        $request->expected_amount,

    'actual_amount' =>
        $request->actual_amount,

    'difference_amount' =>
        $difference,

    'status' =>
        $difference == 0
        ? 'Resolved'
        : 'Open',

    'remarks' =>
        $request->remarks,
]);

        return redirect()
            ->route(
                'admin.financial-discrepancy.index'
            )
            ->with(
                'success',
                'Discrepancy added successfully'
            );
    }

    /**
     * View Page
     */
    public function show($id)
    {
        $discrepancy = FinancialDiscrepancy::with('financialReconciliation')
            ->findOrFail($id);

        return view(
            'admin.accountant.financial_discrepancy.view',
            compact('discrepancy')
        );
    }

    /**
     * Edit Page
     */
    public function edit($id)
    {
        $discrepancy = FinancialDiscrepancy::findOrFail($id);

        $reconciliations = FinancialReconciliation::latest()->get();

        return view(
            'admin.accountant.financial_discrepancy.edit',
            compact(
                'discrepancy',
                'reconciliations'
            )
        );
    }

    /**
     * Update
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'financial_reconciliation_id' =>
                'required|exists:financial_reconciliations,id',

            'issue_type' =>
                'required|string|max:255',

            'expected_amount' =>
                'required|numeric|min:0',

            'actual_amount' =>
                'required|numeric|min:0',

            
            'remarks' =>
                'nullable|string',
        ]);

        $discrepancy = FinancialDiscrepancy::findOrFail($id);

       $difference =
    $request->expected_amount -
    $request->actual_amount;

$discrepancy->update([

    'financial_reconciliation_id' =>
        $request->financial_reconciliation_id,

    'issue_type' =>
        $request->issue_type,

    'expected_amount' =>
        $request->expected_amount,

    'actual_amount' =>
        $request->actual_amount,

    'difference_amount' =>
        $difference,

    'status' => $request->status,
       
    'remarks' =>
        $request->remarks,
]);
        return redirect()
            ->route(
                'admin.financial-discrepancy.index'
            )
            ->with(
                'success',
                'Discrepancy updated successfully'
            );
    }

    /**
     * Delete
     */
    public function destroy($id)
    {
        $discrepancy = FinancialDiscrepancy::findOrFail($id);

        $discrepancy->delete();

        return back()->with(
            'success',
            'Discrepancy deleted successfully'
        );
    }

    /**
     * Deleted List
     */
    public function deleted()
    {
        $discrepancies = FinancialDiscrepancy::onlyTrashed()
            ->latest()
            ->get();

        return view(
            'admin.accountant.financial_discrepancy.deleted',
            compact('discrepancies')
        );
    }

    /**
     * Restore
     */
    public function restore($id)
    {
        $discrepancy = FinancialDiscrepancy::withTrashed()
            ->findOrFail($id);

        $discrepancy->restore();

        return back()->with(
            'success',
            'Discrepancy restored successfully'
        );
    }

    /**
     * Permanent Delete
     */
    public function forceDelete($id)
    {
        $discrepancy = FinancialDiscrepancy::withTrashed()
            ->findOrFail($id);

        $discrepancy->forceDelete();

        return back()->with(
            'success',
            'Discrepancy permanently deleted'
        );
    }

    public function apiIndex()
{
    $discrepancies = FinancialDiscrepancy::with('financialReconciliation')
        ->latest()
        ->get();

    return response()->json([
        'status' => true,
        'data' => $discrepancies
    ]);
}

public function apiShow($id)
{
    $discrepancy = FinancialDiscrepancy::with('financialReconciliation')
        ->findOrFail($id);

    return response()->json([
        'status' => true,
        'data' => $discrepancy
    ]);
}
public function apiStore(Request $request)
{
    $request->validate([

        'financial_reconciliation_id' =>
            'required|exists:financial_reconciliations,id',

        'issue_type' =>
            'required|string|max:255',

        'expected_amount' =>
            'required|numeric|min:0',

        'actual_amount' =>
            'required|numeric|min:0',

        'remarks' =>
            'nullable|string',
    ]);

    $difference =
        $request->expected_amount -
        $request->actual_amount;

    $discrepancy = FinancialDiscrepancy::create([

        'financial_reconciliation_id' =>
            $request->financial_reconciliation_id,

        'issue_type' =>
            $request->issue_type,

        'expected_amount' =>
            $request->expected_amount,

        'actual_amount' =>
            $request->actual_amount,

        'difference_amount' =>
            $difference,

        'status' =>
            $difference == 0
            ? 'Resolved'
            : 'Open',

        'remarks' =>
            $request->remarks,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Discrepancy created successfully',
        'data' => $discrepancy
    ]);
}

public function apiUpdate(Request $request, $id)
{
    $discrepancy = FinancialDiscrepancy::findOrFail($id);

    $request->validate([

        'financial_reconciliation_id' =>
            'required|exists:financial_reconciliations,id',

        'issue_type' =>
            'required|string|max:255',

        'expected_amount' =>
            'required|numeric|min:0',

        'actual_amount' =>
            'required|numeric|min:0',

        'remarks' =>
            'nullable|string',
    ]);

    $difference =
        $request->expected_amount -
        $request->actual_amount;

    $discrepancy->update([

        'financial_reconciliation_id' =>
            $request->financial_reconciliation_id,

        'issue_type' =>
            $request->issue_type,

        'expected_amount' =>
            $request->expected_amount,

        'actual_amount' =>
            $request->actual_amount,

        'difference_amount' =>
            $difference,

        'status' =>
            $difference == 0
            ? 'Resolved'
            : 'Open',

        'remarks' =>
            $request->remarks,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Discrepancy updated successfully'
    ]);
}
public function apiDelete($id)
{
    $discrepancy = FinancialDiscrepancy::findOrFail($id);

    $discrepancy->delete();

    return response()->json([
        'status' => true,
        'message' => 'Discrepancy deleted successfully'
    ]);
}
public function apiDeleted()
{
    $discrepancies = FinancialDiscrepancy::onlyTrashed()
        ->latest()
        ->get();

    return response()->json([
        'status' => true,
        'data' => $discrepancies
    ]);
}
public function apiRestore($id)
{
    $discrepancy = FinancialDiscrepancy::withTrashed()
        ->findOrFail($id);

    $discrepancy->restore();

    return response()->json([
        'status' => true,
        'message' => 'Discrepancy restored successfully'
    ]);
}

public function apiForceDelete($id)
{
    $discrepancy = FinancialDiscrepancy::withTrashed()
        ->findOrFail($id);

    $discrepancy->forceDelete();

    return response()->json([
        'status' => true,
        'message' => 'Discrepancy permanently deleted'
    ]);
}

public function apiSearch(Request $request)
{
    $query = FinancialDiscrepancy::with(
        'financialReconciliation'
    );

    if ($request->filled('search')) {

        $query->where(
            'issue_type',
            'LIKE',
            '%' . $request->search . '%'
        );
    }

    if ($request->filled('status')) {

        $query->where(
            'status',
            $request->status
        );
    }

    $discrepancies = $query->latest()->get();

    return response()->json([
        'status' => true,
        'data' => $discrepancies
    ]);
}
}