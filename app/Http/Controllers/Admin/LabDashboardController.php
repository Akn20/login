<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\LabRequest;
use App\Models\SampleCollection;
use App\Models\LabReport;
use App\Models\CriticalValueAlert;
use App\Models\EquipmentMaintenance;

class LabDashboardController extends Controller
{
    public function index()
    {
        // 🔹 Pending Test Orders
        $pendingTests = LabRequest::where('status', 'pending')->count();

        // 🔹 Samples Collected Today
        $todaySamples = SampleCollection::whereDate('collection_time', Carbon::today())->count();

        // 🔹 Reports Pending Entry
        $pendingEntry = LabReport::whereIn('status', ['Draft', 'In Progress'])->count();

        // 🔹 Reports Pending Approval
        $pendingApproval = LabReport::where('verification_status', 'Pending')->count();

        // 🔹 Critical Alerts
        $criticalAlerts = CriticalValueAlert::where('status', 'Pending')->count();

        // 🔹 Test Completion Summary
        $completedReports = LabReport::where('status', 'Completed')->count();
        $totalReports = LabReport::count();

        // 🔹 Equipment Alerts
        $maintenanceAlerts = EquipmentMaintenance::where('status', 'Pending')->count();

        // 🔹 Recent Critical Alerts (Table)
        $alerts = CriticalValueAlert::with('report.sample.labRequest.patient')->latest()->take(5)->get();

        // 🔹 Pending Lab Requests list
        $pendingTestsList = LabRequest::with('patient')->where('status', 'pending')->latest('created_at')->take(5)->get();

        // 🔹 Samples Collected Today list
        $todaySamplesList = SampleCollection::with('labRequest.patient')
            ->whereDate('collection_time', Carbon::today())
            ->latest('collection_time')
            ->take(5)
            ->get();

        // 🔹 Reports Pending Entry list
        $pendingEntryReports = LabReport::with('sample.labRequest.patient')
            ->whereIn('status', ['Draft', 'In Progress'])
            ->latest('created_at')
            ->take(5)
            ->get();

        // 🔹 Reports Pending Approval list
        $pendingApprovalReports = LabReport::with('sample.labRequest.patient')
            ->where('verification_status', 'Pending')
            ->latest('updated_at')
            ->take(5)
            ->get();

        // 🔹 Maintenance Alerts list
        $maintenanceAlertsList = EquipmentMaintenance::with('equipment')
            ->where('status', 'Pending')
            ->latest('maintenance_date')
            ->take(5)
            ->get();

        $pendingReports = max($totalReports - $completedReports, 0);
        $completionRate = $totalReports > 0 ? round(($completedReports / $totalReports) * 100) : 0;

        return view('admin.laboratory.dashboard.index', compact(
            'pendingTests',
            'todaySamples',
            'pendingEntry',
            'pendingApproval',
            'criticalAlerts',
            'completedReports',
            'totalReports',
            'maintenanceAlerts',
            'alerts',
            'pendingTestsList',
            'todaySamplesList',
            'pendingEntryReports',
            'pendingApprovalReports',
            'maintenanceAlertsList',
            'pendingReports',
            'completionRate'
        ));
    }
}