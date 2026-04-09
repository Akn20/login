<?php

namespace App\Http\Controllers\Api\Radiology;

use App\Http\Controllers\Controller;
use App\Models\ScanUpload;
use App\Models\ScanRequest;
use Illuminate\Http\Request;

class RadiologyReportApiController extends Controller
{
    public function store(Request $request)
    {
        $report = \App\Models\RadiologyReport::create($request->all());

        ScanRequest::where('id',$request->scan_request_id)
            ->update(['status'=>'Approved']);

        return response()->json(['message'=>'Report Created']);
    }

    public function index()
    {
        return \App\Models\RadiologyReport::with('request')->get();
    }
}