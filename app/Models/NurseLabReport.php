<?php

namespace App\Models;

use App\Models\LabReport;
use App\Models\RadiologyReport;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class NurseLabReport
{
     public static function all(): Collection
    {
        // Lab Reports
        $labReports = DB::table('lab_reports')
    ->join('sample_collections', 'lab_reports.sample_id', '=', 'sample_collections.id')
    ->join('patients', 'sample_collections.patient_id', '=', 'patients.id')
    ->select(
        'lab_reports.id',
        'lab_reports.status',
        'lab_reports.created_at',
        'patients.first_name as patient'
    )
    ->get()
    ->map(function ($report) {
        return [
            'id' => $report->id,
            'type' => 'lab',
            'patient' => trim(($report->patient ?? '')),
            'status' => $report->status,
            'date' => $report->created_at,
        ];
    });
        // Radiology Reports
        $radiologyReports = RadiologyReport::with('request.patient')->get()->map(function ($report) {
            return [
                'id' => $report->id,
                'type' => 'radiology',
                'patient' => $report->request->patient->first_name ?? 'N/A',
                'status' => $report->status,
                'date' => $report->created_at,
            ];
        });

        return collect($labReports->toArray())
    ->merge(collect($radiologyReports->toArray()))
    ->sortByDesc('date')
    ->values();
    }

    /**
     * Find single report
     */
    public static function find($type, $id)
{
    if ($type === 'lab') {
        return DB::table('lab_reports')
            ->join('sample_collections', 'lab_reports.sample_id', '=', 'sample_collections.id')
            ->join('patients', 'sample_collections.patient_id', '=', 'patients.id')
            ->select(
                'lab_reports.*',
                DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) as patient")
            )
            ->where('lab_reports.id', $id)
            ->first();
    }

    if ($type === 'radiology') {
        return RadiologyReport::with('request.patient')->findOrFail($id);
    }

    abort(404);
}
}