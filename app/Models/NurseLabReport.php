<?php

namespace App\Models;

use App\Models\LabReport;
use App\Models\RadiologyReport;
use Illuminate\Support\Collection;


class NurseLabReport
{
     public static function all(): Collection
    {
        // Lab Reports
        $labReports = LabReport::with('sample.patient')->get()->map(function ($report) {
            return (object)[
                'id' => $report->id,
                'type' => 'lab',
                'patient' => $report->sample->patient->first_name ?? 'N/A',
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
            return LabReport::with('sample.patient')->findOrFail($id);
        }

        if ($type === 'radiology') {
            return RadiologyReport::with('request.patient')->findOrFail($id);
        }

        abort(404);
    }
}