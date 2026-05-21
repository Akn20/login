<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinancialYear;

class FinancialYearApiController extends Controller
{
    /**
     * Display listing
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => FinancialYear::latest()->get()
        ]);
    }

    /**
     * Store new financial year
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255|unique:financial_years,code',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        // overlap check
        $overlapExists = FinancialYear::where(function ($q) use ($data) {
            $q->where('start_date', '<', $data['end_date'])
              ->where('end_date', '>', $data['start_date']);
        })->exists();

        if ($overlapExists) {
            return response()->json([
                'status' => false,
                'message' => 'Date range overlaps existing financial year.'
            ], 422);
        }

        // only one active
        if ($data['is_active']) {
            FinancialYear::where('is_active', true)
                ->update(['is_active' => false]);
        }

        $financialYear = FinancialYear::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Financial year created successfully',
            'data' => $financialYear
        ], 201);
    }

    /**
     * Show single record
     */
    public function show($id)
    {
        $financialYear = FinancialYear::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $financialYear
        ]);
    }

    /**
     * Update record
     */
    public function update(Request $request, $id)
    {
        $financialYear = FinancialYear::findOrFail($id);

        $data = $request->validate([
            'code' => 'required|string|max:255|unique:financial_years,code,' . $id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $overlapExists = FinancialYear::where('id', '!=', $id)
            ->where(function ($q) use ($data) {
                $q->where('start_date', '<', $data['end_date'])
                  ->where('end_date', '>', $data['start_date']);
            })
            ->exists();

        if ($overlapExists) {
            return response()->json([
                'status' => false,
                'message' => 'Date range overlaps existing financial year.'
            ], 422);
        }

        if ($data['is_active']) {
            FinancialYear::where('id', '!=', $id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $financialYear->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Financial year updated successfully',
            'data' => $financialYear
        ]);
    }

    /**
     * Delete record
     */
    public function destroy($id)
    {
        $financialYear = FinancialYear::findOrFail($id);

        $financialYear->delete();

        return response()->json([
            'status' => true,
            'message' => 'Financial year deleted successfully'
        ]);
    }

    /**
     * Restore deleted record
     */
    public function restore($id)
    {
        FinancialYear::withTrashed()
            ->findOrFail($id)
            ->restore();

        return response()->json([
            'status' => true,
            'message' => 'Financial year restored successfully'
        ]);
    }

    /**
     * Force delete
     */
    public function forceDelete($id)
    {
        FinancialYear::withTrashed()
            ->findOrFail($id)
            ->forceDelete();

        return response()->json([
            'status' => true,
            'message' => 'Financial year permanently deleted'
        ]);
    }
}