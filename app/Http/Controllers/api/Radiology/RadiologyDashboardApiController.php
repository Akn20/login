<?php

namespace App\Http\Controllers\Api\Radiology;

use App\Http\Controllers\Controller;
use App\Models\ScanRequest;
use App\Models\RadiologyReport;

class RadiologyDashboardApiController extends Controller
{
    public function index()
    {
        $total = ScanRequest::count();

        $pending = ScanRequest::where('status', 'Pending')->count();
        $scheduled = ScanRequest::where('status', 'Scheduled')->count();
        $uploaded = ScanRequest::where('status', 'Uploaded')->count();

        $approved = RadiologyReport::where('status', 'Approved')->count();

        return response()->json([
            'total' => $total,
            'pending' => $pending,
            'scheduled' => $scheduled,
            'uploaded' => $uploaded,
            'approved' => $approved
        ]);
    }
}
