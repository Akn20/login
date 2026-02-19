<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialYear;
use Illuminate\Http\Request;

class FinancialYearController extends Controller
{
    /**
     * Display a listing of financial years (with filters).
     */
    public function index(Request $request)
    {
        $query = FinancialYear::query();

        // Filter by active/inactive (TC_FY_009)
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Filter by start year
        if ($request->filled('start_year')) {
            $year = (int) $request->input('start_year');
            $query->whereYear('start_date', $year);
        }

        $financialYears = $query
            ->orderBy('start_date', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.financial-years.index', compact('financialYears'));
    }

    /**
     * Show the form for creating a new financial year.
     */
    public function create()
    {
        return view('admin.financial-years.create');
    }

    /**
     * Store a newly created financial year in storage.
     * Covers TC_FY_001, 002, 003, 004, 005, 013, AUD_001.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255|unique:financial_years,code',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active'); // checkbox

        // Prevent overlapping financial years (TC_FY_003)
        $overlapExists = FinancialYear::where(function ($q) use ($data) {
            $q->where('start_date', '<', $data['end_date'])
                ->where('end_date', '>', $data['start_date']);
        })->exists();

        if ($overlapExists) {
            return back()
                ->withErrors(['start_date' => 'The selected date range overlaps an existing financial year.'])
                ->withInput();
        }

        // If this FY is active, deactivate others (TC_FY_005, TC_FY_013)
        if ($data['is_active']) {
            FinancialYear::where('is_active', true)->update(['is_active' => false]);
        }

        FinancialYear::create($data);

        return redirect()
            ->route('admin.financial-years.index')
            ->with('success', 'Financial year created successfully.');
    }

    /**
     * Show the form for editing the specified financial year.
     */
    public function edit(FinancialYear $financial_year)
    {
        return view('admin.financial-years.edit', [
            'financialYear' => $financial_year,
        ]);
    }

    /**
     * Update the specified financial year in storage.
     * Covers edit + overlap + unique + status (TC_FY_006, 007, 013, AUD_002).
     */
    public function update(Request $request, FinancialYear $financial_year)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255|unique:financial_years,code,' . $financial_year->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        // Prevent overlapping financial years (excluding current) (TC_FY_007)
        $overlapExists = FinancialYear::where('id', '!=', $financial_year->id)
            ->where(function ($q) use ($data) {
                $q->where('start_date', '<', $data['end_date'])
                    ->where('end_date', '>', $data['start_date']);
            })
            ->exists();

        if ($overlapExists) {
            return back()
                ->withErrors(['start_date' => 'The selected date range overlaps an existing financial year.'])
                ->withInput();
        }

        // Maintain single active FY rule if needed
        if ($data['is_active']) {
            FinancialYear::where('id', '!=', $financial_year->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $financial_year->update($data);

        return redirect()
            ->route('admin.financial-years.index')
            ->with('success', 'Financial year updated successfully.');
    }

    /**
     * Soft delete the specified financial year. (TC_FY_010)
     */
    public function destroy(FinancialYear $financial_year)
    {
        $financial_year->delete();

        return redirect()
            ->route('admin.financial-years.index')
            ->with('success', 'Financial year deleted successfully.');
    }

    /**
     * List soft-deleted financial years (Recycle Bin view).
     */
    public function deleted()
    {
        $financialYears = FinancialYear::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(15);

        return view('admin.financial-years.deleted', compact('financialYears'));
    }

    /**
     * Restore a soft-deleted financial year.
     */
    public function restore(string $id)
    {
        $financialYear = FinancialYear::onlyTrashed()->findOrFail($id);

        $financialYear->restore();

        return redirect()
            ->route('admin.financial-years.deleted')
            ->with('success', 'Financial year restored successfully.');
    }

    /**
     * Permanently delete a soft-deleted financial year.
     */
    public function forceDelete(string $id)
    {
        $financialYear = FinancialYear::onlyTrashed()->findOrFail($id);

        $financialYear->forceDelete();

        return redirect()
            ->route('admin.financial-years.deleted')
            ->with('success', 'Financial year permanently deleted.');
    }

    /**
     * Toggle active/inactive status via AJAX. (TC_FY_013)
     */
    public function toggleStatus(FinancialYear $financial_year)
    {
        $financial_year->is_active = !$financial_year->is_active;
        $financial_year->save();

        return response()->json([
            'success' => true,
            'is_active' => (bool) $financial_year->is_active,
        ]);
    }
}
