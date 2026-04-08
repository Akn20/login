<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\SampleCollection;
use App\Models\LabReport;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\TestParameter;

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

        if ($status == 'Completed') {
            $sample->status = 'Completed';
            $sample->save();
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
        }

        LabReport::updateOrCreate(
            ['sample_id' => $sample->id],
            [
                'result_data' => $data,
                'status' => $status,
                'entered_at' => now()
            ]
        );

        if ($status == 'Completed') {
            $sample->status = 'Completed';
            $sample->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Result saved successfully'
        ]);
    }
}