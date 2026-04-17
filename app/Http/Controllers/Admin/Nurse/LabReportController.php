<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NurseLabReport;
use Illuminate\Support\Facades\DB;

class LabReportController extends Controller
{
     public function index()
    {
        $reports = NurseLabReport::all();

        return view('admin.nurse.lab_reports.index', compact('reports'));
    }

    public function show($type, $id)
{
    if ($type === 'lab') {

        $report = DB::table('lab_reports')
            ->join('sample_collections', 'lab_reports.sample_id', '=', 'sample_collections.id')
            ->join('patients', 'sample_collections.patient_id', '=', 'patients.id')
            ->select(
                'lab_reports.*',
                DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) as patient")
            )
            ->where('lab_reports.id', $id)
            ->first();

        return view('admin.nurse.lab_reports.show', [
            'report' => $report,
            'type' => 'lab'
        ]);
    }

    if ($type === 'radiology') {

        $report = \App\Models\RadiologyReport::with('request.patient')->findOrFail($id);

        return view('admin.nurse.lab_reports.show', [
            'report' => $report,
            'type' => 'radiology'
        ]);
    }

    abort(404);
}
}
