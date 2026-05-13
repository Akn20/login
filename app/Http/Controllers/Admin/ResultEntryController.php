<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SampleCollection;
use App\Models\LabReport;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\TestParameter;
use App\Models\CriticalValueAlert;
use App\Models\AlertAuditLog;
use App\Models\Notification;
use App\Models\LabRequest;
use function logAudit;




class ResultEntryController extends Controller
{
    // ================= INDEX =================
    public function index()
    {


        $samples = SampleCollection::with(['labRequest.patient', 'labReport'])
            ->whereIn('status', ['In Process', 'Completed'])
            ->get();

        foreach ($samples as $sample) {

            $testName = $sample->labRequest->test_name ?? '';

            $sample->parameters = TestParameter::where('test_name', $testName)
                ->with('parameter') // relation
                ->get();
        }

        return view('admin.laboratory.result_entry', compact('samples'));
    }

    // ================= SUBMIT =================
    public function submit(Request $request, $id)
    {
        $sample = SampleCollection::findOrFail($id);

        $testName = strtolower($sample->labRequest->test_name ?? '');

        // ================= VALIDATION =================
        $parameters = TestParameter::where('test_name', $sample->labRequest->test_name)
            ->with('parameter')
            ->get();

        if ($parameters->count() > 0) {

            $rules = [];

            foreach ($parameters as $param) {
                $rules["parameters." . $param->parameter->name] = 'required|numeric';
            }

            $rules['attachments.*'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';

            $request->validate($rules);

        } else {

            $request->validate([
                'report' => 'required|string|min:5',
                'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
            ]);
        }

        // ================= FILE UPLOAD =================
        $files = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('lab_reports', 'public');
                $files[] = $path;
            }
        }

        // ================= DATA =================
        $existingData = $sample->labReport->result_data ?? [];

        $newData = [];

        if ($request->has('parameters')) {
            $newData = $request->parameters;
        } else {
            $newData['report'] = $request->report;
        }

        // Merge old + new
        $data = array_merge($existingData, $newData);


        // Handle attachments separately
        if (!empty($files)) {
            $data['attachments'] = $files;

                    logAudit(
            'report',
            'FILE_UPLOADED',
            $sample->id,
            count($files) . ' attachment(s) uploaded'
        );
        }

        $status = ($request->action == 'draft') ? 'Draft' : 'Completed';

        LabReport::updateOrCreate(
            ['sample_id' => $sample->id],
            [
                'id' => optional($sample->labReport)->id ?? (string) Str::uuid(),
                'result_data' => $data,
                'status' => $status,
                'entered_at' => now()
            ]
        );
        //if error occurs here,run composer dump-autoload
                logAudit(
            'report',
            'RESULT_ENTERED',
            $sample->id,
            'Result entered/updated for sample ID: ' . ($sample->sample_id ?? $sample->id)
        );

        foreach ($newData as $paramName => $value) {

    // Skip non-numeric or attachments
    if ($paramName == 'attachments' || !is_numeric($value)) continue;

    // Get threshold from DB
    $paramConfig = TestParameter::where('test_name', $sample->labRequest->test_name)
        ->whereHas('parameter', function ($q) use ($paramName) {
            $q->where('name', $paramName);
        })
        ->first();

    if ($paramConfig) {

        $min = $paramConfig->parameter->min_value ?? null;
        $max = $paramConfig->parameter->max_value ?? null;

        if (
            ($min !== null && $value < $min) ||
            ($max !== null && $value > $max)
        ) {
            $report = LabReport::where('sample_id', $sample->id)->first();

            $consultation = optional($sample->labRequest)->consultation;
            $doctorStaffId = optional($consultation)->doctor_id;
            $doctorUserId = optional(optional($consultation)->doctor)->user_id;

            $alert = CriticalValueAlert::create([
                'report_id' => $report->id,
                'parameter_name' => $paramName,
                'value' => $value,
                'threshold_min' => $min,
                'threshold_max' => $max,
                'doctor_id' => $doctorStaffId,
                'status' => 'Pending'
            ]);

            if ($doctorUserId) {
                Notification::create([
                    'user_id' => $doctorUserId,
                    'message' => 'Critical value detected for ' . $paramName . ' in sample ' . ($sample->sample_id ?? $sample->id),
                    'is_read' => false,
                    'created_at' => now(),
                ]);
            }

            AlertAuditLog::create([
                'alert_id' => $alert->id,
                'user_id' => Auth::id(),
                'action' => 'CREATED',
                'timestamp' => now()
            ]);

                logAudit(
                'alert',
                'CRITICAL_VALUE_DETECTED',
                $alert->id,
                'Critical value: ' . $paramName . ' = ' . $value
            );
                    }
                }
            }

        if ($status == 'Completed') {

                logAudit(
            'report',
            'REPORT_COMPLETED',
            $sample->id,
            'Report marked as completed'
        );

    // Update Sample
    $sample->status = 'Completed';
    $sample->save();

    
    if ($sample->lab_request_id) {
        LabRequest::where('id', $sample->lab_request_id)
            ->update(['status' => 'Completed']);
    }
}

        return back()->with('success', 'Result saved successfully!');
    }

    // ================= API =================
    public function apiResults($id)
    {
        $report = LabReport::where('sample_id', $id)->first();

        return response()->json([
            'status' => true,
            'data' => $report
        ]);
    }
    public function apiIndex()
    {
        $samples = SampleCollection::with(['labRequest.patient', 'labReport'])
            ->whereIn('status', ['In Process', 'Completed'])
            ->get();

        return response()->json([
            'status' => true,
            'data' => $samples
        ]);
    }
    public function apiSaveDraft(Request $request, $id)
    {
        return $this->handleResult($request, $id, 'Draft');
    }
    public function apiSubmit(Request $request, $id)
    {
        return $this->handleResult($request, $id, 'Completed');
    }
    private function handleResult($request, $id, $status)
    {
        $sample = SampleCollection::findOrFail($id);

        $files = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $files[] = $file->store('lab_reports', 'public');
            }
        }

        $existingData = optional($sample->labReport)->result_data ?? [];
        $data = $request->except(['attachments']);

        // merge data safely
        $data = array_merge($existingData, $data);

        if (!empty($files)) {
            $data['attachments'] = $files;
                logAudit(
                'report',
                'FILE_UPLOADED',
                $sample->id,
                count($files) . ' attachment(s) uploaded via API'
            );
        }

        $report = LabReport::updateOrCreate(
            ['sample_id' => $sample->id],
            [
                'result_data' => $data,
                'status' => $status,
                'entered_at' => now()
            ]
        );

        logAudit(
            'report',
            'RESULT_ENTERED',
            $report->id,
            'Result saved via API'
        );

        foreach ($data as $paramName => $value) {
            if ($paramName == 'attachments' || !is_numeric($value)) {
                continue;
            }

            $paramConfig = TestParameter::where('test_name', $sample->labRequest->test_name)
                ->whereHas('parameter', function ($q) use ($paramName) {
                    $q->where('name', $paramName);
                })
                ->first();

            if ($paramConfig) {
                $min = $paramConfig->parameter->min_value ?? null;
                $max = $paramConfig->parameter->max_value ?? null;

                if (
                    ($min !== null && $value < $min) ||
                    ($max !== null && $value > $max)
                ) {
                    $consultation = optional($sample->labRequest)->consultation;
                    $doctorStaffId = optional($consultation)->doctor_id;
                    $doctorUserId = optional(optional($consultation)->doctor)->user_id;

                    $alert = CriticalValueAlert::create([
                        'report_id' => $report->id,
                        'parameter_name' => $paramName,
                        'value' => $value,
                        'threshold_min' => $min,
                        'threshold_max' => $max,
                        'doctor_id' => $doctorStaffId,
                        'status' => 'Pending'
                    ]);

                    if ($doctorUserId) {
                        Notification::create([
                            'user_id' => $doctorUserId,
                            'message' => 'Critical value detected for ' . $paramName . ' in sample ' . ($sample->sample_id ?? $sample->id),
                            'is_read' => false,
                            'created_at' => now(),
                        ]);
                    }

                    AlertAuditLog::create([
                        'alert_id' => $alert->id,
                        'user_id' => Auth::id(),
                        'action' => 'CREATED',
                        'timestamp' => now()
                    ]);
                }
            }
        }

        if ($status == 'Completed') {
            $sample->status = 'Completed';
            $sample->save();

            if ($sample->lab_request_id) {
                LabRequest::where('id', $sample->lab_request_id)
                    ->update(['status' => 'Completed']);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Result saved successfully'
        ]);
    }
}