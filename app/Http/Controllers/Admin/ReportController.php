<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Str;
use App\Models\LabReport;
use App\Models\ReportFile;
use App\Models\FileAuditLog;
use App\Models\SampleCollection;
use App\Models\EquipmentMaintenance;
use App\Models\InventoryUsageLog;
use App\Models\CriticalValueAlert;
use Illuminate\Support\Facades\Storage;
use App\Models\LabRequest;
use Carbon\Carbon;

class ReportController extends Controller
{
    // 📄 List Reports
    public function index(Request $request)
    {
        $query = LabReport::with('sample');

        // 🔍 SEARCH
        if ($request->search) {
            $query->whereHas('sample', function ($q) use ($request) {
                $q->where('sample_id', 'like', '%' . $request->search . '%');
            });
        }

        $reports = $query->latest()->get();

        return view('admin.laboratory.report.index', compact('reports'));
    }

    // ➕ Create Page
    public function create()
    {
        $samples = SampleCollection::where('status', 'Completed')->get();
        return view('admin.laboratory.report.create', compact('samples'));
    }

    // 💾 Store Report
    public function store(Request $request)
    {
        $request->validate([
            'sample_id' => 'required|exists:sample_collections,id',
            'report_file' => 'required|mimes:pdf|max:2048',
            'supporting_files.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        //CHECK IF REPORT ALREADY EXISTS
        $report = LabReport::where('sample_id', $request->sample_id)->first();

        // IF REPORT EXISTS → RESET VERIFICATION
        if ($report) {
            $report->update([
                'verification_status' => 'Pending',
                'verified_by' => null,
                'verified_at' => null,
                'verification_notes' => null,
                'digital_signature' => null,
            ]);
        }

        if (!$report) {
            // CREATE ONLY IF NOT EXISTS
            $report = LabReport::create([
                'sample_id' => $request->sample_id,
                'status' => $request->status,
                'entered_at' => now()
            ]);
        }

        // 🔥 ADD FILES (NOT NEW REPORT)
        $this->storeFile($request->file('report_file'), $report, true);

        if ($request->hasFile('supporting_files')) {
            foreach ($request->file('supporting_files') as $file) {
                $this->storeFile($file, $report, false);
            }
        }

        return redirect()
            ->route('admin.laboratory.report.show', $report->id)
            ->with('success', 'Report uploaded (version updated)');
    }
    // 👁️ View Report
    public function show($id)
    {
        $report = LabReport::with([
            'sample',
            'files' => function ($q) {
                $q->orderBy('version', 'asc');
            }
        ])->findOrFail($id);
        return view('admin.laboratory.report.show', compact('report'));
    }

    // 🗑️ Soft Delete
    public function destroy($id)
    {
        $report = LabReport::findOrFail($id);
        $report->delete();

        return redirect()
            ->route('admin.laboratory.report.index')
            ->with('success', 'Report deleted successfully');
    }

    // ♻️ Restore (if using soft delete view)
    public function restore($id)
    {
        $report = LabReport::withTrashed()->findOrFail($id);
        $report->restore();

        return back()->with('success', 'Report restored successfully');
    }

    // ❌ Force Delete
    public function forceDelete($id)
    {
        $report = LabReport::withTrashed()->findOrFail($id);
        $report->forceDelete();

        return back()->with('success', 'Report permanently deleted');
    }

    // 🗑️ Deleted list
    public function deleted()
    {
        $reports = LabReport::onlyTrashed()->with('sample')->get();
        return view('admin.laboratory.report.deleted', compact('reports'));
    }

    public function edit($id)
    {
        $report = LabReport::findOrFail($id);
        return view('admin.laboratory.report.edit', compact('report'));
    }

    public function updateFiles(Request $request, $id)
    {
        $request->validate([
            'report_file' => 'nullable|mimes:pdf|max:2048',
            'supporting_files.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $report = LabReport::findOrFail($id);

        // Update status
        $report->update([
            'status' => $request->status
        ]);

        if ($report->verification_status === 'Finalized') {
            return back()->with('error', 'Finalized reports cannot be modified');
        }

        // Main file (new version)
        if ($request->hasFile('report_file')) {
            $this->storeFile($request->file('report_file'), $report, true);
        }

        // Supporting files
        if ($request->hasFile('supporting_files')) {
            foreach ($request->file('supporting_files') as $file) {
                $this->storeFile($file, $report, false);
            }
        }


        // RESET IF REJECTED
        if ($report->verification_status === 'Rejected') {
            $report->update([
                'verification_status' => 'Pending',
                'verified_by' => null,
                'verified_at' => null,
                'verification_notes' => null,
                'digital_signature' => null,
            ]);
        }

        // RESET IF NEW FILE UPLOADED
        if ($request->hasFile('report_file') || $request->hasFile('supporting_files')) {
            $report->update([
                'verification_status' => 'Pending',
                'verified_by' => null,
                'verified_at' => null,
                'verification_notes' => null,
                'digital_signature' => null,
            ]);
        }


        return redirect()
            ->route('admin.laboratory.report.show', $id)
            ->with('success', 'New files uploaded (new version)');
    }

    // 🔥 FILE HANDLER (CORE LOGIC)
    private function storeFile($file, $report, $isMain)
    {
        // 📁 Store file
        $path = $file->store('lab_reports/' . $report->sample_id, 'public');

        // 🔢 Versioning
        $latestVersion = ReportFile::where('lab_report_id', $report->id)->max('version') ?? 0;
        $newVersion = $latestVersion + 1;

        // 💾 Save file
        ReportFile::create([
            'lab_report_id' => $report->id,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientOriginalExtension(),
            'version' => $newVersion,
            'is_main' => $isMain,
            'uploaded_by' => auth()->id()
        ]);

        // 📝 Audit log
        FileAuditLog::create([
            'user_id' => auth()->id(),
            'file_name' => $file->getClientOriginalName(),
            'action' => 'UPLOAD',
            'timestamp' => now()
        ]);
    }

    public function verify($id)
    {
        $report = LabReport::findOrFail($id);

        if ($report->status !== 'Completed') {
            return back()->with('error', 'Report must be completed first');
        }

        $report->update([
            'verification_status' => 'Verified',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Report verified');
    }

    public function reject(Request $request, $id)
    {
        $report = LabReport::findOrFail($id);

        $report->update([
            'verification_status' => 'Rejected',
            'verification_notes' => $request->notes,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Report rejected');
    }

    public function sign($id)
    {
        $report = LabReport::findOrFail($id);

        if ($report->verification_status !== 'Verified') {
            return back()->with('error', 'Verify before signing');
        }

        $report->update([
            'digital_signature' => auth()->user()->name
        ]);

        return back()->with('success', 'Signed successfully');
    }

    public function finalize($id)
    {
        $report = LabReport::findOrFail($id);

        if ($report->verification_status !== 'Verified') {
            return back()->with('error', 'Only verified reports can be finalized');
        }

        $report->update([
            'verification_status' => 'Finalized',
            'finalized_at' => now(),
        ]);

        return back()->with('success', 'Report finalized');
    }

    public function dailyReport(Request $request)
{
    $date = $request->date ?? now()->toDateString();

    $reports = LabReport::with([
        'sample.labRequest.patient',
        'sample.labRequest.labTest'
    ])
    ->whereDate('created_at', $date)
    ->where('status', 'Completed')
    ->get();
    
    $total = $reports->count();

    return view('admin.laboratory.report.daily', compact('reports', 'total', 'date'));
}



public function pendingReport(Request $request)
{
    $query = LabReport::with([
        'sample.labRequest.patient',
        'sample.labRequest.labTest'
    ])
    ->where('verification_status', 'Pending'); // ✅ FIXED

   // FILTER
    if ($request->filter == 'Pending') {
        $query->where('verification_status', 'Pending');
    } elseif ($request->filter == 'Finalized') {
        $query->where('verification_status', 'Finalized');
    }

    // SEARCH
    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->whereHas('sample.labRequest.patient', function ($sub) use ($request) {
                $sub->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%');
            })
            ->orWhereHas('sample.labRequest.labTest', function ($sub) use ($request) {
                $sub->where('test_name', 'like', '%' . $request->search . '%');
            });
        });
    }


    $reports = $query->latest()->get();

    return view('admin.laboratory.report.pending', compact('reports'));
}



public function completionSummary(Request $request)
{
    $period = $request->period ?? 'daily';

    switch ($period) {

   case 'daily':
    $latestDate = LabReport::max('created_at');

    $startDate = \Carbon\Carbon::parse($latestDate)->subDays(6)->startOfDay();
    $endDate = \Carbon\Carbon::parse($latestDate)->endOfDay();
    break;

    case 'weekly':
        $startDate = now()->subWeeks(3)->startOfWeek(); // last 4 weeks
        $endDate = now()->endOfWeek();
        break;

    case 'monthly':
        $startDate = now()->subMonths(5)->startOfMonth(); // last 6 months
        $endDate = now()->endOfMonth();
        break;
}

    $completed = LabReport::whereBetween('created_at', [$startDate, $endDate])
        ->where('status', 'completed')
        ->count();

    $pending = LabReport::where('status', 'pending')->count();

    $total = LabReport::count();

    $completionRate = $total > 0 ? round(($completed / $total) * 100) : 0;

  $categoryCounts = LabReport::with('sample.labRequest')
    ->whereBetween('created_at', [$startDate, $endDate])
    ->where('status', 'Completed')
    ->get()
    ->groupBy(function ($r) {

        return optional($r->sample->labRequest)->test_name
            ?? 'Not Assigned';

    })
    ->map(fn($group) => $group->count());

    $dailySummary = LabReport::where('status', 'completed')
    ->whereBetween('created_at', [$startDate, $endDate])
    ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
    ->groupBy('date')
    ->orderBy('date')
    ->get();

    

$weeklySummary = LabReport::where('status', 'Completed')
    ->where('created_at', '>=', now()->subWeeks(4))
    ->selectRaw("
        YEAR(created_at) as year,
        WEEK(created_at, 1) as week,
        COUNT(*) as count
    ")
    ->groupBy('year', 'week')
    ->orderBy('year')
    ->orderBy('week')
    ->get()
    ->map(function ($item) {

        $startOfWeek = Carbon::now()
            ->setISODate($item->year, $item->week)
            ->startOfWeek();

        $endOfWeek = Carbon::now()
            ->setISODate($item->year, $item->week)
            ->endOfWeek();

        $item->label = $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M');

        return $item;
    });

    $monthlySummary = LabReport::where('status', 'Completed')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    return view('admin.laboratory.report.summary', compact(
        'total',
        'completed',
        'pending',
        'completionRate',
        'categoryCounts',
        'dailySummary',
        'weeklySummary',
        'monthlySummary',
        'period'
    ));
}

public function criticalReport(Request $request)
{
    $query = \App\Models\CriticalValueAlert::with([
        'report.sample.labRequest.patient',
        'report.sample.labRequest.labTest'
    ]);

    // FILTER STATUS
    if ($request->status) {
        $query->where('status', $request->status);
    }

    // FILTER DATE
    if ($request->from_date) {
        $query->whereDate('created_at', '>=', $request->from_date);
    }

    if ($request->to_date) {
        $query->whereDate('created_at', '<=', $request->to_date);
    }

    $alerts = $query->latest()->get();

    // FIXED COUNTS (NO FILTER IMPACT)
    $totalCount = \App\Models\CriticalValueAlert::count();

    $unresolvedCount = \App\Models\CriticalValueAlert::where('status', 'Pending')->count();

    $resolvedCount = \App\Models\CriticalValueAlert::where('status', 'Resolved')->count();

    return view('admin.laboratory.report.critical', compact(
        'alerts',
        'totalCount',
        'unresolvedCount',
        'resolvedCount'
    ));
}

public function maintenanceReport(Request $request)
{
    $query = EquipmentMaintenance::with('equipment');

    // FILTER: STATUS
    if ($request->status) {
        $query->where('status', $request->status);
    }

    // FILTER: EQUIPMENT
    if ($request->equipment_id) {
        $query->where('equipment_id', $request->equipment_id);
    }

    $maintenances = $query->latest()->get();

    // ALL EQUIPMENT
    $equipment = EquipmentMaintenance::where('status', 1)->get();

    // OVERDUE (maintenance_date + 30 < today)
    $overdueCount = $maintenances->filter(function ($m) {
        return \Carbon\Carbon::parse($m->maintenance_date)
            ->addDays(30)
            ->isPast() && $m->status != 'Completed';
    })->count();

    // UPCOMING (next 7 days)
    $upcomingCount = $maintenances->filter(function ($m) {
        $nextDate = \Carbon\Carbon::parse($m->maintenance_date)->addDays(30);
        return $nextDate->between(now(), now()->addDays(7));
    })->count();

    return view('admin.laboratory.report.maintenance', compact(
        'maintenances',
        'equipment',
        'overdueCount',
        'upcomingCount'
    ));
}


public function reagentUsageReport(Request $request)
{
    $query = InventoryUsageLog::with('item');
    
    // Filter by date range
    if ($request->from_date) {
        $query->whereDate('created_at', '>=', $request->from_date);
    }
    if ($request->to_date) {
        $query->whereDate('created_at', '<=', $request->to_date);
    }
    
    // Filter by item (reagent)
    if ($request->item_id) {
        $query->where('item_id', $request->item_id);
    }
    
    $logs = $query->latest()->get();
    
    // Get all inventory items (reagents) for filter dropdown
    $reagents = \App\Models\InventoryItem::where('category', 'Reagent')->get();
    
    // Calculate total quantity used
    $totalUsed = $logs->sum('quantity_used');
    
    // Group by reagent for usage pattern analysis
    $usageByReagent = $logs->groupBy('item_id')->map(function ($group) {
        return [
            'total_quantity' => $group->sum('quantity_used'),
            'usage_count' => $group->count(),
            'first_use' => $group->min('created_at'),
            'last_use' => $group->max('created_at')
        ];
    });
    
    // Identify high usage patterns (above average)
    $avgUsage = $usageByReagent->avg('total_quantity') ?? 0;
    $highUsageReagents = $usageByReagent->filter(function ($usage) use ($avgUsage) {
        return $usage['total_quantity'] > $avgUsage;
    });
    
    // Low stock alerts (quantity below threshold)
    $lowStockItems = \App\Models\InventoryItem::where('category', 'Reagent')
        ->whereRaw('quantity <= threshold')
        ->get();

    return view('admin.laboratory.report.reagent', compact(
        'logs',
        'reagents',
        'totalUsed',
        'usageByReagent',
        'highUsageReagents',
        'lowStockItems'
    ));
}

// ================= EXPORT: DAILY REPORT =================
public function dailyReportExport(Request $request)
{
    $date = $request->date ?? now()->toDateString();

    $reports = LabReport::with([
        'sample.labRequest.patient',
        'sample.labRequest.labTest'
    ])
    ->whereDate('created_at', $date)
    ->where('status', 'Completed')
    ->get();

    $filename = 'daily_report_' . $date . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
    ];

    $callback = function() use ($reports) {
        $handle = fopen('php://output', 'w');
        
        // Header row
        fputcsv($handle, ['#', 'Patient Name', 'Test Name', 'Sample ID', 'Status', 'Completion Time']);
        
        // Data rows
        foreach ($reports as $index => $report) {
            $patient = $report->sample->labRequest->patient ?? null;
            $labTest = $report->sample->labRequest->labTest ?? null;
            
            fputcsv($handle, [
                $index + 1,
                $patient ? $patient->first_name . ' ' . $patient->last_name : 'N/A',
                $labTest ? $labTest->test_name : ($report->sample->labRequest->test_name ?? 'N/A'),
                $report->sample->barcode ?? $report->sample_id ?? '-',
                $report->status,
                $report->created_at ? $report->created_at->format('h:i A') : '-'
            ]);
        }
        
        fclose($handle);
    };

    return response()->stream($callback, 200, $headers);
}

// ================= RESOLVE CRITICAL ALERT =================
public function resolveCritical($id)
{
    $alert = \App\Models\CriticalValueAlert::findOrFail($id);
    
    $alert->update([
        'status' => 'Resolved',
        'resolved_by' => auth()->id(),
        'resolved_at' => now()
    ]);

    return back()->with('success', 'Critical alert resolved successfully');
}
    // ================= API: LIST REPORTS =================
    public function apiIndex()
    {
        $reports = LabReport::with([
            'sample',
            'files' => function ($q) {
                $q->orderBy('version', 'asc');
            }
        ])->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $reports
        ]);
    }

    // ================= GET SINGLE =================
    public function apiShow($id)
    {
        $report = LabReport::with([
            'sample',
            'files' => function ($q) {
                $q->orderBy('version', 'asc');
            }
        ])->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $report
        ]);
    }

    // ================= STORE =================
    public function apiStore(Request $request)
    {
        $request->validate([
            'sample_id' => 'required|exists:sample_collections,id',
            'report_file' => 'required|mimes:pdf|max:2048',
            'supporting_files.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $report = LabReport::firstOrCreate(
            ['sample_id' => $request->sample_id],
            [
                'status' => 'Completed',
                'entered_at' => now()
            ]
        );

        // MAIN FILE
        if ($request->hasFile('report_file')) {
            $this->storeFile($request->file('report_file'), $report, true);
        }

        // SUPPORTING FILES
        if ($request->hasFile('supporting_files')) {
            foreach ($request->file('supporting_files') as $file) {
                $this->storeFile($file, $report, false);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Report uploaded successfully'
        ]);
    }

    // ================= UPDATE FILES =================
    public function apiUpdateFiles(Request $request, $id)
    {
        $request->validate([
            'report_file' => 'nullable|mimes:pdf|max:2048',
            'supporting_files.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $report = LabReport::findOrFail($id);

        // UPDATE STATUS
        if ($request->has('status')) {
            $report->update([
                'status' => $request->status
            ]);
        }

        // MAIN FILE (NEW VERSION)
        if ($request->hasFile('report_file')) {
            $this->storeFile($request->file('report_file'), $report, true);
        }

        // SUPPORTING FILES
        if ($request->hasFile('supporting_files')) {
            foreach ($request->file('supporting_files') as $file) {
                $this->storeFile($file, $report, false);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Files updated successfully'
        ]);
    }

    // ================= DELETE (SOFT) =================
    public function apiDelete($id)
    {
        $report = LabReport::findOrFail($id);
        $report->delete();

        return response()->json([
            'status' => true,
            'message' => 'Report deleted successfully'
        ]);
    }

    // ================= DELETED LIST =================
    public function apiDeleted()
    {
        $reports = LabReport::onlyTrashed()
            ->with('sample')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $reports
        ]);
    }

    // ================= RESTORE =================
    public function apiRestore($id)
    {
        $report = LabReport::onlyTrashed()->findOrFail($id);
        $report->restore();

        return response()->json([
            'status' => true,
            'message' => 'Report restored successfully'
        ]);
    }

    // ================= FORCE DELETE =================
    public function apiForceDelete($id)
    {
        $report = LabReport::onlyTrashed()->findOrFail($id);

        // delete files also
        foreach ($report->files as $file) {
            Storage::delete($file->file_path);
        }

        $report->forceDelete();

        return response()->json([
            'status' => true,
            'message' => 'Report permanently deleted'
        ]);
    }
    // ================= VERIFY =================
public function apiVerify($id)
{
    $report = LabReport::findOrFail($id);

    if ($report->status !== 'Completed') {
        return response()->json([
            'status' => false,
            'message' => 'Report must be completed first'
        ]);
    }

    $report->update([
        'verification_status' => 'Verified',
        'verified_by' => auth()->id(),
        'verified_at' => now(),
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Report verified successfully'
    ]);
}

// ================= REJECT =================
public function apiReject(Request $request, $id)
{
    $report = LabReport::findOrFail($id);

    $report->update([
        'verification_status' => 'Rejected',
        'verification_notes' => $request->notes,
        'verified_by' => auth()->id(),
        'verified_at' => now(),
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Report rejected successfully'
    ]);
}

// ================= SIGN =================
public function apiSign($id)
{
    $report = LabReport::findOrFail($id);

    if ($report->verification_status !== 'Verified') {
        return response()->json([
            'status' => false,
            'message' => 'Verify before signing'
        ]);
    }

    $report->update([
        'digital_signature' => auth()->user()->name
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Signed successfully'
    ]);
}

// ================= FINALIZE =================
public function apiFinalize($id)
{
    $report = LabReport::findOrFail($id);

    if ($report->verification_status !== 'Verified') {
        return response()->json([
            'status' => false,
            'message' => 'Only verified reports can be finalized'
        ]);
    }

    $report->update([
        'verification_status' => 'Finalized',
        'finalized_at' => now(),
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Report finalized successfully'
    ]);
}

public function apiDailyReport(Request $request)
{
    $date = $request->date ?? now()->toDateString();

    $reports = LabReport::with([
        'sample.labRequest.patient',
        'sample.labRequest.labTest'
    ])
    ->whereDate('created_at', $date)
    ->where('status', 'Completed')
    ->get();

    return response()->json([
        'status' => true,
        'date' => $date,
        'total' => $reports->count(),
        'data' => $reports
    ]);
}

public function apiPendingReport(Request $request)
{
    $query = LabReport::with([
        'sample.labRequest.patient',
        'sample.labRequest.labTest'
    ]);

    if ($request->filter) {
        $query->where('verification_status', $request->filter);
    }

    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->whereHas('sample.labRequest.patient', function ($sub) use ($request) {
                $sub->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        });
    }

    $reports = $query->latest()->get();

    return response()->json([
        'status' => true,
        'data' => $reports
    ]);
}

public function apiCompletionSummary(Request $request)
{
    $completed = LabReport::where('status', 'Completed')->count();
    $pending = LabReport::where('status', 'Pending')->count();
    $total = LabReport::count();

    return response()->json([
        'status' => true,
        'data' => [
            'total' => $total,
            'completed' => $completed,
            'pending' => $pending,
            'completion_rate' => $total > 0 ? round(($completed / $total) * 100) : 0
        ]
    ]);
}

public function apiCriticalReport(Request $request)
{
    $alerts = CriticalValueAlert::with([
        'report.sample.labRequest.patient',
        'report.sample.labRequest.labTest'
    ])
    ->latest()
    ->get();

    return response()->json([
        'status' => true,
        'total' => $alerts->count(),
        'data' => $alerts
    ]);
}

public function apiMaintenanceReport(Request $request)
{
    $maintenances = EquipmentMaintenance::with('equipment')
        ->latest()
        ->get();

    return response()->json([
        'status' => true,
        'data' => $maintenances
    ]);
}

public function apiReagentUsage()
{
    $logs = InventoryUsageLog::with('item')->get();

    return response()->json([
        'status' => true,
        'total_used' => $logs->sum('quantity_used'),
        'data' => $logs
    ]);
}


}