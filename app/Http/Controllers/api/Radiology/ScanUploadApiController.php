<?php

namespace App\Http\Controllers\Api\Radiology;

use App\Http\Controllers\Controller;
use App\Models\ScanUpload;
use App\Models\ScanRequest;
use Illuminate\Http\Request;

class ScanUploadApiController extends Controller
{
    public function store(Request $request)
    {
        foreach ($request->file('files') as $file) {

            $path = $file->store('radiology','public');

            ScanUpload::create([
                'scan_request_id' => $request->scan_request_id,
                'file_path' => $path,
                'file_type' => $file->extension(),
            ]);
        }

        // update status
        ScanRequest::where('id',$request->scan_request_id)
            ->update(['status'=>'Uploaded']);

        return response()->json(['message'=>'Uploaded']);
    }

    public function index()
    {
        return ScanUpload::with('scanRequest')->get();
    }
}