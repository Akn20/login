<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NurseLabReport;

class LabReportController extends Controller
{
     public function index()
    {
        $reports = NurseLabReport::all();

        return view('admin.nurse.lab_reports.index', compact('reports'));
    }

    public function show($type, $id)
    {
        $report = NurseLabReport::find($type, $id);

        return view('admin.nurse.lab_reports.show', compact('report', 'type'));
    }
}