<?php

namespace App\Http\Controllers\Api\Radiology;

use App\Http\Controllers\Controller;
use App\Models\ScanUpload;
use App\Models\ScanRequest;
use Illuminate\Http\Request;

class ScanScheduleApiController extends Controller
{
    public function store(Request $request)
    {
        $schedule = \App\Models\ScanSchedule::create($request->all());

        ScanRequest::where('id',$request->scan_request_id)
            ->update(['status'=>'Scheduled']);

        return response()->json(['message'=>'Scheduled']);
    }

    public function index()
    {
        return \App\Models\ScanSchedule::with('request')->get();
    }
}