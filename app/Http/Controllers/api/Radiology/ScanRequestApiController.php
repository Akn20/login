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
}