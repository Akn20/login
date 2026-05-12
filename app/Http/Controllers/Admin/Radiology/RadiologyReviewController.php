<?php

namespace App\Http\Controllers\Admin\Radiology;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScanRequest;
use App\Models\RadiologyReport;
use Illuminate\Support\Facades\Auth;

class RadiologyReviewController extends Controller
{
    public function index()
    {
        $requests = ScanRequest::with(['patient','scanType','uploads'])
    ->where('status','Uploaded')
    ->get();

        return view('admin.radiology.review.index', compact('requests'));
    }

    public function show($id)
    {
        $requestData = ScanRequest::with('patient')->findOrFail($id);
        return view('admin.radiology.review.show', compact('requestData'));
    }

    public function store(Request $request)
    {
        RadiologyReport::create([
            'scan_request_id' => $request->scan_request_id,
            'observations' => $request->observations,
            'findings' => $request->findings,
            'diagnosis' => $request->diagnosis,
            'status' => $request->status,
            'radiologist_id' => Auth::id(),
        ]);

        // Update request status
        ScanRequest::where('id', $request->scan_request_id)
            ->update(['status' => $request->status == 'Approved' ? 'Approved' : 'Rejected']);

        return redirect()->route('admin.radiology.review.index')
            ->with('success','Report Submitted');
    }
}