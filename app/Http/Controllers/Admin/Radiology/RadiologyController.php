<?php

namespace App\Http\Controllers\Admin\Radiology;

use App\Http\Controllers\Controller;
use App\Models\ScanRequest;
use App\Models\RadiologyReport;

class RadiologyController extends Controller
{
    public function dashboard()
    {
        $totalScans = ScanRequest::count();
        $pending = ScanRequest::where('status', 'Pending')->count();
        $uploaded = ScanRequest::where('status', 'Uploaded')->count();
        $approved = RadiologyReport::where('status', 'Approved')->count();

        return view('admin.radiology.dashboard', compact(
            'totalScans',
            'pending',
            'uploaded',
            'approved'
        ));
    }
}
