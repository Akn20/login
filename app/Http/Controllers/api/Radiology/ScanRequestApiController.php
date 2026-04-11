<?php

namespace App\Http\Controllers\Api\Radiology;

use App\Http\Controllers\Controller;
use App\Models\ScanRequest;
use Illuminate\Http\Request;

class ScanRequestApiController extends Controller
{
    public function index()
    {
        return ScanRequest::with(['patient','scanType'])->get();
    }

    public function store(Request $request)
    {
        $data = ScanRequest::create($request->all());
        return response()->json(['message'=>'Created','data'=>$data]);
    }

    public function show($id)
    {
        return ScanRequest::with(['patient','scanType','uploads'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = ScanRequest::findOrFail($id);
        $data->update($request->all());

        return response()->json(['message'=>'Updated']);
    }

    public function destroy($id)
    {
        ScanRequest::findOrFail($id)->delete();
        return response()->json(['message'=>'Deleted']);
    }
    public function history(Request $request)
{
    $query = \App\Models\ScanRequest::with(
        'patient',
        'scanType'
    );

    // Filter by patient
    if ($request->patient_id) {
        $query->where(
            'patient_id',
            $request->patient_id
        );
    }

    // Filter by scan type
    if ($request->scan_type_id) {
        $query->where(
            'scan_type_id',
            $request->scan_type_id
        );
    }

    // Filter by date
    if ($request->date) {
        $query->whereDate(
            'created_at',
            $request->date
        );
    }

    $rows = $query
        ->latest()
        ->get()
        ->map(function ($item) {

            return [

                'id' => $item->id,

                'patient_name' =>
                    $item->patient->first_name
                    . ' ' .
                    $item->patient->last_name,

                'scan_type_name' =>
                    $item->scanType->name ?? '-',

                'status' =>
                    $item->status,

                'date' =>
                    $item->created_at
                        ->format('Y-m-d'),

            ];

        });

    return response()->json(
        $rows
    );
}
}