<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\SampleCollection;
use App\Models\LabReport;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
class ResultEntryController extends Controller
{
    // 🔹 1. Show Result Entry Page
    public function index()
    {
        $samples = SampleCollection::with('labRequest.patient')
                    ->where('status', 'In Process')
                    ->get();

        return view('admin.laboratory.result_entry', compact('samples'));
    }

    // 🔹 2. Save Draft
    public function saveDraft(Request $request, $id)
    {
        $sample = SampleCollection::findOrFail($id);

        // Store only needed fields
        $data = $request->except(['_token']);

        LabReport::updateOrCreate(
            ['sample_id' => $sample->id],
            [
                'id' => (string) Str::uuid(),
                'result_data' => $data,
                'status' => 'Draft',
                'entered_at' => now()
            ]
        );

        return back()->with('success', 'Draft saved successfully!');
    }

    // 🔹 3. Submit Final Result
    public function submit(Request $request, $id)
    {
        $sample = SampleCollection::findOrFail($id);

        // ✅ Validation
        $request->validate([
            'hemoglobin' => 'nullable|numeric|min:0|max:30',
            'glucose' => 'nullable|numeric|min:0|max:500',
        ]);

        $data = $request->except(['_token']);

        LabReport::updateOrCreate(
            ['sample_id' => $sample->id],
            [
                'id' => (string) Str::uuid(),
                'result_data' => $data,
                'status' => 'Completed',
                'entered_at' => now()
            ]
        );

        // Update sample status also
        $sample->status = 'Completed';
        $sample->save();

        return back()->with('success', 'Result submitted successfully!');
    }
}