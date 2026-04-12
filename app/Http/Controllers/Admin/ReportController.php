<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Str;
use App\Models\LabReport;
use App\Models\ReportFile;
use App\Models\FileAuditLog;
use App\Models\SampleCollection;
use Illuminate\Support\Facades\Storage;

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

        // 🔥 CHECK IF REPORT ALREADY EXISTS
        $report = LabReport::where('sample_id', $request->sample_id)->first();

        if (!$report) {
            // CREATE ONLY IF NOT EXISTS
            $report = LabReport::create([
                'sample_id' => $request->sample_id,
                'status' => 'Completed',
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
            'report_id' => $report->id,
    'sample_id' => optional($report->sample)->sample_id,
            'user_id' => auth()->id(),
            'file_name' => $file->getClientOriginalName(),
            'action' => 'UPLOAD',
            'timestamp' => now()
        ]);
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


}