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
    // Fetch scan requests for dropdown
    $requests = ScanRequest::with('patient:id,first_name,last_name')
        ->whereIn('status', [
            'Approved',
            'Scheduled',
            'Pending'
        ])
        ->get()
        ->map(function ($item) {

            // SAFE patient name
            $patientName = 'Patient';

            if ($item->patient) {
                $first =
                    $item->patient->first_name ?? '';

                $last =
                    $item->patient->last_name ?? '';

                $patientName =
                    trim($first . ' ' . $last);
            }

            return [
                'id' => $item->id,

                'patientName' =>
                    $patientName,

                'bodyPart' =>
                    $item->body_part ?? '-',
            ];
        });

    // Fetch uploaded files for table
    $uploadedFiles = ScanUpload::with(
        'scanRequest.patient'
    )
        ->get()
        ->map(function ($upload) {

            $patientName = 'Patient';

            if (
                $upload->scanRequest &&
                $upload->scanRequest->patient
            ) {
                $first =
                    $upload->scanRequest
                        ->patient
                        ->first_name ?? '';

                $last =
                    $upload->scanRequest
                        ->patient
                        ->last_name ?? '';

                $patientName =
                    trim($first . ' ' . $last);
            }

            return [
                'id' => $upload->id,

                'patientName' =>
                    $patientName,

                'fileName' =>
                    basename(
                        $upload->file_path
                    ),

                'fileType' =>
                    $upload->file_type ?? '-',

                'fileUrl' =>
                    asset(
                        'storage/' .
                        $upload->file_path
                    ),
            ];
        });

    return response()->json([
        'requests' => $requests,
        'uploadedFiles' => $uploadedFiles,
    ]);
}
}