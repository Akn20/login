<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\FinancialYear;
use App\Models\Transaction;
use Illuminate\Http\Request;

class FinancialYearMappingController extends Controller
{
    public function index(Request $request)
    {
        $hospitals = Hospital::orderBy('name')->get();
        $financialYears = FinancialYear::where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->get();

        $selectedHospitalId = $request->get('hospital_id', optional($hospitals->first())->id);

        $selectedHospital = $selectedHospitalId
            ? Hospital::with('financialYears')->find($selectedHospitalId)
            : null;

        $mappings = $selectedHospital
            ? $selectedHospital->financialYears->keyBy('id')
            : collect();

        return view('admin.financial-years.mapping', compact(
            'hospitals',
            'financialYears',
            'selectedHospital',
            'selectedHospitalId',
            'mappings'
        ));
    }

    /**
     * Store/update mappings.
     * Covers TC_MAP_001–006, 008–010, 012 + DB tests handled by DB schema.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'financial_year_ids' => 'array',
            'financial_year_ids.*' => 'exists:financial_years,id',
            'current_year_id' => 'nullable|exists:financial_years,id',
        ]);

        $hospital = Hospital::findOrFail($data['hospital_id']);
        $selectedIds = $data['financial_year_ids'] ?? [];

        // 1) Block mapping to inactive or deleted FY (TC_MAP_002, TC_MAP_009)
        $invalidFyCount = FinancialYear::whereIn('id', $selectedIds)
            ->where(function ($q) {
                $q->where('is_active', false)
                    ->orWhereNotNull('deleted_at');
            })
            ->count();

        if ($invalidFyCount > 0) {
            return back()
                ->withErrors(['financial_year_ids' => 'Cannot map inactive or deleted financial years.'])
                ->withInput();
        }

        // 2) Check for removal when transactions exist (TC_MAP_004, TC_MAP_010)
        $existingMappings = $hospital->financialYears()->get();
        $toRemove = $existingMappings->whereNotIn('id', $selectedIds)->pluck('id');

        $blockedRemoval = $toRemove->filter(function ($fyId) use ($hospital) {
            return Transaction::where('hospital_id', $hospital->id)
                ->where('financial_year_id', $fyId)
                ->exists();
        });

        if ($blockedRemoval->isNotEmpty()) {
            return back()
                ->withErrors(['financial_year_ids' => 'Cannot remove mapped Financial Years with existing transactions.'])
                ->withInput();
        }

        // 3) Build sync data (create/update mappings, unique pair enforced by DB)
        $syncData = [];
        foreach ($selectedIds as $fyId) {
            $syncData[$fyId] = [
                'is_current' => isset($data['current_year_id']) && $data['current_year_id'] == $fyId,
            ];
        }

        $hospital->financialYears()->sync($syncData);

        return redirect()
            ->route('admin.financial-years.mapping', ['hospital_id' => $hospital->id])
            ->with('success', 'Financial year mapping updated.');
    }

}
