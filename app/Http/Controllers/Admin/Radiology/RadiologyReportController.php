<?php

namespace App\Http\Controllers\Admin\Radiology;

use App\Http\Controllers\Controller;
use App\Models\RadiologyReport;
use Illuminate\Http\Request;


class RadiologyReportController extends Controller
{
    public function index()
{
    $reports = RadiologyReport::with(['request.patient','request.scanType'])
        ->where('status','Approved')
        ->get();

    return view('admin.radiology.reports.index', compact('reports'));
}

public function show($id)
{
    $report = RadiologyReport::with(['request.patient','request.scanType'])
        ->findOrFail($id);

    return view('admin.radiology.reports.show', compact('report'));
}
}
