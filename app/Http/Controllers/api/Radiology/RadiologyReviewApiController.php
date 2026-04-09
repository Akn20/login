<?php

namespace App\Http\Controllers\Api\Radiology;

use App\Http\Controllers\Controller;
use App\Models\ScanUpload;
use App\Models\ScanRequest;
use Illuminate\Http\Request;

class RadiologyReviewApiController extends Controller
{
    public function index()
    {
        return ScanRequest::with(['patient','uploads'])
            ->where('status','Uploaded')
            ->get();
    }

    public function updateStatus($id, Request $request)
    {
        $req = ScanRequest::findOrFail($id);

        $req->update([
            'status' => $request->status
        ]);

        return response()->json(['message'=>'Status Updated']);
    }
}