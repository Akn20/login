<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialYear;
use Illuminate\Http\Request;

class FinancialYearController extends Controller
{
    public function index(Request $request)
    {
        $query = FinancialYear::query();

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->filled('start_year')) {
            $query->whereYear('start_date', (int) $request->input('start_year'));
        }

        $financialYears = $query
            ->orderBy('start_date', 'desc')
            ->paginate(15)
            ->withQueryString();

        // ✅ API RESPONSE
        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'data' => $financialYears
            ]);
        }

        // ✅ WEB RESPONSE
        return view('admin.financial-years.index', compact('financialYears'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255|unique:financial_years,code',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        // Overlap check
        $overlapExists = FinancialYear::where(function ($q) use ($data) {
            $q->where('start_date', '<', $data['end_date'])
              ->where('end_date', '>', $data['start_date']);
        })->exists();

        if ($overlapExists) {

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Date range overlaps existing financial year.'
                ], 422);
            }

            return back()
                ->withErrors(['start_date' => 'The selected date range overlaps an existing financial year.'])
                ->withInput();
        }

        if ($data['is_active']) {
            FinancialYear::where('is_active', true)->update(['is_active' => false]);
        }

        $financialYear = FinancialYear::create($data);

        // ✅ API RESPONSE
        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Financial year created successfully.',
                'data' => $financialYear
            ], 201);
        }

        // ✅ WEB RESPONSE
        return redirect()
            ->route('admin.financial-years.index')
            ->with('success', 'Financial year created successfully.');
    }

    public function update(Request $request, FinancialYear $financial_year)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255|unique:financial_years,code,' . $financial_year->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $overlapExists = FinancialYear::where('id', '!=', $financial_year->id)
            ->where(function ($q) use ($data) {
                $q->where('start_date', '<', $data['end_date'])
                  ->where('end_date', '>', $data['start_date']);
            })
            ->exists();

        if ($overlapExists) {

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Date range overlaps existing financial year.'
                ], 422);
            }

            return back()
                ->withErrors(['start_date' => 'The selected date range overlaps an existing financial year.'])
                ->withInput();
        }

        if ($data['is_active']) {
            FinancialYear::where('id', '!=', $financial_year->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $financial_year->update($data);

        // ✅ API RESPONSE
        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Financial year updated successfully.',
                'data' => $financial_year
            ]);
        }

        // ✅ WEB RESPONSE
        return redirect()
            ->route('admin.financial-years.index')
            ->with('success', 'Financial year updated successfully.');
    }

    public function destroy(Request $request, FinancialYear $financial_year)
    {
        $financial_year->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Financial year deleted successfully.'
            ]);
        }

        return redirect()
            ->route('admin.financial-years.index')
            ->with('success', 'Financial year deleted successfully.');
    }

    public function toggleStatus(Request $request, FinancialYear $financial_year)
    {
        $financial_year->is_active = !$financial_year->is_active;
        $financial_year->save();

        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Financial year status updated successfully.',
                'data' => [
                    'id' => $financial_year->id,
                    'is_active' => (bool) $financial_year->is_active,
                ]
            ]);
        }

        return back()->with('success', 'Status updated successfully.');
    }
}