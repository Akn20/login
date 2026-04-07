<?php

namespace App\Http\Controllers\Admin\Radiology;

use App\Http\Controllers\Controller;
use App\Models\ScanRequest;
use Illuminate\Http\Request;

class RadiologyHistoryController extends Controller
{
    public function index(Request $request)
{
    $query = ScanRequest::with(['patient','scanType']);

    if ($request->patient_id) {
        $query->where('patient_id', $request->patient_id);
    }

    if ($request->scan_type_id) {
        $query->where('scan_type_id', $request->scan_type_id);
    }

    if ($request->date) {
        $query->whereDate('created_at', $request->date);
    }

    $history = $query->latest()->get();

    $patients = \App\Models\Patient::all();
    $scanTypes = \App\Models\ScanType::all();

    return view('admin.radiology.history.index', compact('history','patients','scanTypes'));
}
}
