<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SampleCollection;
use Illuminate\Support\Str;

class SampleCollectionController extends Controller
{
    // 1. Show Sample Collection Page
    public function index()
    {
        $samples = SampleCollection::with('labRequest.patient', 'labRequest.labTest')
                    ->latest()
                    ->get();

        return view('admin.laboratory.sample-collection', compact('samples'));
    }

    // 2. Collect Sample
    public function collect($id)
    {
        $sample = SampleCollection::findOrFail($id);

        $sample->update([
            'status' => 'Collected',
            'collection_time' => now(),
            'sample_id' => 'SMP-' . rand(1000,9999),
            'barcode' => 'LAB-' . strtoupper(Str::random(6))
        ]);

        return back()->with('success', 'Sample Collected Successfully');
    }

    // 3. Start Processing
    public function startProcessing($id)
    {
        $sample = SampleCollection::findOrFail($id);

        $sample->update([
            'status' => 'In Process'
        ]);

        return back()->with('success', 'Processing Started');
    }

    // 4. Complete Test
    public function complete($id)
    {
        $sample = SampleCollection::findOrFail($id);

        $sample->update([
            'status' => 'Completed'
        ]);

        // Update Lab Request only when completed
        $sample->labRequest->update([
            'status' => 'Completed'
        ]);

        return back()->with('success', 'Test Completed');
    }

    // 5. Reject Sample
    public function reject(Request $request, $id)
    {
        $sample = SampleCollection::findOrFail($id);

        $sample->update([
            'status' => 'Rejected',
            'rejection_reason' => $request->reason
        ]);

        $sample->labRequest->update([
            'status' => 'Pending'
        ]);

        return back()->with('error', 'Sample Rejected');
    }

    //API METHODS
    // API GET all samples
    
   public function apiIndex()
    {
        $samples = SampleCollection::all();

        return response()->json([
            'status' => true,
            'data' => $samples
        ]);
    }

    // API GET pending samples
    public function apiPending()
    {
        $samples = SampleCollection::with('labRequest.patient')
                    ->where('status', 'Pending')
                    ->get();

        return response()->json($samples);
    }

    // API COLLECT sample
    public function apiCollect($id)
    {
        $sample = SampleCollection::findOrFail($id);

        $sample->update([
            'status' => 'Collected',
            'collection_time' => now(),
            'sample_id' => 'SMP-' . rand(1000,9999),
            'barcode' => 'LAB-' . strtoupper(Str::random(6))
        ]);

        return response()->json(['message' => 'Sample Collected']);
    }

    // API UPDATE status
    public function apiUpdateStatus(Request $request, $id)
    {
        $sample = SampleCollection::findOrFail($id);

        $sample->update([
            'status' => $request->status
        ]);

        return response()->json(['message' => 'Status Updated']);
    }

    // API REJECT sample
    public function apiReject(Request $request, $id)
    {
        $sample = SampleCollection::findOrFail($id);

        $sample->update([
            'status' => 'Rejected',
            'rejection_reason' => $request->reason
        ]);

        return response()->json(['message' => 'Sample Rejected']);
    }
}