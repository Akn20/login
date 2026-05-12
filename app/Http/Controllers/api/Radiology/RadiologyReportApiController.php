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
    $reports = ScanRequest::with(
        'patient',
        'scanType'
    )

    ->where('status', 'Approved')

    ->get()

    ->map(function ($item) {

        return [

            'id' => $item->id,

            'patientName' =>
                $item->patient
                ->first_name
                . ' ' .
                $item->patient
                ->last_name,

            'scanTypeName' =>
                $item->scanType
                ->name ?? '-',

            'bodyPart' =>
                $item->body_part,

            'observations' =>
                $item->observations,

            'findings' =>
                $item->findings,

            'diagnosis' =>
                $item->diagnosis,

        ];

    });

    return response()->json(
        $reports
    );
}
public function show($id)
{
    $report = ScanRequest::with(
        'patient',
        'scanType'
    )
    ->where('id', $id)
    ->where('status', 'Approved')
    ->first();

    if (!$report) {
        return response()->json([
            'message' => 'Report not found'
        ], 404);
    }

    return response()->json([

        'id' => $report->id,

        'patientName' =>
            $report->patient->first_name
            . ' ' .
            $report->patient->last_name,

        'scanTypeName' =>
            $report->scanType->name ?? '-',

        'bodyPart' =>
            $report->body_part,

        'observations' =>
            $report->observations,

        'findings' =>
            $report->findings,

        'diagnosis' =>
            $report->diagnosis,

    ]);
}
}