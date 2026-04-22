<?php

namespace App\Http\Controllers\Api\Radiology;

use App\Http\Controllers\Controller;
use App\Models\ScanType;
use Illuminate\Http\Request;
class ScanTypeApiController extends Controller
{
    public function index()
    {
        $scanTypes = ScanType::all();

        return response()->json($scanTypes);
    }

    public function store(Request $request)
    {
        $scanType = ScanType::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Scan Type Created',
            'data' => $scanType
        ]);
    }

    public function update(Request $request, $id)
    {
        $scanType = ScanType::findOrFail($id);

        $scanType->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Scan Type Updated'
        ]);
    }

    public function destroy($id)
    {
        ScanType::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Scan Type Deleted'
        ]);
    }
}