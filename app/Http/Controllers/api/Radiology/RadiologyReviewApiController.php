<?php

namespace App\Http\Controllers\Api\Radiology;

use App\Http\Controllers\Controller;
use App\Models\ScanUpload;
use App\Models\ScanRequest;
use Illuminate\Http\Request;

class RadiologyReviewApiController extends Controller
{public function index()
{
    $uploads = \App\Models\ScanUpload::with(
        'scanRequest.patient',
        'scanRequest.scanType'
    )

    // ⭐ IMPORTANT FILTER
    ->whereHas('scanRequest', function ($query) {

        $query->whereIn('status', [
            'Uploaded',
            'Under Review'
        ]);

    })

    ->get()

    ->map(function ($upload) {

        return [

            'id' => $upload->id,

            'patientName' =>
                $upload->scanRequest
                ->patient
                ->first_name
                . ' ' .
                $upload->scanRequest
                ->patient
                ->last_name,

            'scanTypeName' =>
                $upload->scanRequest
                ->scanType
                ->name ?? '-',

            'fileType' =>
                $upload->file_type,

            'fileUrl' =>
                asset(
                    'storage/' .
                    $upload->file_path
                ),

            'filesCount' => 1,

            'reportId' =>
                $upload->scan_request_id,

        ];

    });

    return response()->json(
        $uploads
    );
}
public function updateStatus(Request $request, $id)
{
    $upload = \App\Models\ScanUpload::findOrFail($id);

    $upload->update([
        'status' => $request->status
    ]);

    return response()->json([
        'message' => 'Review submitted'
    ]);
}
public function submitReview(Request $request, $id)
{
    $request->validate([
        'observations' => 'required',
        'findings' => 'required',
        'diagnosis' => 'required',
        'status' => 'required'
    ]);

    ScanRequest::where('id', $id)
        ->update([
            'observations' => $request->observations,
            'findings' => $request->findings,
            'diagnosis' => $request->diagnosis,
            'status' => $request->status
        ]);

    return response()->json([
        'message' => 'Review submitted successfully'
    ]);
}

}